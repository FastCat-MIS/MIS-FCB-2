# Teller Booking Flow

## 0. Seat Selection (Frontend)

```
GET /schedule-seats  →  Seat/GetScheduleSeatsAvailabilityAction  (called by frontend to display available seats)
```

---

## 1. Add Passengers / Vehicles (Temp)

```
POST /booked-passengers  →  BookedPassenger/CreateBookedPassengerAction
POST /booked-vehicles    →  BookedVehicle/CreateBookedVehicleAction
```

- First call creates a `TempBooking` (identified by `serial_no`)
- Subsequent calls with same `serial_no` just attach to existing `TempBooking`
- Seat gets locked in `schedule_seat_locks` (expires in 30 min)
- Race condition (2 tellers booking same seat at the same time) is eliminated by a DB unique constraint on `(schedule_id, seat_id, travel_date)` — only one insert wins, the other gets a 409

```
TempBooking                (Model: Models/Teller/TempBooking)
  └── temp_booked_passengers  (Model: Models/Teller/BookedPassenger)
  └── temp_booked_vehicles    (Model: Models/Teller/BookedVehicle)
```

---

## 2. Process Payment (Temp → Permanent)

```
POST /payment  →  Payment/CreatePaymentAction
```

- Finds `TempBooking` by `serial_no`
- Creates permanent `Booking` (gets a `booking_number` e.g. `7EA5-00001`)
- Moves passengers → `booked_passengers`
- Moves vehicles → `booked_vehicles`
- Seat locks → `expires_at` set to `NULL` (permanent)
- Deletes `TempBooking`
- Creates `BookingPayment`

```
Booking (permanent)        (Model: Models/Teller/Booking)
  └── booked_passengers       (Model: Models/Teller/PermanentBookedPassenger)
  └── booked_vehicles         (Model: Models/Teller/PermanentBookedVehicle)
  └── booking_payments        (Model: Models/Teller/BookingPayment)
```

---

## 3. Print Documents

```
GET /generate-ticket   →  Ticket/GenerateTicketAction   (thermal, per passenger)
GET /generate-eticket  →  Ticket/GenerateETicketAction  (paper overlay, per passenger)
GET /generate-waybill  →  Waybill/GenerateWaybillAction (A4, per vehicle)
```
