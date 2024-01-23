<?php

use App\Http\Controllers\DaftarPemeliharaanController;

Route::get('/daftar_pemeliharaan', [DaftarPemeliharaanController::class, 'index']);
Route::post('/daftar_pemeliharaan/create', [DaftarPemeliharaanController::class, 'store']);
Route::get('/daftar_pemeliharaan/show/{id}', [DaftarPemeliharaanController::class, 'show']);
Route::post('/daftar_pemeliharaan/update/{id}', [DaftarPemeliharaanController::class, 'update']);
Route::delete('/daftar_pemeliharaan/destroy/{id}', [DaftarPemeliharaanController::class, 'destroy']);
