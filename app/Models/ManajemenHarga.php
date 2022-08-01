<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenHarga extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Produk()
    {
        return $this->hasOne(Produk::class, 'slug', 'produk_slug');
    }
    public function SumberBarang()
    {
        return $this->hasOne(SumberBarang::class, 'slugsumber', 'slugmain');
    }
}
