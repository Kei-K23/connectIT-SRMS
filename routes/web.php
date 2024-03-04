<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
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
Route::group(['middleware' => ['isAdmin']], function () {

    Route::get('/a/dashboard', [AdministratorController::class, 'index'])->middleware(['auth', 'verified'])->name('a.dashboard');

    // admin dashboard - student routes
    Route::group([], function () {
        Route::get('/a/dashboard/students/add-student', [AdministratorController::class, 'addStudent'])->middleware(['auth', 'verified'])->name('a.dashboard.add-student');

        Route::post('/a/dashboard/students/add-student', [AdministratorController::class, 'addStudentStore'])->middleware(['auth', 'verified'])->name('a.dashboard.add-student.store');

        Route::put('/a/dashboard/students/update-student/{studentId}', [AdministratorController::class, 'updateStudent'])->middleware(['auth', 'verified'])->name('a.dashboard.update-student.update');

        Route::put('/a/dashboard/students/reset-password/{studentId}', [AdministratorController::class, 'resetPassword'])->middleware(['auth', 'verified'])->name('a.dashboard.reset-password');

        Route::get('/a/dashboard/students/manage-student', [AdministratorController::class, 'manageStudent'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-student');

        Route::delete('/a/dashboard/students/manage-student/delete/{studentId}', [AdministratorController::class, 'manageStudentDelete'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-student.delete');
    });

    // admin dashboard - course routes
    Route::group([], function () {

        Route::get('/a/dashboard/courses/add-course', [AdministratorController::class, 'addCourse'])->middleware(['auth', 'verified'])->name('a.dashboard.add-course');

        Route::post('/a/dashboard/courses/add-course', [AdministratorController::class, 'addCourseStore'])->middleware(['auth', 'verified'])->name('a.dashboard.add-course.store');

        Route::put('/a/dashboard/courses/update-course/{courseId}', [AdministratorController::class, 'updateCourse'])->middleware(['auth', 'verified'])->name('a.dashboard.update-course.update');

        Route::get('/a/dashboard/courses/manage-course', [AdministratorController::class, 'manageCourse'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-course');

        Route::delete('/a/dashboard/courses/manage-course/delete/{courseId}', [AdministratorController::class, 'manageCourseDelete'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-course.delete');
    });

    // admin dashboard - section routes
    Route::group([], function () {

        Route::get('/a/dashboard/sections/add-section', [AdministratorController::class, 'addSection'])->middleware(['auth', 'verified'])->name('a.dashboard.add-section');

        Route::post('/a/dashboard/sections/add-section', [AdministratorController::class, 'addSectionStore'])->middleware(['auth', 'verified'])->name('a.dashboard.add-section.store');

        Route::put('/a/dashboard/sections/update-section/{sectionId}', [AdministratorController::class, 'updateSection'])->middleware(['auth', 'verified'])->name('a.dashboard.update-section.update');

        Route::get('/a/dashboard/sections/manage-section', [AdministratorController::class, 'manageSection'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-section');

        Route::delete('/a/dashboard/sections/manage-section/delete/{sectionId}', [AdministratorController::class, 'manageSectionDelete'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-section.delete');
    });

    // admin dashboard - report routes
    Route::group([], function () {

        Route::get('/a/dashboard/reports/add-report', [AdministratorController::class, 'addReport'])->middleware(['auth', 'verified'])->name('a.dashboard.add-report');

        Route::post('/a/dashboard/reports/add-report', [AdministratorController::class, 'addReportStore'])->middleware(['auth', 'verified'])->name('a.dashboard.add-report.store');

        Route::put('/a/dashboard/reports/update-report/{reportId}', [AdministratorController::class, 'updateReport'])->middleware(['auth', 'verified'])->name('a.dashboard.update-report.update');

        Route::get('/a/dashboard/reports/manage-report', [AdministratorController::class, 'manageReport'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-report');

        Route::delete('/a/dashboard/reports/manage-report/delete/{reportId}', [AdministratorController::class, 'manageReportDelete'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-report.delete');
    });

    // admin dashboard - subjects routes
    Route::group([], function () {
        Route::get('/a/dashboard/subjects/add-subject', [AdministratorController::class, 'addSubject'])->middleware(['auth', 'verified'])->name('a.dashboard.add-subject');

        Route::post('/a/dashboard/subjects/add-subject', [AdministratorController::class, 'addSubjectStore'])->middleware(['auth', 'verified'])->name('a.dashboard.add-subject.store');

        Route::put('/a/dashboard/subjects/update-subject/{subjectId}', [AdministratorController::class, 'updateSubject'])->middleware(['auth', 'verified'])->name('a.dashboard.update-subject.update');

        Route::get('/a/dashboard/subjects/manage-subject', [AdministratorController::class, 'manageSubject'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-subject');

        Route::delete('/a/dashboard/subjects/manage-subject/delete/{subjectId}', [AdministratorController::class, 'manageSubjectDelete'])->middleware(['auth', 'verified'])->name('a.dashboard.manage-subject.delete');
    });
});

// student routes
Route::group(['middleware' => ['isStudent']], function () {
    Route::get('/s/dashboard', [StudentController::class, 'index'])->middleware(['auth', 'verified'])->name('s.dashboard');

    Route::group([], function () {
        Route::post('/s/dashboard/attendance/{subjectId}', [AttendanceController::class, 'store'])->middleware('attendance.time.check')->name('s.dashboard.attendance.store');

        Route::get('/s/dashboard/attendance', [AttendanceController::class, 'index'])->name('s.dashboard.attendance');
    });

    Route::get('/s/dashboard/report', [ReportController::class, 'index'])->name('s.dashboard.report');
});

// instructor routes
Route::group(['middleware' => ['isInstructor']], function () {
    Route::get('/i/dashboard', [InstructorController::class, 'index'])->middleware(['auth', 'verified'])->name('i.dashboard');
});

// materials routes

Route::group([], function () {
    Route::post('/materials', [MaterialController::class, 'store'])->middleware(['auth', 'verified'])->name('materials.store');

    Route::get('/materials/{filename}/download', [MaterialController::class, 'download'])->middleware(['auth', 'verified'])->name('materials.download');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
