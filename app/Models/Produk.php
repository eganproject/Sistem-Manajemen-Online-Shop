<?php

namespace App\Models;

use App\Models\ProdukStok;
use App\Models\VariasiProduk;
use App\Models\NonVariasiProduk;
use App\Models\VariasiProdukOption;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];
    // protected $primaryKey = ['id', 'slug'];
    protected $with = ['kategori_produk', 'nonVariasiProduk'];


    public function kategori_produk()
    {
        return $this->belongsTo(kategori_produk::class);
    }
    public function nonVariasiProduk()
    {
        return $this->hasOne(NonVariasiProduk::class, 'produk_slug', 'slug');
    }

    public function VariasiProduk()
    {
        return $this->hasOne(VariasiProduk::class, 'produk_slug', 'slug');
    }

    // public function VariasiProdukOption()
    // {

    //     // Query Error
    //     // $query = "select * from variasi_produk_options as a join variasi_produks as b on b.slugvariasi = a.variasi_produk_slug join produk_stoks as c on c.stokslug = a.produk_stok_slug where produks.slug = b.produk_slug";
    //     // return $this->$query;

    //     // Query Normal Tanpa Produk Stok 
    //     return $this->hasManyThrough(
    //         VariasiProdukOption::class,
    //         VariasiProduk::class,
    //         // ProdukStok::class,
    //         'produk_slug', // Foreign key on the variasiproduk table...
    //         'variasi_produk_slug', // Foreign key on the variasiprodukoption table...
    //         'slug', // Local key on the produk table...
    //         'slugvariasi', // Local key on the variasioption table...
    //         // 'produk_stok_slug',
    //         // 'stok_slug'
    //     );
    // }

    // public function ProdukStok()
    // {
    //     return $this->Manytomany(
    //         ProdukStok::class,
    //         VariasiProdukOption::class,
    //         'produk_stok_slug',
    //         'stokslug'
    //     );
    // }


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'namaproduk'
            ]
        ];
    }
}
