<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//! can perform root page here but right now it's just redirecting to login page
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/a/dashboard', function () {
    return view('dashboard.admin.index');
})->middleware(['auth', 'verified'])->name('a.dashboard');

Route::get('/s/dashboard', function () {
    return view('dashboard.student.index');
})->middleware(['auth', 'verified'])->name('s.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
