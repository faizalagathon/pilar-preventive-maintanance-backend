<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemeliharaan extends Model
{
    use HasFactory;

    public $table = 'pemeliharaan';
    public $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'id', 'id_barang_inventaris', 'tanggal', 'catatan', 'created_at', 'updated_at'
    ];

    /**
     * Get the barang_inventaris that owns the Pemeliharaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang_inventaris(): BelongsTo
    {
        return $this->belongsTo(BarangInventaris::class, 'id_barang_inventaris');
    }

    /**
     * Get all of the gambar_pemeliharaan for the Pemeliharaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gambar_pemeliharaan(): HasMany
    {
        return $this->hasMany(GambarPemeliharaan::class, 'id_pemeliharaan');
    }

    public function daftar_pemeliharaan(): HasMany
    {
        return $this->hasMany(DaftarPemeliharaan::class, 'id_pemeliharaan','id');
    }
}
