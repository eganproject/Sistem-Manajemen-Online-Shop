<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariasiProdukOption extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['VariasiProduk', 'ProdukStok'];

    public function ProdukStok()
    {
        return $this->hasOne(ProdukStok::class, 'stokslug', 'produk_stok_slug');
    }

    public function VariasiProduk()
    {
        return $this->hasOne(VariasiProduk::class, 'slugvariasi', 'variasi_produk_slug');
    }
}
