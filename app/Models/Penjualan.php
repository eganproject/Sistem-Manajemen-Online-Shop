<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['VariasiProdukOption', 'ProdukStok', 'KategoriPenjualan', 'nonVariasiProduk'];

    // public function scopeFilter($query, array $filters)
    // {
    //     return dd($query);
    // }


    public function KategoriPenjualan()
    {
        return $this->belongsTo(KategoriPenjualan::class, 'slugkategoripenjualan', 'slugkategoripenjualan');
    }
    public function VariasiProdukOption()
    {
        return $this->belongsTo(VariasiProdukOption::class, 'produk_stok_slug', 'produk_stok_slug');
    }
    public function ProdukStok()
    {
        return $this->hasOne(ProdukStok::class, 'stokslug', 'produk_stok_slug');
    }

    public function nonVariasiProduk()
    {
        return $this->belongsTo(NonVariasiProduk::class, 'produk_stok_slug', 'produk_stok_slug');
    }
}
