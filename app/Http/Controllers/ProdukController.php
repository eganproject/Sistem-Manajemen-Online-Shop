<?php

namespace App\Http\Controllers;

use App\Models\kategori_produk;
use App\Models\NonVariasiProduk;
use App\Models\Produk;
use App\Models\ProdukStok;
use App\Models\VariasiProduk;
use App\Models\VariasiProdukOption;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $produk = Produk::all();

        return view('dashboard.produk.index', ['produk' => $produk, 'kategoriproduk' => kategori_produk::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.produk.create', ['kategoriproduk' => kategori_produk::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validproduk = $request->validate(['namaproduk' => 'required|unique:produks', 'slug' => 'required', 'kategori_produk_id' => 'required']);

        if ($request->is_variasi == 1) {

            $validproduk['is_variasi'] = 1;
            // $validatedData['is_variasi'] = $request->is_variasi;

            // if ($request->is_variasi != 1) {
            //     dd($request);
            // }

            Produk::create($validproduk);

            $validprodukvariasi = $request->validate(['namavariasi' => 'required', 'slugvariasi' => 'required']);
            $validprodukvariasi['produk_slug'] = $request->slug;

            VariasiProduk::create($validprodukvariasi);


            $stok = 0;
            $totalsemua = 0;
            for ($i = 0; $i < count($request->namavariasioption); $i++) {
                $totalhargapervariasi[$i] = $request->stok[$i] * $request->hargapokok[$i];
                $stokslug[$i] = md5(uniqid(rand(), true));
                $validvariasioption['namavariasioption'] = $request->namavariasioption[$i];
                $validvariasioption['variasi_produk_slug'] = $request->slugvariasi;
                $validvariasioption['produk_stok_slug'] = $stokslug[$i];



                $validstokproduk['stok'] = $request->stok[$i];
                $validstokproduk['stokslug'] = $stokslug[$i];
                $validstokproduk['hargapokok'] = $request->hargapokok[$i];
                $validstokproduk['totalhargapokok'] = $totalhargapervariasi[$i];

                VariasiProdukOption::create($validvariasioption);
                ProdukStok::create($validstokproduk);
            }

            return redirect('/dashboard/produk')->with('success', 'Produk ditambahkan');
        } else {
            $buatslug = md5(uniqid(rand(), true));
            $produk = $request->validate(['namaproduk' => 'required|unique:produks', 'slug' => 'required']);
            $produk['kategori_produk_id'] = $request->kategori_produk_id;
            $produk['is_variasi'] = 0;

            $nonvariasi['produk_slug'] = $request->slug;
            $nonvariasi['produk_stok_slug'] = $buatslug;

            $produk_stok['stokslug'] = $buatslug;
            $produk_stok['stok'] = $request->stok;
            $produk_stok['hargapokok'] = $request->hargapokok;
            $produk_stok['totalhargapokok'] = $request->stok * $request->hargapokok;
            Produk::create($produk);
            NonVariasiProduk::create($nonvariasi);
            ProdukStok::create($produk_stok);

            return redirect('/dashboard/produk')->with('success', 'Produk ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        $kategori = kategori_produk::all();






        if ($produk->is_active == 1) {

            return view('dashboard.produk.show', ['produk' => $produk, 'kategoriproduk' => $kategori]);
        }
        return view('dashboard.produk.show', ['produk' => $produk, 'kategoriproduk' => $kategori]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $validatedData = $request->validate(['namaproduk' => 'required', 'kategori_produk_id' => 'required']);
        $is_variasi = $request->is_variasi;

        if ($is_variasi == 1) {
            $idproduk = $request->id_produk;
            $validproduk['namaproduk'] = $request->namaproduk;
            $validproduk['kategori_produk_id'] = $request->kategori_produk_id;

            Produk::where('id', $idproduk)->update($validproduk);

            $idvariasi = $request->id_variasi;
            $validprodukvariasi['namavariasi'] = $request->namavariasi;

            VariasiProduk::where('id', $idvariasi)->update($validprodukvariasi);


            $stok = 0;
            $totalsemua = 0;
            for ($i = 0; $i < count($request->namavariasioption); $i++) {
                $totalhargapervariasi[$i] = $request->stok[$i] * $request->hargapokok[$i];
                $stokslug[$i] = md5(uniqid(rand(), true));

                $idvariasiprodukoption = $request->id_variasioption[$i];
                $validvariasioption['namavariasioption'] = $request->namavariasioption[$i];



                $idprodukstok = $request->id_produkstok[$i];
                $validstokproduk['stok'] = $request->stok[$i];
                $validstokproduk['hargapokok'] = $request->hargapokok[$i];
                $validstokproduk['totalhargapokok'] = $totalhargapervariasi[$i];

                VariasiProdukOption::where('id', $idvariasiprodukoption)->update($validvariasioption);
                ProdukStok::where('id', $idprodukstok)->update($validstokproduk);
            }
            return redirect('/dashboard/produk')->with('success', "Produk $validproduk[namaproduk] diupdate ");
        } else {

            $idproduk = $request->id_produk;
            $produk['namaproduk'] = $request->namaproduk;
            $produk['kategori_produk_id'] = $request->kategori_produk_id;



            $id_produkstok = $request->id_produkstok;
            $produk_stok['stok'] = $request->stok;
            $produk_stok['hargapokok'] = $request->hargapokok;
            $produk_stok['totalhargapokok'] = $request->stok * $request->hargapokok;
            Produk::where('id', $idproduk)->update($produk);
            ProdukStok::where('id', $id_produkstok)->update($produk_stok);
            // dd($request);
            return redirect('/dashboard/produk')->with('success', 'Produk Diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Produk::destroy($id);
        $produk = Produk::find($id);
        if ($produk->is_variasi == 1) {
            foreach ($produk->VariasiProduk->Variasiprodukoption as $variasioption) {

                VariasiProdukOption::destroy($variasioption->id);
                ProdukStok::destroy($variasioption->ProdukStok->id);
            }
            VariasiProduk::destroy($produk->VariasiProduk->id);
            Produk::destroy($id);

            return redirect('/dashboard/produk')->with('success', 'Produk dan Variasi Dihapus');
        } else {
            NonVariasiProduk::destroy($produk->NonVariasiProduk->id);
            ProdukStok::destroy($produk->NonVariasiProduk->ProdukStok->id);
            Produk::destroy($id);
            return redirect('/dashboard/produk')->with('success', 'Produk Non Variasi Dihapus');
        }
    }




    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Produk::class, 'slug', $request->namaproduk);

        return response()->json(['slug' => $slug]);
    }
    public function checkSlugVariasi(Request $request)
    {
        $slugvariasi = SlugService::createSlug(VariasiProduk::class, 'slugvariasi', $request->namavariasi);

        return response()->json(['slugvariasi' => $slugvariasi]);
    }
}
