<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    use HasFactory;

    public $table = 'bidang';
    public $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'id', 'id_kepala_bidang', 'nama', 'created_at', 'updated_at'
    ];

    /**
     * Get all of the kategori_pemeliharaan for the Bidang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kategori_pemeliharaan(): HasMany
    {
        return $this->hasMany(KategoriPemeliharaan::class, 'id_bidang', 'id');
    }

    /**
     * Get the user that owns the Bidang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_kepala_bidang');
    }
}
