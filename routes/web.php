<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaceController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;

// =======================
// GUEST ROUTES
// =======================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.store');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');



// =======================
// AUTH ROUTES
// =======================
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // USER ROUTES
    Route::get('/face', [FaceController::class, 'index'])->name('face');
    Route::post('/face', [FaceController::class, 'store']);
    Route::post('/face/absen', [FaceController::class, 'store'])->name('face.absen');
    Route::get('/absen/success', fn () => view('hasil-success'))->name('absen.success');
    Route::get('/absen/fail', fn () => view('hasil-fail'))->name('absen.fail');

    // ADMIN ROUTES (pastikan role = admin)
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/absensi', [AdminController::class, 'absensi'])->name('admin.absensi');
        Route::get('/admin/lokasi', [AdminController::class, 'lokasi'])->name('admin.lokasi');
        Route::post('/admin/lokasi', [AdminController::class, 'updateLokasi'])->name('admin.lokasi.update');
        Route::post('/admin/lokasi/toggle', [AdminController::class, 'toggleLokasi'])->name('admin.lokasi.toggle');

    });
Route::get('/test-user', function () {
    if (auth()->check()) {
        return 'Logged in as: ' . auth()->user()->email . ' | Role: ' . auth()->user()->role;
    } else {
        return 'Kamu belum login.';
    }
});


});
