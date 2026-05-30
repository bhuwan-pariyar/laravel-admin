<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // User Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/image', [ProfileController::class, 'uploadImage'])->name('profile.uploadImage');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users
    Route::get('/users', [UsersController::class, 'list'])->name('users.list');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::get('/users/{userId}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::get('/users/{userId}', [UsersController::class, 'show'])->name('users.show');

    // Items
    Route::get('/items', [ItemController::class, 'index'])->name('items.list');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::get('/items/{itemId}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::get('/items/{itemId}', [ItemController::class, 'show'])->name('items.show');

    // Categories
    Route::get('/categories', [CategoryController::class, 'list'])->name('categories.list');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{categoryId}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::get('/categories/{categoryId}', [CategoryController::class, 'show'])->name('categories.show');

    // Suppliers
    Route::get('/suppliers', [SupplierController::class, 'list'])->name('suppliers.list');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::get('/suppliers/{supplierId}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::get('/suppliers/{supplierId}', [SupplierController::class, 'show'])->name('suppliers.show');

    // Stock Transactions
    Route::get('/transactions', [StockTransactionController::class, 'list'])->name('transactions.list');
    Route::get('/transactions/create', [StockTransactionController::class, 'create'])->name('transactions.create');

    // Roles & Permissions
    Route::get('/roles', [RoleController::class, 'list'])->name('roles.list');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/roles/{roleId}/edit', [RoleController::class, 'edit'])->name('roles.edit');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/departments', [SettingsController::class, 'departmentsList'])->name('settings.departments.list');
    Route::get('/settings/departments/create', [SettingsController::class, 'departmentsCreate'])->name('settings.departments.create');
    Route::get('/settings/departments/{departmentId}/edit', [SettingsController::class, 'departmentsEdit'])->name('settings.departments.edit');
    Route::get('/settings/email', [SettingsController::class, 'emailIndex'])->name('settings.email');
    Route::get('/settings/backup', [SettingsController::class, 'backupIndex'])->name('settings.backup');
});

require __DIR__.'/auth.php';
