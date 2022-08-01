<?php

namespace App\Http\Controllers;

use App\Models\HargaJual;
use App\Models\kategori_produk;
use App\Models\KategoriPenjualan;
use App\Models\ManajemenHarga;
use App\Models\Produk;
use App\Models\ProdukStok;
use App\Models\SumberBarang;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardMasterDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('dashboard.masterdata.index', ['kategoriproduk' => kategori_produk::latest()->get(), 'sumberbarang' => SumberBarang::latest()->get(), 'kategoripenjualan' => KategoriPenjualan::latest()->get(), 'hargajahit' => ManajemenHarga::latest()->get(), 'produk' => Produk::all(), 'hargajual' => HargaJual::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['namakategori' => 'required']);

        kategori_produk::create($validatedData);

        return redirect('/dashboard/masterdata')->with('success', 'Data ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(['namakategori' => 'required']);

        kategori_produk::where('id', $id)->update($validatedData);

        return redirect('/dashboard/masterdata')->with('success', 'Data diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        kategori_produk::destroy($id);
        return redirect('/dashboard/masterdata')->with('success', 'Data Dihapus');
    }



    public function checkSlugKategoriPenjualan(Request $request)
    {
        $slug = SlugService::createSlug(KategoriPenjualan::class, 'slugkategoripenjualan', $request->namakategoripenjualan);
        return response()->json(['slugkategoripenjualan' => $slug]);
    }

    public function storekategoripenjualan(Request $request)
    {
        $validate = $request->validate(['kategori' => 'required', 'namakategoripenjualan' => 'unique:kategori_penjualans', 'slugkategoripenjualan' => 'unique:kategori_penjualans|unique:sumber_barangs,slugsumber']);

        if ($validate == true) {
            KategoriPenjualan::create($validate);
            return redirect('/dashboard/masterdata')->with('success', 'Data Ditambah');
        } else {
            return redirect('/dashboard/masterdata')->with('notsuccess', 'Data Sudah Ada');
        }
    }

    public function updatekategoripenjualan(Request $request, $id)
    {
        $updatenih = [
            'kategori' => $request->kategori,
            'namakategoripenjualan' => $request->namakategoripenjualan
        ];
        KategoriPenjualan::where('id', $request->id)->update($updatenih);

        return redirect('/dashboard/masterdata')->with('success', 'Update Berhasil');
    }

    public function deletekategoripenjualan($id)
    {
        KategoriPenjualan::destroy('id', $id);
        return redirect('/dashboard/masterdata')->with('success', 'Berhasil dihapus');
    }

    public function checkKategoriPenjualan(Request $request)
    {
        $p = null;

        $y = KategoriPenjualan::where('kategori', $request->kategoripenjualan)->get();


        return response()->json(['kategorijual' => $y]);
    }

    public function storehargajahit(Request $request)
    {
        // dd($request);
        if (ManajemenHarga::where('slugmain', $request->slugsumber)->where('produk_slug', $request->produk_slug)->first() == true) {
            return redirect()->back()->with('success', 'Gagal !! Data Sudah Ada');
        } else {
            ManajemenHarga::create(['slugmain' => $request->slugsumber, 'produk_slug' => $request->produk_slug, 'harga' => $request->harga]);
            return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
        }
    }
    public function deletehargajahit($id)
    {
        ManajemenHarga::destroy($id);
        return redirect()->back()->with('success', 'Data Dihapus');
    }
    public function edithargajahit(Request $request)
    {
        ManajemenHarga::where('id', $request->id)->update(['harga' => $request->harga]);
        return redirect()->back()->with('success', 'Data Diedit');
    }

    public function tambahhargajual()
    {



        return view('dashboard.masterdata.tambahhargajual', ['produk' => Produk::all()]);
    }


    public function tambahsessionbaranghargajual(Request $request)
    {
        $x = null;
        // if (HargaJual::where('slugkategoripenjualan', $request->slugkategoripenjualan)->first() != null) 
        $ktgrpnjlnnya = KategoriPenjualan::where('slugkategoripenjualan', $request->slugkategoripenjualan)->first();
        $y = ['kategoripenjualan' => $request->kategoripenjualan, 'namakategoripenjualan' => $ktgrpnjlnnya->namakategoripenjualan, 'slugkategoripenjualan' => $ktgrpnjlnnya->slugkategoripenjualan];

        $sds = null;
        $produk = Produk::all();
        $variasi = null;
        foreach ($produk as $p) {
            $variasi = null;
            $sds = null;
            if ($p->is_variasi != 1) {
                if (HargaJual::where('produk_stok_slug', $p->nonVariasiProduk->ProdukStok->stokslug)->where('slugkategoripenjualan', $request->slugkategoripenjualan)->first() == null) {

                    $sds[] = ['namavariasi' => $p->namaproduk, 'hargapokok' => $p->nonVariasiProduk->ProdukStok->hargapokok, 'produk_stok_slug' => $p->nonVariasiProduk->ProdukStok->stokslug];
                    $x = ['namaproduk' => $p->namaproduk, 'is_variasi' => 0, 'variasi' => $sds];
                    Session()->push('barang', $x);
                }
            } else {
                foreach ($p->VariasiProduk->VariasiProdukOption as $vpo) {
                    if (HargaJual::where('produk_stok_slug', $vpo->ProdukStok->stokslug)->where('slugkategoripenjualan', $request->slugkategoripenjualan)->first() == null) {
                        $variasi[] = ['namavariasi' => $vpo->namavariasioption, 'hargapokok' => $vpo->ProdukStok->hargapokok, 'produk_stok_slug' => $vpo->ProdukStok->stokslug];
                    }
                }
                if ($variasi != null) {
                    // QUERY INI PR
                    $x = ['namaproduk' => $p->namaproduk, 'is_variasi' => 1, 'variasi' => $variasi];
                    Session()->push('barang', $x);
                }
            }
        }
        if (Session()->get('barang') == true) {

            Session()->put('keterangannya', $y);
            return redirect()->back();
        } else {
            return redirect()->back()->with('success', "Harga jual $ktgrpnjlnnya->kategori : $ktgrpnjlnnya->namakategoripenjualan sudah diisi semua");
        }
        // $pss = array_unique($x);
    }



    public function hapussessionbaranghargajual(Request $request)
    {

        // dd($request);
        // $barangmasuk = $request->session()->get('barangmasuk');
        $nomor = $request->id;
        // $k = array_filter($barangmasuk, function ($var) use ($slug) {
        //     return ($var['slug'] == $slug);
        // });
        // dd(session()->get("barangmasuk.$nomor"));

        session()->forget("barang.$nomor");
        // reset image array
        // Session()->pull('barangmasuk');
        // $final_session = array_values($final_session);

        return redirect()->back();
    }

    public function hapussessionsemuabaranghargajual(Request $request)
    {
        session()->forget("barang");
        session()->forget("keterangannya");
        return redirect()->back();
    }

    public function storehargajual(Request $request)
    {

        $x = count($request->hargajual);
        for ($i = 0; $i < $x; $i++) {
            if ($request->hargajual[$i] != 0) {
                $y = ['slugkategoripenjualan' => $request->slugkategoripenjualan, 'produk_stok_slug' => $request->produk_stok_slug[$i], 'hargajual' => $request->hargajual[$i]];
                HargaJual::create($y);
            }
        }

        Session()->forget('barang');
        Session()->forget('keterangannya');
        return redirect()->back()->with('success', 'Data ditambahkan');
    }

    public function edithargajual(Request $request)
    {
        Hargajual::where('id', $request->id)->update(['hargajual' => $request->hargajual]);
        return redirect()->back()->with('success', 'Harga Jual diubah');
    }

    public function checkProduknya(Request $request)
    {

        $z = null;
        foreach (Produk::all() as $p) {
            if (ManajemenHarga::where('slugmain', $request->slugsumber)->where('produk_slug', $p->slug)->first() == null) {


                $z[] = ['namaproduk' => $p->namaproduk, 'slug' => $p->slug];
            }
        }
        return response()->json(['produk' => $z]);
    }
}
