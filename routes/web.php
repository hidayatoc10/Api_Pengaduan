<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login_admin'])->name('login');
    Route::post('/', [AuthController::class, 'login_post']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard_admin', [AdminController::class, 'admin'])->name('dashboard_admin');
    Route::get('/pengguna_sistem', [AdminController::class, 'pengguna_sistem'])->name('pengguna_sistem');
    Route::get('/hapus/{tanggal_lapor}', [AdminController::class, 'hapus_pengaduan']);
    Route::get('/logout', [AdminController::class, 'logout']);
    Route::post('/hapus_pengguna_banyak', [AdminController::class, 'hapusPenggunaBanyak']);
    Route::put('/dashboard_admin/edit_pengaduan/{title}', [AdminController::class, 'edit_pengaduan'])->name('edit_pengaduan');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/logout_user', [AuthController::class, 'logout_user'])->name('logout_user');
});