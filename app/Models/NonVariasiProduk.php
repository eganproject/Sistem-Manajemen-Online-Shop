<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonVariasiProduk extends Model
{
    use HasFactory;
    protected $foreignKey = ['produk_slug'];
    protected $guarded = ['id'];


    public function produk()
    {
        return $this->hasOne(Produk::class, 'slug', 'produk_slug');
    }

    public function ProdukStok()
    {
        return $this->hasOne(ProdukStok::class, 'stokslug', 'produk_stok_slug');
    }
}
