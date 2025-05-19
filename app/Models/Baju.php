<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Baju extends Model
{
    use HasFactory, Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama',
                'onUpdate' => true,
            ]
        ];
    }

    protected $table = 'baju'; // Nama tabel

    protected $fillable = [
        'nama',
        'slug',
        'image',
        'ukuran',
        'warna'
    ];

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'produk_id', 'id');
    }

    public function scopeFilters(Builder  $query, array $filters)
    {
        $query->when($filters["search"] ?? false, function ($query, $search) {
            return $query->where("nama", 'LIKE',  "%$search%");
        });
    }
}
