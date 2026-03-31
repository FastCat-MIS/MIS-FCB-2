# Development Report: `refactor-structure-v2` Branch

**Branch:** `refactor-structure-v2`
**Base Branch:** `main`
**Date Range:** Mar 24 - Mar 31, 2026
**Total Commits:** 12
**Files Changed:** 89
**Total Insertions:** 7,862 | **Total Deletions:** 1,289
**Last Commit:** Implementation of port observer in is_active variable related to routes and schedules

---

## Executive Summary

This branch represents a significant refactoring of the database schema and application structure, primarily focused on:

1. **Status Field Standardization** - Converting all `status` string fields to boolean `is_active` fields across the entire application
2. **Migration Consolidation** - Merging 17 redundant migration files into base migrations for a cleaner migration structure
3. **Observer Pattern Implementation** - Adding cascade update logic for related entities
4. **Vessel Accommodation Enhancement** - New controller and CRUD for managing vessel amenities
5. **Port Operations Refactoring** - Changing from model binding to ID-based query operations
6. **File Storage Integration** - Implementing public storage for institutional and merchant logos

---

## Detailed Commit Breakdown

### 1. **e72cbb9** (Mar 24, 10:16 AM) - Initial Data Type Changes to Status

**Files Changed:** 3
**Insertions:** 3 | **Deletions:** 3

**Objective:** Initial conversion of status field data types to prepare for boolean migration.

**Changes:**

- **CreateVesselAction** - Modified status validation from `'string|max:20'` to `'nullable|in:0,1,2,3'` (numeric enum)
- **create_vessels_table migration** - Changed status column from `string(20)` with default `'active'` to `unsignedTinyInteger` with default `0`
- **create_vessel_accommodations_table migration** - Fixed seats column type from `integer` to `unsignedInteger` to match database conventions

**Status Values Mapping:**

- 0 = Default/Inactive
- 1 = Active
- 2 = Pending
- 3 = Archived

---

### 2. **735422e** (Mar 24, 10:34 AM) - Composer Dependency Updates

**Files Changed:** 6
**Insertions:** 7,401 | **Deletions:** 512

**Objective:** Update autoloader cache after potential dependency changes.

**Changes:**

- Full refresh of composer autoloader files
- Updated `autoload_classmap.php` - Added 2,047 class mappings
- Updated `autoload_static.php` - Added comprehensive static class mappings
- Updated `installed.json` and `installed.php` - Dependency version tracking
- Changes to `autoload_files.php` and `autoload_psr4.php` - Namespace and file path updates

**Note:** Large commit primarily containing vendor dependency metadata changes.

---

### 3. **e0062a5** (Mar 24, 11:26 AM) - File Storage Implementation for Logos

**Files Changed:** 6
**Insertions:** 75 | **Deletions:** 22

**Objective:** Integrate public file storage for institutional accounts and merchant logos.

**New Functionality:**

**Institutional Accounts (CreateInstitutionalAccountAction):**

```php
if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
    $validated['image'] = $data['logo']->store('ia-logos', 'public');
}
```

- Stores uploaded logos in `storage/app/public/ia-logos/` directory
- Controller validates file type (jpg, jpeg, png, webp) with 2MB max size

**Institutional Accounts (UpdateInstitutionalAccountAction):**

- Added same logo storage logic for updates
- Allows logo replacement on account updates

**Merchants (CreateMerchantAction):**

- Similar implementation for merchants
- Stores logos in `storage/app/public/merchant-logos/`

**Merchants (UpdateMerchantAction):**

- Logo update support for merchant records

**Controller Updates (InstitutionalAccountController & MerchantController):**

- Added file validation in `store()` and `update()` methods
- Validates: image MIME types, max size 2048KB
- Passes validated files to action classes

**Database Interaction:**

- Stores file path in existing `image` column
- Publicly accessible URLs generated from storage path

---

### 4. **706cd10** (Mar 26, 18:23 PM) - Comprehensive Status to is_active Migration

**Files Changed:** 16
**Insertions:** 87 | **Deletions:** 43

**Objective:** Refactor entire application to use boolean `is_active` field instead of string `status`.

**Database/Model Layer Changes:**

**Models Updated:**

- **Route.php** - Added `is_active` to fillable array
- **Schedule.php** - Added `is_active` field, consolidated fillable array, removed comment clutter
- Updated seeders for both models to use boolean/numeric values

**Action Layer Changes:**

**Discount Actions (create/update variants for IA and Merchant):**

- Changed `'status' => 'nullable|in:active,inactive'`
- To: `'status' => 'nullable|in:0,1,2,3'`
- Aligned validation across all discount types

**Schedule Actions:**

- **CreateScheduleAction:**
    - Added `is_active` field validation: `'sometimes|required|boolean'`
    - Added `status` field validation: `'sometimes|required|in:0,1,2,3'`
    - Default status now set to `1` (active) instead of string `'active'`

- **UpdateScheduleAction:**
    - Added same validations
    - Includes `is_active` in response data

**Routes & Queries:**

- **GetRoutesWithPortsAndSchedulesAction** - Enhanced response to include:
    - `is_active` field for route objects
    - `is_active` field for schedule objects
    - Added `arrival_time` field to schedule responses

**Seeder Updates:**

**PortSeeder:**

- Expanded from 4 ports to 19 ports (added new routes)
- Port list: Batangas, Calapan, Bulalacao, Caticlan, Dumangas, Banago, Dumaguete, Dapitan, San Carlos, Toledo, Cebu, Tubigon, Matnog, Dap Dap, Maasin, Surigao, Zamboanga, Basilan

**RoutesTableSeeder:**

- Changed from random port connections to specific port pairs:
    - Batangas ↔ Calapan
    - Bulalacao ↔ Caticlan
    - Dumangas ↔ Banago
    - Dumaguete ↔ Dapitan
    - San Carlos ↔ Toledo
    - Cebu ↔ Tubigon
    - Matnog ↔ Dap Dap
    - Maasin ↔ Surigao
    - Zamboanga ↔ Basilan

**SchedulesTableSeeder:**

- Changed status from string values to numeric: `'active'` → `1`
- Added `arrival_time` field to all schedules (7am, 12pm, 3pm departures)
- Added `is_active` field with value `1` for all new schedules

**UsersTableSeeder:**

- Changed status from `'active'` string to `true` boolean

**IADiscountsSeeder & MerchantDiscountsSeeder:**

- Changed `status` from `'active'` to `1`

---

### 5. **2274cb7** (Mar 26, 18:24 PM) - Redundant Migration Deletion

**Files Changed:** 17
**Insertions:** 0 | **Deletions:** 623

**Objective:** Remove duplicate migration files that were replaced by consolidated base migrations.

**Deleted Migrations (17 files):**

1. `2025_09_21_175650_create_schedules_table.php` - Replaced by consolidated schedule migration
2. `2025_09_21_211833_add_middle_name_to_users_table.php` - User migration consolidated
3. `2025_10_14_043106_create_ports_table.php` - Old ports migration
4. `2025_11_18_004154_add_ramp_status_to_ports_table.php` - Port addition consolidated
5. `2025_11_21_064649_unify_schedule_mapping.php` - Large 170-line migration consolidated
6. `2025_12_01_014415_remove_vessel_from_schedules_table.php` - Schedule refactor consolidated
7. `2025_12_01_213604_add_vessel_id_to_schedules_table.php` - Schedule vessel field consolidated
8. `2025_12_01_214759_add_status_to_schedules_table.php` - Schedule status field consolidated
9. `2025_12_02_003050_add_port_id_to_schedules.php` - Large 73-line port_id addition consolidated
10. `2025_12_01_add_discount_id_to_passenger_types_table.php` - Passenger type discount consolidated
11. `2025_12_04_084035_update_passenger_types_table.php` - Passenger type update consolidated
12. `2025_12_04_delete_discount_id_on_passenger_type_table.php` - Passenger type cleanup consolidated
13. `2025_12_04_add_rows_columns_to_vessel_accommodations_table.php` - Vessel accommodation update consolidated
14. `2026_01_001317_add_deleted_at_to_vessel_seats_table.php` - Soft deletes for seats consolidated
15. `2026_01_deleted_at_to_vessel_facility_labels_table.php` - Soft deletes for facility labels consolidated
16. `2026_02_10_044839_add_route_id_to_vessels_table.php` - Vessel routes consolidated
17. `2026_02_10_045900_add_visibility_to_schedules_table.php` - Schedule visibility consolidated

**Benefit:** Eliminates migration clutter and provides single source of truth for each table structure.

---

### 6. **3427070** (Mar 26, 18:26 PM) - Base Migration Consolidation

**Files Changed:** 10
**Insertions:** 99 | **Deletions:** 15

**Objective:** Merge all deleted migration functionality into base migration files.

**Modified Base Migrations:**

**2025_09_14_043106_create_ports_table.php:**

- Added ramp_status field (from deleted migration)
- Added is_active field
- Total: +27 lines

**2025_09_21_175649_create_routes_table.php:**

- Added is_active field
- Refactored route table structure
- Total: +7 insertions, -7 deletions

**2025_09_21_184604_update_users_table.php:**

- Added middle_name field (from deleted migration)
- Added is_active support for users
- Total: +7, -7 changes

**2025_09_21_233522_create_vessels_table.php:**

- Minor structural updates
- Changed status field to numeric enum

**2025_10_02_174604_create_passenger_types_table.php:**

- Added discount_id field (from deleted migration)
- Added is_active field support
- Total: +6 insertions

**2025_10_22_175650_create_schedules_table.php:**

- **Major consolidation** - merged from multiple deleted schedule migrations
- Added: vessel_id, port_id, status, visibility, is_active fields
- Added: arrival_time, departure_time fields
- Total: +38 insertions

**2025_12_03_173443_create_vessel_accommodations_table.php:**

- Consolidated rows/columns additions
- Added is_active support
- Total: +11, -5 changes

**2026_03_03_081940_create_ia_discounts_table.php:**

- Minor field type adjustments
- Total: +2, -1 changes

**2026_03_10_015419_create_merchant_discounts_table.php:**

- Minor field adjustments

**2026_03_12_17_014454_add_soft_deletes_to_all_tables.php:**

- **New unified soft deletes migration**
- Adds deleted_at columns to all tables requiring soft deletes
- Replaces 3 individual soft delete migrations
- Total: +12 insertions

**Result:** Base migrations now contain all table creation logic with all fields defined in one place.

---

### 7. **0b5b098** (Mar 30, 14:16 PM) - CRUD Actions Status Field Updates

**Files Changed:** 13
**Insertions:** 14 | **Deletions:** 14

**Objective:** Update all action classes to use new `is_active` boolean field.

**Updated Actions:**

**Discount Actions:**

- UpdateDiscountAction - Changed validation to numeric status
- CreateIADiscountAction - Updated validation
- UpdateIADiscountAction - Updated validation
- CreateMerchantDiscountAction - Updated validation
- UpdateMerchantDiscountAction - Updated validation with formatting cleanup

**Account Actions:**

- CreateInstitutionalAccountAction - Updated status validation (but still uses string for now)
- UpdateInstitutionalAccountAction - Updated status validation

**Merchant Actions:**

- CreateMerchantAction - Updated status validation
- UpdateMerchantAction - Updated status validation

**Passenger Type Actions:**

- CreatePassengerTypeAction - Updated validation
- UpdatePassengerTypeAction - Updated validation

**Rate Actions:**

- CreateAccommodationRateAction - Updated validation
- UpdateAccommodationRateAction - Updated validation
- CreateVehicleRateAction - Updated validation
- UpdateVehicleRateAction - Updated validation

**Changes:** All actions now expect numeric status values (0,1,2,3) instead of string enum (active/inactive).

---

### 8. **a5a32c2** (Mar 30, 14:17 PM) - Migration and Seeder Status Field Updates

**Files Changed:** 10
**Insertions:** 16 | **Deletions:** 14

**Objective:** Update all migration table definitions and seeders to reflect new `is_active` field.

**Migration Updates:**

- PassengerTypes table - Added is_active field
- InstitutionalAccounts table - Updated status field type
- VehicleRates table - Added is_active field
- AccommodationRates table - Added is_active field
- Merchants table - Updated status field type

**Seeder Updates:**

- AccommodationRatesSeeder - Updated status values
- InstitutionalAccountsSeeder - Updated status to boolean/numeric
- MerchantsSeeder - Updated status to boolean/numeric
- PassengerTypesTableSeeder - Updated status values
- VehicleRatesSeeder - Updated status values

**Result:** All tables now consistently use `is_active` boolean field; seeders provide correct data types.

---

### 9. **38c0611** (Mar 31, 14:54 PM) - Port Operations Refactoring to ID-Based Queries

**Files Changed:** 6
**Insertions:** 32 | **Deletions:** 19

**Objective:** Convert port operations from model binding to explicit ID-based queries.

**Action Layer Changes:**

**DeletePortAction:**

```php
// Before: public function execute(Port $port)
// After: public function execute(int $portId)
$port = Port::findOrFail($portId);
$port->delete();
```

**GetPortAction:**

```php
// Before: public function execute(Port $port)
// After: public function execute(int $portId)
$port = Port::findOrFail($portId);
```

**UpdatePortAction:**

```php
// Before: public function execute(Port $port, array $data)
// After: public function execute(int $portId, array $data)
$port = Port::findOrFail($portId);
// Changed $port->update() to $port->fill() followed by $port->save()
```

**Controller Changes (PortController):**

- Removed `Port $port` model binding from method signatures
- Changed to `$portId` parameter instead
- All CRUD routes now pass ID instead of model instance

**Route Changes:**

- Updated route parameters: `/{port}` → `/{portId}`
- Applied to all CRUD operations (show, update, destroy)

**API Endpoint Changes:**

```
GET  /ports/{portId}     # show
PUT  /ports/{portId}     # update
DELETE /ports/{portId}   # destroy
```

**GetRoutesWithPortsAndSchedulesAction Enhancement:**

- Added `arrival_time` field to schedule responses (both port A and port B schedules)

**Benefit:** Explicit ID handling allows more control over query logic and error handling.

---

### 10. **f6cd62c** (Mar 31, 14:56 PM) - Vessel Seat Password Field Addition

**Files Changed:** 4
**Insertions:** 5 | **Deletions:** 1

**Objective:** Add password field support to vessel seats (likely for seat authentication/reservation).

**Model Updates (VesselSeat):**

```php
protected $fillable = [..., 'pwd', ...];
protected $casts = [..., 'pwd' => 'boolean', ...];
```

**Migration Updates (create_vessel_seats_table):**

```php
$table->boolean('pwd')->default(false);
```

**Action Updates:**

**GetVesselLayoutAction:**

- Added `'pwd' => (bool) $seat->pwd,` to seat data returned in API response

**UpdateVesselLayoutAction:**

- Added `'pwd' => $seat['pwd'],` when updating seat records

**API Response Impact:**

- Vessel layout endpoints now include `pwd` field for each seat
- Allows frontend to track which seats have password protection

---

### 11. **5d7ea55** (Mar 31, 14:57 PM) - Vessel Accommodation Controller & CRUD

**Files Changed:** 6
**Insertions:** 122 | **Deletions:** 40

**Objective:** Create dedicated controller and action for managing vessel accommodations with amenity tracking.

**New Files Created:**

**StoreVesselAccommodationAction:**

```php
class StoreVesselAccommodationAction extends Action
{
    public function execute(int $vesselId, array $data)
    {
        // Validates and upserts accommodation records
        // Supports: accommodation_id, aircon, wifi flags
    }
}
```

- Validates accommodation data
- Uses `upsert()` for create-or-update logic
- Unique constraint on [vessel_id, accommodation_id] pair
- Fields: aircon (boolean), wifi (boolean)
- Returns created/updated accommodation records
- Error handling for validation and database errors

**VesselAccommodationController (new):**

```php
class VesselAccommodationController extends Controller
{
    public function store(Request $request, $vesselId, StoreVesselAccommodationAction $action)
    {
        return $action->execute($vesselId, $request->all());
    }
    // Other methods commented out for future implementation
}
```

**Route Registration (routes/Operations/routes.php):**

```php
Route::prefix('{vesselId}/accommodations')->group(function () {
    Route::post('/', [VesselAccommodationController::class, 'store']);
});
```

**API Endpoint:** `POST /vessels/{vesselId}/accommodations`

**Request Format:**

```json
{
    "accommodations": [
        {
            "accommodation_id": 1,
            "aircon": true,
            "wifi": true
        },
        {
            "accommodation_id": 2,
            "aircon": false,
            "wifi": true
        }
    ]
}
```

**Controller Updates:**

**PassengerTypeController:**

- Refactored for consistency
- Changed parameter names from verbose to just `$action`
- Removed unnecessary docblock comments

**VesselController:**

- Same refactoring - simplified parameter names
- Removed docblock comments for cleaner code

**Model Updates (VesselAccommodation):**

- Added unique constraint: `['vessel_id', 'accommodation_id']`
- Cleaned up comments in relationships
- Updated fillable array

**Database Changes (create_vessel_accommodations_table migration):**

- Added unique constraint on vessel_id + accommodation_id pair
- Ensures no duplicate accommodations per vessel

---

### 12. **da4ffa0** (Mar 31, 14:57 PM) - Port Observer Implementation for Cascading Updates

**Files Changed:** 2
**Insertions:** 38 | **Deletions:** 13

**Objective:** Implement Observer pattern to cascade port status changes to dependent routes and schedules.

**New File: PortObserver**

```php
class PortObserver
{
    public function updating(Port $port): void
    {
        Log::info('PortObserver updating fired', [
            'port_id'   => $port->port_id,
            'dirty'     => $port->getDirty(),
        ]);

        if (!$port->isDirty('is_active')) return;
        $this->setDependentsStatus($port->port_id, (bool) $port->is_active);
    }

    private function setDependentsStatus(int $portId, bool $status): void
    {
        // Update all routes using this port
        Route::where('port_a_id', $portId)
            ->orWhere('port_b_id', $portId)
            ->update(['is_active' => $status]);

        // Update all schedules at this port
        Schedule::where('port_id', $portId)
            ->update(['is_active' => $status]);
    }
}
```

**Key Features:**

- **Event Hook:** Listens to `updating` event on Port model
- **Dirty Checking:** Only triggers if `is_active` field has actually changed
- **Logging:** Logs observer events for debugging
- **Cascading Updates:**
    - Routes where port is portA or portB get status updated
    - Schedules at port get status updated
- **Type Safety:** Ensures boolean value passed to updates

**AppServiceProvider Updates:**

```php
public function boot(): void
{
    Port::observe(PortObserver::class);
}
```

- Registers observer in boot lifecycle
- Removed empty register() and unnecessary docblocks

**Business Logic:**
When a port's `is_active` status changes (e.g., deactivating a port due to maintenance):

1. Port observer detects `is_active` field change
2. All routes involving that port are deactivated
3. All schedules at that port are deactivated
4. Single source of truth: port status controls related entities

---

## Summary of Changes by Category

### Database Schema

| Change                   | Count | Reason                                  |
| ------------------------ | ----- | --------------------------------------- |
| Migration Files Deleted  | 17    | Consolidation                           |
| Base Migrations Enhanced | 10    | Functionality merged                    |
| New Fields Added         | 3     | pwd, is_active, arrival_time            |
| Table Unique Constraints | 1     | Prevent duplicate vessel accommodations |

### Application Logic

| Change                   | Count | Scope                            |
| ------------------------ | ----- | -------------------------------- |
| Action Files Updated     | 13+   | Status field standardization     |
| Controller Files Updated | 4     | Name Parameter refactoring       |
| New Controllers          | 1     | VesselAccommodationController    |
| New Actions              | 1     | StoreVesselAccommodationAction   |
| New Observers            | 1     | PortObserver for cascade updates |

### API Changes

| Endpoint                     | Method         | Change                                    |
| ---------------------------- | -------------- | ----------------------------------------- |
| /ports/{id}                  | GET/PUT/DELETE | Changed to ID-based (from model binding)  |
| /vessels/{id}/accommodations | POST           | New endpoint for accommodation management |
| /vessels/{id}/layout         | GET            | Now includes pwd field in seat data       |
| /routes/with-ports-schedules | GET            | Added is_active and arrival_time fields   |

### Data Standardization

| Field             | Before                   | After                  | Scope                                 |
| ----------------- | ------------------------ | ---------------------- | ------------------------------------- |
| status            | string (active/inactive) | numeric enum (0,1,2,3) | 20+ tables & actions                  |
| status            | string enum              | boolean is_active      | Discounts, Routes, Schedules, Vessels |
| Log/Image Storage | Private                  | Public                 | Institutional Accounts, Merchants     |

---

## Testing Recommendations

1. **Migration Testing:**
    - Test fresh migration from scratch with consolidated migrations
    - Verify all tables created correctly with all fields
    - Check unique constraints applied properly

2. **Observer Testing:**
    - Test deactivating a port updates related routes/schedules
    - Verify logging output for observer events
    - Test edge cases (port with no routes/schedules)

3. **Vessel Accommodation Testing:**
    - Test upsert logic (create new, update existing)
    - Test aircon/wifi flag combinations
    - Verify unique constraint prevents duplicates

4. **API Testing:**
    - Test new ID-based port operations
    - Test vessel accommodation endpoint with various payloads
    - Verify response data includes new fields (is_active, pwd, arrival_time)

5. **File Upload Testing:**
    - Test logo upload to public storage
    - Verify file path storage in image column
    - Test file type validation (jpg, jpeg, png, webp)
    - Test file size limit (2MB max)

6. **Data Type Testing:**
    - Verify new numeric status enum values (0, 1, 2, 3)
    - Test is_active boolean field behavior
    - Check seeder data matches new data types

---

## Potential Issues & Considerations

1. **Data Migration:** If running on existing database with string status values, migration of existing data needed
2. **API Compatibility:** Clients expecting string status values will break - coordinate update
3. **File Storage:** Ensure public disk is properly configured in Laravel
4. **Observer Performance:** Cascading updates on port changes could affect large datasets
5. **Soft Deletes:** New unified soft deletes migration may conflict if existing tables have different soft delete setups

---

## Deployment Checklist

- [ ] Back up database before migration
- [ ] Run migrations in order: consolidation first, then field updates
- [ ] Clear application cache
- [ ] Update API clients for is_active boolean field
- [ ] Configure public disk for logo storage
- [ ] Run seeders to populate new port/route data
- [ ] Test observer cascading with sample port deactivation
- [ ] Verify file upload functionality
- [ ] Test all vessel accommodation endpoints
- [ ] Monitor logs for observer events during testing
