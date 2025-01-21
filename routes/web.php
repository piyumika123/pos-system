<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredEmployeeController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/manager-dashboard', function () {
    return view('dashboards.manager');
})->middleware(['auth', 'verified'])->name('manager-dashboard');

Route::get('/warehouse-dashboard', function () {
    return view('dashboards.warehouse');
})->middleware(['auth', 'verified'])->name('warehouse-dashboard');

Route::get('/supermarket-dashboard', function () {
    return view('dashboards.supermarket');
})->middleware(['auth', 'verified'])->name('supermarket-dashboard');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisteredEmployeeController::class, 'create'])->name('register');
Route::post('/register', [RegisteredEmployeeController::class, 'store']);
Route::post('/register-employee', [RegisteredEmployeeController::class, 'store'])->name('register.employee');

require __DIR__.'/auth.php';
?>
