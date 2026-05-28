# Teller Booking System

## Overview

The teller booking system uses a **two-stage booking flow** with centralized snapshots and permanent seat locking to prevent double-booking across multiple stations.

---

## How It Works

### 1. **Two-Stage Booking Flow**

```
┌─────────────────┐         ┌──────────────┐         ┌─────────────────┐
│  TEMP BOOKING   │ ──────> │   PAYMENT    │ ──────> │ PERMANENT BOOKING│
│  (Temporary)    │         │  (Complete)  │         │  (Confirmed)     │
└─────────────────┘         └──────────────┘         └─────────────────┘
```

**Stage 1: Temporary Booking**
- Customer selects passengers, seats, and/or vehicles
- Data saved in `temp_bookings`, `temp_booked_passengers`, `temp_booked_vehicles`
- Seats are **locked** (expires in 30 minutes if no payment)
- Generates temporary `serial_no` (e.g., BK-123)

**Stage 2: Payment & Transfer**
- Customer completes payment
- System generates new `booking_number` (hexadecimal: 20260527-A3F2E8B1)
- Data transferred to permanent tables: `bookings`, `booked_passengers`, `booked_vehicles`
- Seat locks updated: `serial_no` → `booking_number` and marked permanent (expires_at = null)
- Temp records deleted

---

### 2. **Booking Number Generation**

**Two different identifiers are used:**

| Stage | Identifier | Format | Purpose | Example |
|-------|-----------|--------|---------|---------|
| **Temporary** | `serial_no` | Simple string | Track booking during process | BK-123, TEMP-001 |
| **Permanent** | `booking_number` | Hex (YYYYMMDD-XXXXXXXX) | Unique permanent reference | 20260527-A3F2E8B1 |

**Why two identifiers?**
- ✅ **Temporary bookings** use simple `serial_no` for easy tracking during booking process
- ✅ **Permanent bookings** get unique hex `booking_number` generated at payment
- ✅ `serial_no` is **discarded** after payment (we don't care about it anymore)
- ✅ `booking_number` is the **official record** for confirmed bookings

**Booking Number Format:**
```
20260527-A3F2E8B1
└──┬───┘ └───┬───┘
   │         └─ 8-char hex (4.2B combinations/day)
   └─────────── Date (YYYYMMDD)
```

**Generation:**
```php
use App\Helpers\BookingNumberGenerator;

$bookingNumber = BookingNumberGenerator::generate();
// Output: 20260527-B6F0485E
```

---

## Seat Locking System

### Why Keep Seat Locks Forever?

Instead of deleting seat locks after payment, we **keep them permanently** as a single source of truth:

```
schedule_seat_locks
├── Temporary Locks (expires_at = timestamp)  → Pending bookings
└── Permanent Locks (expires_at = null)       → Confirmed bookings
```

**Benefits:**
- ✅ Single query to check seat availability
- ✅ Historical audit trail (never lose booking records)
- ✅ Real-time accuracy across all stations
- ✅ No duplicate checks needed

**Auto-Cleanup:**
- Expired temp locks (abandoned bookings) auto-deleted every 5 minutes
- Permanent locks (completed bookings) kept forever

---

## Centralized Snapshots

### Problem We Solved
Previously, snapshots (schedule, route, vessel, rates) were duplicated in every passenger and vehicle record.

**Before:**
```
temp_booked_passengers
├── serial_no (duplicate!)
├── schedule_snapshot (duplicate!)
├── route_snapshot (duplicate!)
└── vessel_snapshot (duplicate!)
```

**After:**
```
temp_bookings (ONE record per booking)
├── serial_no ✅ (temporary reference, discarded after payment)
├── schedule_snapshot ✅
├── route_snapshot ✅
└── vessel_snapshot ✅

temp_booked_passengers (linked via FK)
└── temp_booking_id (FK only)
```

**Benefits:**
- ✅ No data redundancy
- ✅ Easier maintenance
- ✅ Better performance
- ✅ Single source of truth

---

## API Endpoints

### **Teller Booking Endpoints**

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/teller-booking/booked-passengers` | POST | Create temporary passenger booking |
| `/teller-booking/booked-vehicles` | POST | Create temporary vehicle booking |
| `/teller-booking/payment` | POST | Complete payment & transfer to permanent |
| `/teller-booking/completed-bookings` | GET | List all completed bookings (with booking_number) |
| `/teller-booking/bookings` | GET | List all temp bookings |
| `/teller-booking/bookings/{serial_no}` | GET | Get single temp booking details |
| `/teller-booking/booked-seats` | GET | Get seat availability for schedule |

### **Check Seat Availability**

```http
GET /teller-booking/booked-seats?schedule_id=5&travel_date=2026-05-27
```

**Response:**
```json
{
  "status": 200,
  "success": true,
  "data": {
    "total_locked": 3,      // Pending bookings
    "total_booked": 12,     // Confirmed bookings
    "total_unavailable": 15,
    "locked_seats": [...],
    "booked_seats": [...],
    "seat_status_map": {
      "12": { "seat_id": 12, "status": "booked" },
      "145": { "seat_id": 145, "status": "locked" }
    }
  }
}
```

---

## User Flows

### **Teller Station (Counter Booking)**

1. **Customer arrives at counter**
2. Teller searches for available schedules
3. Checks seat availability via `/booked-seats`
4. Books passengers via `/booked-passengers` (seats auto-locked)
5. Books vehicles via `/booked-vehicles` (optional)
6. Customer pays
7. Teller processes payment via `/payment`
8. System transfers to permanent tables
9. Receipt generated

**Race Condition Protection:**
- Database UNIQUE constraint on (schedule_id, seat_id, travel_date)
- If two tellers try to book same seat, second one gets error 409

---

### **Public/Online Booking (Future)**

Same flow as teller, but:
- Uses `booking_origin = 'public'`
- Users can see only their own bookings
- Payment gateway integration (e.g., PayMongo, GCash)
- Email/SMS confirmation

**Endpoints:**
```
POST /public/bookings/passengers    (same logic as teller)
POST /public/bookings/vehicles
POST /public/bookings/payment
GET  /public/bookings/my-bookings
GET  /public/bookings/{serial_no}
```

**Differences:**
- Teller: `locked_by_type = 'teller'`
- Public: `locked_by_type = 'public'`
- Same seat locking system prevents conflicts

---

### **Merchant/Institutional Accounts**

Merchants (e.g., travel agencies, companies) get:
- Bulk booking capabilities
- Institutional discounts
- Monthly billing

**Booking Flow:**
```
1. Merchant books multiple passengers
2. Snapshots include institutional_account_snapshot
3. Payment deferred or invoiced monthly
4. Same seat locking prevents double-booking
```

**Endpoints:**
```
POST /merchant/bookings/passengers
POST /merchant/bookings/vehicles
POST /merchant/bookings/bulk          (multiple passengers at once)
GET  /merchant/bookings/reports
```

---

## Database Structure

### **Temp Tables (Before Payment)**
```
temp_bookings
├── temp_booking_id (PK)
├── serial_no (UNIQUE, temporary reference like BK-123)
├── schedule_snapshot
├── route_snapshot
├── vessel_snapshot
└── booking_origin ('teller'|'public'|'merchant')

temp_booked_passengers
├── booked_passenger_id (PK)
├── temp_booking_id (FK)
└── [passenger fields]

temp_booked_vehicles
├── booked_vehicle_id (PK)
├── temp_booking_id (FK)
└── [vehicle fields]

schedule_seat_locks (temporary)
├── seat_id
├── schedule_id
├── travel_date
├── serial_no (links to temp_bookings)
└── expires_at (30 min)
```

### **Permanent Tables (After Payment)**
```
bookings
├── booking_id (PK)
├── booking_number (hex format)
├── schedule_snapshot
├── route_snapshot
├── vessel_snapshot
└── booking_origin

booked_passengers
├── booked_passenger_id (PK)
├── booking_id (FK)
└── [passenger fields]

booked_vehicles
├── booked_vehicle_id (PK)
├── booking_id (FK)
└── [vehicle fields]

schedule_seat_locks (permanent)
├── seat_id
├── schedule_id
├── travel_date
├── serial_no (updated to booking_number after payment)
└── expires_at (NULL = permanent)
```

---

## Key Features

### ✅ **Race Condition Protection**
- Database UNIQUE constraint prevents double-booking
- Atomic seat locking at database level

### ✅ **Single Source of Truth**
- Snapshots stored once in bookings table
- Seat locks in one table (temp + permanent)

### ✅ **Historical Audit Trail**
- Permanent seat locks never deleted
- All bookings traceable via booking_number (hex format)

### ✅ **Multi-Channel Support**
- Teller stations
- Public online booking
- Merchant/institutional accounts

### ✅ **Performance Optimized**
- Fast list endpoint (essential fields only)
- Detailed show endpoint (full relationships)
- Indexed queries on serial_no (temp), booking_number (permanent), schedule_id, travel_date

---

## Summary

The teller booking system provides:

1. **Centralized snapshots** - No data duplication
2. **Permanent seat locks** - Single source of truth for availability
3. **Two-stage flow** - Temp → Payment → Permanent
4. **Race condition proof** - Database constraints prevent conflicts
5. **Multi-channel ready** - Works for teller, public, and merchants

**Simple principle:** Book → Lock seats → Pay → Transfer → Keep forever
