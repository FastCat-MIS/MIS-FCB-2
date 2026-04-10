# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

FastCat-v2 is a Laravel 12 API backend for a ferry/vessel booking system. It uses JWT authentication (tymon/jwt-auth), role-based access control (Spatie Permissions), and follows an action-based architecture pattern.

## Common Commands

```bash
# Development (runs Laravel server + queue + logs + Vite)
composer run dev

# Run tests (clears config cache first)
composer run test

# Database
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed

# Code styling
php artisan pint

# Generate API docs
php artisan l5-swagger:generate
```

## Architecture

### Domain-Driven Structure

The codebase is organized into three domains: **Accounts**, **Operations**, and **Marketing**.

```
app/
├── Actions/           # Business logic (not in controllers)
│   ├── Accounts/      # Auth, User profile
│   ├── Operations/    # Vessels, Routes, Schedules, Bookings, VDAR
│   └── Marketing/     # Rates, Promos, Discounts, Merchants
├── Models/
│   ├── Accounts/      # User, Role, Permission
│   ├── Operations/    # Vessel, Schedule, Route, Port, Booking, etc.
│   └── Marketing/
└── Http/Controllers/  # Thin controllers that delegate to Actions

routes/
├── api.php            # Public routes (login, register, refresh)
├── Accounts/auth.php  # Profile routes
├── Operations/routes.php
└── Marketing/routes.php
```

### Action Pattern

All business logic lives in Action classes, not controllers. Controllers delegate to actions:

```php
// Controller
public function store(Request $request, CreateVesselAction $action)
{
    return $action->execute($request->all());
}

// Action handles validation, business logic, and response
class CreateVesselAction extends Action
{
    public function execute(array $data)
    {
        $validator = Validator::make($data, [...]);
        if ($validator->fails()) throw new ValidationException($validator);

        $vessel = Vessel::create($validated);
        return $this->success($data, 'Vessel created', 201);
    }
}
```

Base Action class provides: `make()`, `run()`, `success()`, `error()`.

### Standardized JSON Response Format

```json
{
  "status": 200,
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

### Authentication

- Public routes: `/api/login`, `/api/register`, `/api/refresh`
- Protected routes require `jwt.auth` middleware
- JWT includes custom claims: user_id, full_name, email, role_id
- Permission middleware is available but currently commented out in routes

## Database

- MySQL on port 3307 (dev), 3306 (production)
- Tests use SQLite in-memory
- Models use fillable arrays for mass assignment protection
- Only User model uses SoftDeletes

## Key Files

| Purpose | Location |
|---------|----------|
| Status constants | `app/Enums/Status.php` |
| JWT middleware | `app/Http/Middleware/JwtMiddleware.php` |
| Base Action class | `app/Actions/Action.php` |
| API documentation | `postman/` directory |

## Adding a New CRUD Feature

1. Create migration: `php artisan make:migration create_xxxs_table`
2. Create model in `app/Models/Domain/`
3. Create actions in `app/Actions/Domain/ModelName/`:
   - GetXxxsAction, GetXxxAction, CreateXxxAction, UpdateXxxAction, DeleteXxxAction
4. Create controller that injects and delegates to actions
5. Add routes in `routes/Domain/routes.php`
6. Create seeder and add to DatabaseSeeder
