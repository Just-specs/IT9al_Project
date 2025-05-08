<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\InventoryIssueController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/welcome', function () {
    return view('login');
})->name('login');

Route::middleware(['guest'])->group(function () {
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerSave'])->name('register.save');

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginAction'])->name('login.action');
});

Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Define the employee dashboard route
    Route::get('employee/dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard');

    // Products Routes
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('products');
        Route::get('create', 'create')->name('products.create');
        Route::post('store', 'store')->name('products.store');
        Route::get('show/{id}', 'show')->name('products.show');
        Route::get('edit/{id}', 'edit')->name('products.edit');
        Route::put('edit/{id}', 'update')->name('products.update');
        Route::delete('destroy/{id}', 'destroy')->name('products.destroy');
        Route::get('low-stock', 'lowStock')->name('products.low-stock');
    });

    // Suppliers Routes
    Route::controller(SupplierController::class)->prefix('suppliers')->group(function () {
        Route::get('', 'index')->name('suppliers');
        Route::get('create', 'create')->name('suppliers.create');
        Route::post('store', 'store')->name('suppliers.store');
        Route::get('show/{id}', 'show')->name('suppliers.show');
        Route::get('edit/{id}', 'edit')->name('suppliers.edit');
        Route::put('edit/{id}', 'update')->name('suppliers.update');
        Route::delete('destroy/{id}', 'destroy')->name('suppliers.destroy');
    });

    // Department Routes
    Route::controller(DepartmentController::class)->prefix('departments')->group(function () {
        Route::get('', 'index')->name('departments');
        Route::get('create', 'create')->name('departments.create');
        Route::post('store', 'store')->name('departments.store');
        Route::get('show/{id}', 'show')->name('departments.show');
        Route::get('edit/{id}', 'edit')->name('departments.edit');
        Route::put('edit/{id}', 'update')->name('departments.update');
        Route::delete('destroy/{id}', 'destroy')->name('departments.destroy');
    });

    // Employee Routes
    Route::controller(EmployeeController::class)->prefix('employees')->group(function () {
        Route::get('', 'index')->name('employees');
        Route::get('create', 'create')->name('employees.create');
        Route::post('store', 'store')->name('employees.store');
        Route::get('show/{id}', 'show')->name('employees.show');
        Route::get('edit/{id}', 'edit')->name('employees.edit');
        Route::put('edit/{id}', 'update')->name('employees.update');
        Route::delete('destroy/{id}', 'destroy')->name('employees.destroy');
    });

    // Purchase Order Routes
    Route::controller(PurchaseOrderController::class)->prefix('purchase-orders')->group(function () {
        Route::get('', 'index')->name('purchase-orders');
        Route::get('create', 'create')->name('purchase-orders.create');
        Route::post('store', 'store')->name('purchase-orders.store');
        Route::get('show/{id}', 'show')->name('purchase-orders.show');
        Route::get('edit/{id}', 'edit')->name('purchase-orders.edit');
        Route::put('edit/{id}', 'update')->name('purchase-orders.update');
        Route::delete('destroy/{id}', 'destroy')->name('purchase-orders.destroy');
        Route::get('receive/{id}', 'showReceiveForm')->name('purchase-orders.receive-form');
        Route::post('receive/{id}', 'receiveOrder')->name('purchase-orders.receive');
    });

    Route::resource('purchase_orders', PurchaseOrderController::class);

    // Inventory Issue Routes
    Route::controller(InventoryIssueController::class)->prefix('inventory-issues')->group(function () {
        Route::get('', 'index')->name('inventory-issues');
        Route::get('create', 'create')->name('inventory-issues.create');
        Route::post('store', 'store')->name('inventory-issues.store');
        Route::get('show/{id}', 'show')->name('inventory-issues.show');
    });

    // Stock Routes
    Route::controller(StockController::class)->prefix('stock')->group(function () {
        Route::get('', 'index')->name('stock'); // Ensure the "index" method in StockController passes $stocks
        Route::get('create', 'create')->name('stock.create');
        Route::post('store', 'store')->name('stock.store');
        Route::get('show/{id}', 'show')->name('stock.show');
        Route::get('edit/{id}', 'edit')->name('stock.edit');
        Route::put('edit/{id}', 'update')->name('stock.update');
        Route::delete('destroy/{id}', 'destroy')->name('stock.destroy');
    });

    // Reports Routes
    Route::controller(ReportController::class)->prefix('reports')->group(function () {
        Route::get('', 'index')->name('reports');
        Route::get('stock-level', 'stockLevel')->name('reports.stock-level');
        Route::get('inventory-assignments', 'inventoryAssignments')->name('reports.inventory-assignments');
        Route::get('purchase-history', 'purchaseHistory')->name('reports.purchase-history');
        Route::get('low-stock', 'lowStock')->name('reports.low-stock');
        Route::get('generate-pdf/{type}', 'generatePdf')->name('reports.generate-pdf');
    });

    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
});

// Stock Routes

Route::get('/stock-in', [StockController::class, 'index'])->name('stock.index');
Route::post('/stock-in', [StockController::class, 'store'])->name('stock.store');

Route::get('/search', [SearchController::class, 'index'])->name('search');
