<?php
// routes/api.php

use App\Http\Controllers\BidangController;

Route::get('/bidang', [BidangController::class, 'index']);
Route::post('/bidang', [BidangController::class, 'store']);
Route::get('/bidang/{id}', [BidangController::class, 'show']);
Route::put('/bidang/{id}', [BidangController::class, 'update']);
Route::delete('/bidang/{id}', [BidangController::class, 'destroy']);


