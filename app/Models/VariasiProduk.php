<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class VariasiProduk extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $with = ['Produk'];

    // protected $foreignKey = ['produk_slug'];

    public function VariasiProdukOption()
    {
        return $this->hasMany(VariasiProdukOption::class, 'variasi_produk_slug', 'slugvariasi');
    }

    public function Produk()
    {
        return $this->hasOne(Produk::class, 'slug', 'produk_slug');
    }

    public function sluggable(): array
    {
        return [
            'slugvariasi' => [
                'source' => 'namavariasi'
            ]
        ];
    }
}
