<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GambarPemeliharaan extends Model
{
    use HasFactory;

    public $table = 'gambar_pemeliharaan';
    public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = [
        'created_at', 'updated_at'
    ];

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
