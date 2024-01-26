<?php

use App\Http\Controllers\KegiatanPemeliharaanController;

Route::get('/pemeliharaan/kegiatan/{id}', [KegiatanPemeliharaanController::class, 'index']);
Route::post('/pemeliharaan/kegiatan/create/', [KegiatanPemeliharaanController::class, 'store']);
Route::post('/pemeliharaan/kegiatan/update/{id}', [KegiatanPemeliharaanController::class, 'update']);
Route::get('/pemeliharaan/kegiatan/show/{id}', [KegiatanPemeliharaanController::class, 'show']);
Route::delete('/pemeliharaan/kegiatan/delete/{id}', [KegiatanPemeliharaanController::class, 'destroy']);
