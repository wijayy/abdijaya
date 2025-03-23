<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukHistory extends Model
{
    use HasFactory;

    protected $table = 'produk_history'; // Nama tabel di database

    protected $fillable = [
        'produk_id',
        'user_id',
        'message'
    ];

    /**
     * Relasi dengan model Baju (Produk).
     */
    public function baju()
    {
        return $this->belongsTo(Baju::class, 'produk_id');
    }

    /**
     * Relasi dengan model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
