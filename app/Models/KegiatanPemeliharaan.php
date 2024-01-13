<?php

namespace App\Models;

use App\Models\KategoriPemeliharaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KegiatanPemeliharaan extends Model
{
    use HasFactory;

    public $table = 'kegiatan_pemeliharaan';
    public $keyType = false;
    public $incrementing = false;

    protected $fillable = [
        'id', 'id_kategori_pemeliharaan', 'nama_kegiatan'
    ];

    /**
     * Get the kategoriPemeliharaan that owns the KegiatanPemeliharaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori_pemeliharaan(): BelongsTo
    {
        return $this->belongsTo(KategoriPemeliharaan::class, 'id_kategori_pemeliharaan');
    }

}
