<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['SumberBarang', 'KategoriPenjualan'];

    public function SumberBarang()
    {
        return $this->hasOne(SumberBarang::class, 'slugsumber', 'slugmain');
    }

    public function KategoriPenjualan()
    {
        return $this->hasOne(KategoriPenjualan::class, 'slugkategoripenjualan', 'slugmain');
    }
}
