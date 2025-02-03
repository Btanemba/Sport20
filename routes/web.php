<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Redirect the root route to the login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Override Fortify's Register Route
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

// If you want to use a registration view route as well
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register.view');

// Other routes
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
