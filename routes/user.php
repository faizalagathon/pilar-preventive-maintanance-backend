<?php

use App\Http\Controllers\UserController;

Route::get('/user', [UserController::class, 'index']);
Route::get('/user/kepala-bidang', [UserController::class, 'kepalaBidang']);
Route::get('/user/count', [UserController::class, 'count']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user/tambah', [UserController::class, 'store']);
Route::put('/user/edit/{id}', [UserController::class, 'update']);
Route::delete('/user/hapus/{id}', [UserController::class, 'destroy']);

