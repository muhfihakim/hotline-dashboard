# Sanctum API Migration Plan

## Context
Migrate from manual session-based authentication in `SesiController` to Laravel Sanctum API Tokens. This project is Laravel 12.

## Goals
1. Install and configure Laravel Sanctum for API Token authentication.
2. Create an API-based login system that returns Bearer tokens.
3. Remove manual web-based authentication logic and views.
4. Set up `routes/api.php` with protected endpoints.

## Proposed Changes

### 1. Installation & Setup
- Run `php artisan install:api` to install Sanctum and create `routes/api.php`.
- Ensure `App\Models\User` uses the `Laravel\Sanctum\HasApiTokens` trait.
- Run migrations to create `personal_access_tokens` table.

### 2. API Authentication Controller
- Create `app/Http/Controllers/Api/AuthController.php`.
- Implement `login(Request $request)`:
    - Validate email/password.
    - Revoke previous tokens (optional/security choice).
    - Create new token: `$user->createToken('api-token')->plainTextToken`.
    - Return JSON response with the token.
- Implement `logout(Request $request)`:
    - Revoke current token: `$request->user()->currentAccessToken()->delete()`.

### 3. Cleanup Existing Auth
- Delete `app/Http/Controllers/SesiController.php`.
- Remove guest/login routes from `routes/web.php`.
- Delete `resources/views/login.blade.php`.
- (Optional) Clean up SweetAlert config if no longer used for web login errors.

### 4. Routing Migration
- Move protected routes from `routes/web.php` to `routes/api.php`.
- Change middleware from `auth` to `auth:sanctum`.
- Ensure `userAkses` middleware works correctly with API requests.

### 5. Controller Refactoring (Partial)
- Since current controllers return Blade views, I will demonstrate how to refactor `DashboardController@index` to return JSON, or leave them as is if the user intends to handle view-rendering separately (though choice "API Tokens" strongly implies JSON).

## Verification Plan
1. Test `/api/login` via `curl` or Postman.
2. Verify token creation in `personal_access_tokens` table.
3. Test a protected endpoint (e.g., `/api/admin`) using the Bearer token.
4. Verify `/api/logout` revokes the token.
5. Verify web login routes are 404/Removed.
