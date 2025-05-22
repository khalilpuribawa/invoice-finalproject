<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserInvoiceController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminPaymentMethodController;

Route::get('/', function () {
     return redirect()->route('login'); // Atau redirect ke login
});

// Breeze akan membuat route /dashboard, kita override atau modifikasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard'); // Nama route tetap 'dashboard' untuk kompatibilitas Breeze

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Routes
    Route::middleware(['user-access'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::resource('invoices', UserInvoiceController::class);
        // UserInvoiceController akan menangani:
        // index (lihat riwayat), create, store (buat baru), show (lihat detail),
        // edit, update (edit), destroy (hapus)
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', AdminUserController::class); // Kelola pengguna
        Route::get('/invoices', [AdminInvoiceController::class, 'index'])->name('invoices.index'); // Lihat rekap semua invoice
        Route::put('/invoices/{invoice}/update-status', [AdminInvoiceController::class, 'updateStatus'])->name('invoices.update-status'); // Update status bayar

        Route::resource('payment-methods', AdminPaymentMethodController::class); // Kelola metode pembayaran
    });
});

require __DIR__.'/auth.php'; // Route auth dari Breeze