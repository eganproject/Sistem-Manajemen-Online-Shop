<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaJual extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['nonVariasiProduk', 'VariasiProdukOption', 'KategoriPenjualan'];

    public function nonVariasiProduk()
    {
        return $this->hasOne(NonVariasiProduk::class, 'produk_stok_slug', 'produk_stok_slug');
    }
    public function VariasiProdukOption()
    {
        return $this->hasOne(VariasiProdukOption::class, 'produk_stok_slug', 'produk_stok_slug');
    }
    public function KategoriPenjualan()
    {
        return $this->hasOne(KategoriPenjualan::class, 'slugkategoripenjualan', 'slugkategoripenjualan');
    }
}
