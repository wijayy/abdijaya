<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok'; // Nama tabel di database

    protected $fillable = [
        'produk_id',
        'ukuran',
        'warna',
        'qty',
        'harga',
    ];

    /**
     * Relasi dengan model Baju (One to One atau One to Many).
     */
    public function baju()
    {
        return $this->belongsTo(Baju::class, 'produk_id');
    }
}
