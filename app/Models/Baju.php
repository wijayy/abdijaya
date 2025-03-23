<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Baju extends Model
{
    use HasFactory;

    protected $table = 'baju'; // Nama tabel

    protected $fillable = [
        'nama',
        'slug',
        'image',
        'ukuran',
        'warna'
    ];

    /**
     * Set slug otomatis sebelum menyimpan data.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($baju) {
            if (empty($baju->slug)) {
                $baju->slug = Str::slug($baju->nama);
            }
        });
    }
    public function stoks()
    {
        return $this->hasMany(Stok::class, 'produk_id', 'id');
    }
}
