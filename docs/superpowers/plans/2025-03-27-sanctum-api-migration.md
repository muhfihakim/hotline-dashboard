# Sanctum API Migration Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Migrate from manual session-based authentication to Laravel Sanctum API Tokens.

**Architecture:** Use `Laravel\Sanctum\HasApiTokens` on `User` model. Create a dedicated `AuthController` for token lifecycle (login/logout). Move all administrative routes to `routes/api.php` under `auth:sanctum` middleware.

**Tech Stack:** Laravel 12, Laravel Sanctum.

---

### Task 1: Install and Configure Sanctum

**Files:**
- Modify: `app/Models/User.php`
- Modify: `composer.json` (auto)
- Create: `routes/api.php` (auto)
- Create: `config/sanctum.php` (auto)

- [ ] **Step 1: Install API scaffolding**
Run: `php artisan install:api`
Expected: `routes/api.php` created, Sanctum migration files created.

- [ ] **Step 2: Add HasApiTokens trait to User model**
Modify `app/Models/User.php`:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Add this

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Add HasApiTokens
    // ...
}
```

- [ ] **Step 3: Run migrations**
Run: `php artisan migrate`
Expected: `personal_access_tokens` table created.

- [ ] **Step 4: Commit**
```bash
git add app/Models/User.php composer.json composer.lock routes/api.php
git commit -m "chore: install sanctum and configure user model"
```

---

### Task 2: Create AuthController for API Tokens

**Files:**
- Create: `app/Http/Controllers/Api/AuthController.php`
- Test: `tests/Feature/Api/AuthTest.php`

- [ ] **Step 1: Write Auth test for login**
Create `tests/Feature/Api/AuthTest.php`:
```php
namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_receive_token()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['access_token', 'token_type']);
    }
}
```

- [ ] **Step 2: Implement login in AuthController**
Create `app/Http/Controllers/Api/AuthController.php`:
```php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credentials do not match our records.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
```

- [ ] **Step 3: Register Login Route**
Modify `routes/api.php`:
```php
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
```

- [ ] **Step 4: Run tests**
Run: `php artisan test tests/Feature/Api/AuthTest.php`
Expected: PASS

- [ ] **Step 5: Commit**
```bash
git add app/Http/Controllers/Api/AuthController.php routes/api.php tests/Feature/Api/AuthTest.php
git commit -m "feat: add api auth controller and login route"
```

---

### Task 3: Migrate Protected Routes to API

**Files:**
- Modify: `routes/api.php`
- Modify: `routes/web.php`

- [ ] **Step 1: Move admin routes to API**
Modify `routes/api.php` to include protected routes from `web.php`, changing middleware to `auth:sanctum`.
```php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AduanLayananController;
// ... (import other controllers)

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::middleware('userAkses:admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'index']);
        Route::get('/aduan-layanan', [AduanLayananController::class, 'index']);
        // ... (copy other admin routes from web.php)
    });

    Route::middleware('userAkses:pimpinan')->group(function () {
        Route::get('/pimpinan', [DashboardController::class, 'indexPimpinan']);
    });
});
```

- [ ] **Step 2: Verify Middleware JSON responses**
`App\Http\Middleware\UserAkses` already returns JSON for unauthorized access. No change needed, but verify.

- [ ] **Step 3: Commit**
```bash
git add routes/api.php
git commit -m "feat: migrate protected routes to api.php"
```

---

### Task 4: Cleanup Legacy Auth

**Files:**
- Delete: `app/Http/Controllers/SesiController.php`
- Delete: `resources/views/login.blade.php`
- Modify: `routes/web.php`

- [ ] **Step 1: Remove auth routes from web.php**
Modify `routes/web.php`:
- Remove `Route::middleware(['guest'])->group(...)`
- Remove `Route::middleware(['auth'])->group(...)`
- Keep only non-auth logic if any (e.g., `/` redirect or landing).

- [ ] **Step 2: Delete legacy files**
Run: `rm app/Http/Controllers/SesiController.php resources/views/login.blade.php`

- [ ] **Step 3: Commit**
```bash
git add routes/web.php
git rm app/Http/Controllers/SesiController.php resources/views/login.blade.php
git commit -m "chore: remove legacy session auth logic and views"
```

---

### Task 5: Refactor Controllers for JSON (Example)

**Files:**
- Modify: `app/Http/Controllers/DashboardController.php`

- [ ] **Step 1: Refactor DashboardController to return JSON if API request**
Modify `app/Http/Controllers/DashboardController.php`:
```php
public function index(Request $request)
{
    // ... logic ...
    
    if ($request->wantsJson() || $request->is('api/*')) {
        return response()->json([
            'totalAduanLayanan' => $totalAduanLayanan,
            'latestData' => $latestData,
            // ...
        ]);
    }

    return view('Admin.dash', compact(...));
}
```

- [ ] **Step 2: Commit**
```bash
git add app/Http/Controllers/DashboardController.php
git commit -m "refactor: allow dashboard controller to return json"
```
