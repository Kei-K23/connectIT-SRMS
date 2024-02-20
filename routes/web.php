<?php

use App\Http\Controllers\AdministratorController;
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

// admin routes
Route::group([], function () {
    Route::get('/a/dashboard', [AdministratorController::class, 'index'])->middleware(['auth', 'verified'])->name('a.dashboard');

    Route::get('/a/dashboard/students/add-student', [AdministratorController::class, 'addStudent'])->middleware(['auth', 'verified'])->name('a.dashboard.add-student');

    Route::get('/a/dashboard/courses/add-course', [AdministratorController::class, 'addCourse'])->middleware(['auth', 'verified'])->name('a.dashboard.add-course');

    Route::post('/a/dashboard/students/add-student', [AdministratorController::class, 'addStudentStore'])->middleware(['auth', 'verified'])->name('a.dashboard.add-student.store');

    Route::post('/a/dashboard/courses/add-course', [AdministratorController::class, 'addCourseStore'])->middleware(['auth', 'verified'])->name('a.dashboard.add-course.store');

    Route::put('/a/dashboard/students/update-student/{studentId}', [AdministratorController::class, 'updateStudent'])->middleware(['auth', 'verified'])->name('a.dashboard.update-student.update');


    Route::put('/a/dashboard/courses/update-course/{courseId}', [AdministratorController::class, 'updateCourse'])->middleware(['auth', 'verified'])->name('a.dashboard.update-course.update');


    Route::put('/a/dashboard/students/reset-password/{studentId}', [AdministratorController::class, 'resetPassword'])->middleware(['auth', 'verified'])->name('a.dashboard.reset-password');

    Route::get('/a/dashboard/students/manage-student', [AdministratorController::class, 'manageStudent'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-student');

    Route::get('/a/dashboard/courses/manage-course', [AdministratorController::class, 'manageCourse'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-course');

    Route::delete('/a/dashboard/students/manage-student/delete/{studentId}', [AdministratorController::class, 'manageStudentDelete'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-student.delete');

    Route::delete('/a/dashboard/courses/manage-course/delete/{courseId}', [AdministratorController::class, 'manageCourseDelete'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-course.delete');
});

Route::get('/s/dashboard', function () {
    return view('dashboard.student.index');
})->middleware(['auth', 'verified'])->name('s.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
