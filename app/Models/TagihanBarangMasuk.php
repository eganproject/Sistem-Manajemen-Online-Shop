<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanBarangMasuk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['Produk', 'SumberBarang'];


    public function Produk()
    {
        return $this->hasOne(Produk::class, 'slug', 'produk_slug');
    }
    public function SumberBarang()
    {
        return $this->hasOne(SumberBarang::class, 'slugsumber', 'slugsumber');
    }
}
