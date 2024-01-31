<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


require __DIR__.'/barang_inventaris.php';
require __DIR__.'/kegiatan_pemeliharaan.php';
require __DIR__.'/kategori_pemeliharaan.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/daftar_pemeliharaan.php';

require __DIR__ . '/pemeliharaan.php';
require __DIR__ . '/generate_qr_code.php';
require __DIR__ . '/user.php';
require __DIR__ . '/gambar_pemeliharaan.php';
require __DIR__ . '/daftar_pemeliharaan.php';
