<?php
use App\Http\Controllers\PemeliharaanController;

Route::get('/pemeliharaan', [PemeliharaanController::class, 'index']);
Route::get('/pemeliharaan/basedMonths', [PemeliharaanController::class, 'basedMonths']);
Route::get('/pemeliharaan/show/{id}', [PemeliharaanController::class, 'show']);
Route::post('/pemeliharaan/create/', [PemeliharaanController::class, 'store']);
Route::post('/pemeliharaan/update/{id}', [PemeliharaanController::class, 'update']);
Route::delete('/pemeliharaan/delete/{id}', [PemeliharaanController::class, 'destroy']);
