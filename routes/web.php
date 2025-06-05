<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\CourierController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Staff\AuthController as StaffAuthController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('frontend.home');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.list');
        Route::get('/customers', [CustomerController::class, 'index'])->name('customer.list');
        Route::get('/routes', [RouteController::class, 'index'])->name('route.list');
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicle.list');
        Route::get('/couriers', [CourierController::class, 'index'])->name('courier.list');
        Route::get('/book-courier', [BookingController::class, 'index'])->name('book.courier');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payment.list');
        Route::get('/monthly-report', [ReportController::class, 'index'])->name('report.monthly');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

        // Staff Management
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
        Route::post('/staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/delete/{id}', [StaffController::class, 'destroy'])->name('staff.delete');

        //Courier Management
        Route::get('/couriers/category', [CourierController::class, 'category'])->name('courier.category');
        Route::get('/couriers/charges', [CourierController::class, 'charges'])->name('courier.charges');

        // Route Management
        Route::get('/route', [RouteController::class, 'index'])->name('route.list');
        Route::get('/route/create', [RouteController::class, 'create'])->name('route.create');
        Route::post('/route/store', [RouteController::class, 'store'])->name('route.store');
        Route::get('/route/edit/{id}', [RouteController::class, 'edit'])->name('route.edit');
        Route::post('/route/update/{id}', [RouteController::class, 'update'])->name('route.update');
        Route::delete('/route/delete/{id}', [RouteController::class, 'destroy'])->name('route.delete');

        // Vehicle Management
         Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle.list');
    Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');
    Route::post('/vehicle/store', [VehicleController::class, 'store'])->name('vehicle.store');
    Route::get('/vehicle/edit/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
    Route::post('/vehicle/update/{id}', [VehicleController::class, 'update'])->name('vehicle.update');
    Route::delete('/vehicle/delete/{id}', [VehicleController::class, 'destroy'])->name('vehicle.delete');
        



    });
});


// Staff authentication routes
Route::prefix('staff')->group(function () {
    // Authentication
    Route::get('/login', [StaffAuthController::class, 'showLoginForm'])->name('staff.login');
    Route::post('/login', [StaffAuthController::class, 'login'])->name('staff.login.post');
    Route::post('/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');
    Route::post('/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');

    // Protected Routes
    Route::middleware(['auth:staff'])->group(function () {
        Route::get('/dashboard', function () {
            return view('staff.dashboard');
        })->name('staff.dashboard');

        Route::get('/manager/dashboard', function () {
            return view('staff.roles.manager');
        })->name('staff.manager.dashboard');

        // Route::get('/manager/dashboard', function () {
        //     return view('staff.roles.manager');
        // })->name('staff.manager.dashboard');

        // Route::get('/manager/dashboard', function () {
        //     return view('staff.roles.manager');
        // })->name('staff.manager.dashboard');

        // Add other role routes similarly
    });
});





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/manager/dashboard', function () {
//     return view('staff.roles.manager');
// })->middleware(['auth:staff', 'staff.role:manager']);





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
