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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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

    // Stores
    Route::get('/stores', function () { return view('stores.index'); })->name('stores.list');
    Route::get('/stores/create', function () { return view('stores.form'); })->name('stores.create');
    Route::get('/stores/{storeId}/edit', function ($storeId) { return view('stores.form', compact('storeId')); })->name('stores.edit');
    Route::get('/stores/{storeId}', function ($storeId) { return view('stores.show', compact('storeId')); })->name('stores.show');

    // Customers
    Route::get('/customers', function () { return view('customers.index'); })->name('customers.list');
    Route::get('/customers/create', function () { return view('customers.form'); })->name('customers.create');
    Route::get('/customers/{customerId}/edit', function ($customerId) { return view('customers.form', compact('customerId')); })->name('customers.edit');
    Route::get('/customers/{customerId}', function ($customerId) { return view('customers.show', compact('customerId')); })->name('customers.show');

    // Sales
    Route::get('/sales', function () { return view('sales.index'); })->name('sales.list');
    Route::get('/sales/create', function () { return view('sales.form'); })->name('sales.create');
    Route::get('/sales/{saleId}/edit', function ($saleId) { return view('sales.form', compact('saleId')); })->name('sales.edit');
    Route::get('/sales/{saleId}', function ($saleId) { return view('sales.show', compact('saleId')); })->name('sales.show');

    // Purchases
    Route::get('/purchases', function () { return view('purchases.index'); })->name('purchases.list');
    Route::get('/purchases/create', function () { return view('purchases.form'); })->name('purchases.create');
    Route::get('/purchases/{purchaseId}/edit', function ($purchaseId) { return view('purchases.form', compact('purchaseId')); })->name('purchases.edit');
    Route::get('/purchases/{purchaseId}', function ($purchaseId) { return view('purchases.show', compact('purchaseId')); })->name('purchases.show');

    // Transfers
    Route::get('/transfers', function () { return view('transfers.index'); })->name('transfers.list');
    Route::get('/transfers/create', function () { return view('transfers.form'); })->name('transfers.create');
    Route::get('/transfers/{transferId}/edit', function ($transferId) { return view('transfers.form', compact('transferId')); })->name('transfers.edit');
    Route::get('/transfers/{transferId}', function ($transferId) { return view('transfers.show', compact('transferId')); })->name('transfers.show');

    // Damage Reports
    Route::get('/damage-reports', function () { return view('damage.index'); })->name('damage.list');
    Route::get('/damage-reports/create', function () { return view('damage.form'); })->name('damage.create');
    Route::get('/damage-reports/{damageId}/edit', function ($damageId) { return view('damage.form', compact('damageId')); })->name('damage.edit');
    Route::get('/damage-reports/{damageId}', function ($damageId) { return view('damage.show', compact('damageId')); })->name('damage.show');

    // QR Codes
    Route::get('/qr-generate', function () { return view('qr.index'); })->name('qr.index');

    // Reports
    Route::get('/reports/stock', function () { return view('reports.stock'); })->name('reports.stock');
    Route::get('/reports/activity', function () { return view('reports.activity'); })->name('reports.activity');
    Route::get('/reports/export', function () { return view('reports.export'); })->name('reports.export');

    // Roles & Permissions
    Route::get('/roles', [RoleController::class, 'list'])->name('roles.list');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/roles/{roleId}/edit', [RoleController::class, 'edit'])->name('roles.edit');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/departments', [SettingsController::class, 'departmentsList'])->name('settings.departments.list');
    Route::get('/settings/departments/create', [SettingsController::class, 'departmentsCreate'])->name('settings.departments.create');
    Route::get('/settings/departments/{departmentId}/edit', [SettingsController::class, 'departmentsEdit'])->name('settings.departments.edit');
    Route::get('/settings/departments/{departmentId}', [SettingsController::class, 'departmentsShow'])->name('settings.departments.show');
    Route::get('/settings/email', [SettingsController::class, 'emailIndex'])->name('settings.email');
    Route::get('/settings/backup', [SettingsController::class, 'backupIndex'])->name('settings.backup');
});

require __DIR__.'/auth.php';
