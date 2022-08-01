<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['SumberBarang', 'VariasiProdukOption', 'ProdukStok'];

    public function SumberBarang()
    {
        return $this->belongsTo(SumberBarang::class, 'slugsumber', 'slugsumber');
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
