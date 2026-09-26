<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\CourseController as FrontendCourseController;
use App\Http\Controllers\Frontend\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (now uses DashboardController for dynamic data)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Public Course Catalog
Route::get('/courses', [FrontendCourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [FrontendCourseController::class, 'show'])->name('courses.show');

// Auth-protected student routes
Route::middleware('auth')->group(function () {
    Route::get('/learn/{course:slug}/{lesson?}', [FrontendCourseController::class, 'learn'])->name('courses.learn');
    Route::post('/learn/{course:slug}/{lesson}/complete', [FrontendCourseController::class, 'completeLesson'])->name('courses.lesson.complete');
    Route::post('/enroll/{course:slug}', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::delete('/unenroll/{course:slug}', [EnrollmentController::class, 'unenroll'])->name('courses.unenroll');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('tags', \App\Http\Controllers\TagController::class);
});

Route::middleware(['auth', 'role:Instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::resource('courses', \App\Http\Controllers\CourseController::class);
});

require __DIR__.'/auth.php';
