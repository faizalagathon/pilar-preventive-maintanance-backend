<?php
use App\Http\Controllers\GambarPemeliharaanController;

Route::get('/pemeliharaan/gambar/{id}', [GambarPemeliharaanController::class, 'index']);
Route::post('/pemeliharaan/gambar/create', [GambarPemeliharaanController::class, 'store']);
Route::get('/pemeliharaan/gambar/show/{gambar}', [GambarPemeliharaanController::class, 'show']);
Route::post('/pemeliharaan/gambar/update/{id}', [GambarPemeliharaanController::class, 'update']);
Route::delete('/pemeliharaan/gambar/delete/{id}', [GambarPemeliharaanController::class, 'destroy']);
