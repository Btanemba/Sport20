<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect the root route to the login page
Route::get('/', function () {
    return redirect()->route('login');
});
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/admin/dasboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

//  require __DIR__.'/auth.php';
