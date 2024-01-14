<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarPemeliharaan extends Model
{
    use HasFactory;

    public $table = 'gambar_pemeliharaan';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'id_pemeliharaan', 'gambar'
    ];

    /**
     * Get the pemeliharaan that owns the Pemeliharaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemeliharaan(): BelongsTo
    {
        return $this->belongsTo(Pemeliharaan::class, 'id_pemeliharaan');
    }
}
