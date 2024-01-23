<?php
use App\Http\Controllers\BarangInventarisController;

Route::get('/qr-code/{id}', [BarangInventarisController::class, 'showQrCode']);


