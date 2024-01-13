<?php

namespace App\Models;

use App\Models\KategoriPemeliharaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangInventaris extends Model
{
    use HasFactory;

    public $table = 'barang_inventaris';
    public $incrementing = false;
    public $keyType = false;

    protected $fillable = [
        'id', 'id_kategori_pemeliharaan', 'nama'
    ];

    /**
     * Get the kategoriPemeliharaan that owns the BarangInventaris
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori_pemeliharaan(): BelongsTo
    {
        return $this->belongsTo(KategoriPemeliharaan::class, 'id_kategori_pemeliharaan');
    }

}
