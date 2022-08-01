<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukStok extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function VariasiProdukOption()
    {
        return $this->hasOne(VariasiProdukOption::class, 'produk_stok_slug', 'stokslug');
    }
    public function nonVariasiProduk()
    {
        return $this->hasOne(NonVariasiProduk::class, 'produk_stok_slug', 'stokslug');
    }
}
