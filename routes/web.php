<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduledClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth'/* , 'verified' */])->name('dashboard');

/* ===================================================
   INSTRUCTOR ROUTES
===================================================*/
// Route::get('/instructor/dashboard', function () {
//     return view('instructor.dashboard');
// })
//     ->middleware(['auth', 'role:instructor'/* , 'verified' */])->name('instructor.dashboard'); // the parameter after role is the one we use in our middleware String $role (middleware parameters)

// Route::resource('/instructor/schedule', ScheduledClassController::class)
//     ->only(['index', 'create', 'store', 'destroy'])
//     ->middleware(['auth', 'role:instructor'/* , 'verified' */]); // the parameter after role is the one we use in our middleware String $role (middleware parameters)

Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', function () {
        return view('instructor.dashboard');
    })->name('instructor.dashboard');
    Route::resource('/instructor/schedule', ScheduledClassController::class)
        ->only(['index', 'create', 'store', 'destroy']);
});

/* ===================================================
   MEMBERS ROUTES
===================================================*/
// Route::get('/member/dashboard', function () {
//     return view('member.dashboard');
// })->middleware(['auth', 'role:member'/* , 'verified' */])->name('member.dashboard'); // the parameter after role is the one we use in our middleware String $role (middleware parameters)
// Route::get('/member/book', [BookingController::class, 'create'])->middleware(['auth', 'role:member'/* , 'verified' */])->name('booking.create'); // the parameter after role is the one we use in our middleware String $role (middleware parameters)
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->name('member.dashboard');
    Route::get('/member/book', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/member/bookings', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/member/bookings', [BookingController::class, 'index'])->name('booking.index');
    Route::delete('/member/bookings/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
});



Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'/* , 'verified' */])->name('admin.dashboard'); // the parameter after role is the one we use in our middleware String $role (middleware parameters)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
