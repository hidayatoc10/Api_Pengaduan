<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/registrasi', [AuthController::class, 'registrasi']);
Route::get('/semua_pengaduan', [PengaduanController::class, 'semua_pengaduan'])->name('semua_pengaduan');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/pengaduan_user', [PengaduanController::class, 'pengaduan'])->name('pengaduan');
    Route::post('/add_pengaduan', [PengaduanController::class, 'add_pengaduan'])->name('add_pengaduan');
    Route::get('/pengaduan_user/delete/{title}', [PengaduanController::class, 'delete_pengaduan'])->name('delete_pengaduan');
    Route::get('/pengaduan_user/cari/{title}', [PengaduanController::class, 'cari'])->name('cari');
    Route::get('/pengaduan_user/view/{title}', [PengaduanController::class, 'view'])->name('view');
    Route::put('/user/edit/{username}', [AuthController::class, 'edit_user'])->name('edit_user');
});