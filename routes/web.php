<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return redirect('/login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Admin
Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);
    Route::get('/admin/products', [ProductController::class, 'index']);
    Route::get('/admin/products/create', [ProductController::class, 'create']);
    Route::post('/admin/products', [ProductController::class, 'store']);
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/admin/products/{product}', [ProductController::class, 'update']);
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy']);
    Route::get('/admin/transactions', [TransactionController::class, 'adminIndex']);

    Route::get('/admin/employees', [EmployeeController::class, 'index']);
    Route::get('/admin/employees/create', [EmployeeController::class, 'create']);
    Route::post('/admin/employees', [EmployeeController::class, 'store']);
    Route::get('/admin/employees/{employee}/edit', [EmployeeController::class, 'edit']);
    Route::put('/admin/employees/{employee}', [EmployeeController::class, 'update']);
    Route::delete('/admin/employees/{employee}', [EmployeeController::class, 'destroy']);

});

// Kasir
Route::middleware(['auth', 'kasir'])->group(function () {
    
    Route::get('/kasir/dashboard', function () { return view('kasir.dashboard'); });
});

Route::middleware(['auth'])->group(function () {

    Route::get('/kasir/transactions', [TransactionController::class, 'index']);
    Route::get('/kasir/transactions/create', [TransactionController::class, 'create']);
    Route::post('/kasir/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}/print', [TransactionController::class, 'print']);

});

Route::middleware(['auth', 'admin_or_kasir'])->group(function () {

    Route::get('/kasir/transactions/create', [TransactionController::class, 'create']);
    Route::post('/kasir/transactions/store-cart', [TransactionController::class, 'storeCart']);
    Route::get('/kasir/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{id}/print', [TransactionController::class, 'print']);

});
