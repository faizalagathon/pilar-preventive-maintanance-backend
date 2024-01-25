<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DaftarPemeliharaan extends Model
{
    use HasFactory;

    public $table = 'daftar_pemeliharaan';
    public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;


    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'id', 'id_pemeliharaan','id_kegiatan_pemeliharaan'
    ];

    /**
     * Get the barang_inventaris that owns the Pemeliharaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemeliharaan(): BelongsTo
    {
        return $this->belongsTo(Pemeliharaan::class, 'id_pemeliharaan');
    }

    public function kegiatan_pemeliharaan(): BelongsTo
    {
        return $this->belongsTo(KegiatanPemeliharaan::class, 'id_kegiatan_pemeliharaan');
    }

    /**
     * Get all of the gambar_pemeliharaan for the Pemeliharaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

}
