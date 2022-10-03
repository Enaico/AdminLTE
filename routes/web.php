<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    GuruController,
    KelasController,
    MapelController,
    SiswaController
};

Route::get('/', function () {
    return view('layout.app');
});

// Route Guru
Route::resource('/guru', GuruController::class);


// Route Kelas
Route::resource('/kelas', KelasController::class);


// Route Mapel
Route::get('/mapel/data', [MapelController::class, 'data'])->name('mapel.data');
Route::resource('/mapel', MapelController::class);

// Route Siswa
Route::resource('/siswa', SiswaController::class);