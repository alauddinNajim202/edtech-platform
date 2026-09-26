<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CourseController as FrontendCourseController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public Course Catalog
Route::get('/courses', [FrontendCourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [FrontendCourseController::class, 'show'])->name('courses.show');
Route::get('/learn/{course:slug}', [FrontendCourseController::class, 'learn'])->middleware('auth')->name('courses.learn');

Route::middleware('auth')->group(function () {
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
