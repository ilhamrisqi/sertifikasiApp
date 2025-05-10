<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicalEquipmentController;
use App\Http\Controllers\ConsumableController;




Route::redirect('', '/login');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// Register routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User routes (hanya untuk Admin)
    Route::middleware('check.role:Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    
    // Medicine routes (untuk Admin dan Pharmacist)
    Route::middleware('check.role:Admin,Pharmacist')->group(function () {
        Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
        Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
        Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
        Route::get('/medicines/{medicine}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
        Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
        Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
    });
    
    // Medical Equipment routes
    Route::middleware('check.role:Admin,Technician')->group(function () {
        Route::get('/medical', [MedicalEquipmentController::class, 'index'])->name('medical.index');
        Route::get('/medical/create', [MedicalEquipmentController::class, 'create'])->name('medical.create');
        Route::post('/medical', [MedicalEquipmentController::class, 'store'])->name('medical.store');
        Route::get('/medical/{medicalEquipment}/edit', [MedicalEquipmentController::class, 'edit'])->name('medical.edit');
        Route::put('/medical/{medicalEquipment}', [MedicalEquipmentController::class, 'update'])->name('medical.update');
        Route::delete('/medical/{medicalEquipment}', [MedicalEquipmentController::class, 'destroy'])->name('medical.destroy');
    });
    
    // Consumable routes
    Route::middleware('check.role:Admin')->group(function () {
        Route::get('/consumable', [ConsumableController::class, 'index'])->name('consumables.index');
        Route::get('/consumable/create', [ConsumableController::class, 'create'])->name('consumables.create');
        Route::post('/consumable', [ConsumableController::class, 'store'])->name('consumables.store');
        Route::get('/consumable/{consumable}/edit', [ConsumableController::class, 'edit'])->name('consumables.edit');
        Route::put('/consumable/{consumable}', [ConsumableController::class, 'update'])->name('consumables.update');
        Route::delete('/consumable/{consumable}', [ConsumableController::class, 'destroy'])->name('consumables.destroy');
    });
});