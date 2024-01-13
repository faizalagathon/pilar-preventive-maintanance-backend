<?php

namespace App\Models;

use App\Models\BarangInventaris;
use App\Models\KegiatanPemeliharaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriPemeliharaan extends Model
{
    use HasFactory;

    public $table = 'kategori_pemeliharaan';
    public $keyType = 'string';
    public $incrementing = false;
    
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'id', 'nama', 'created_at', 'updated_at'
    ];

    /**
     * Get all of the kegiatanPemeliharaan for the KategoriPemeliharaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kegiatan_pemeliharaan(): HasMany
    {
        return $this->hasMany(KegiatanPemeliharaan::class, 'id_kategori_pemeliharaan');
    }


    /**
     * Get all of the barangInventaris for the KategoriPemeliharaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barang_inventaris(): HasMany
    {
        return $this->hasMany(BarangInventaris::class, 'id_kategori_pemeliharaan');
    }

}
