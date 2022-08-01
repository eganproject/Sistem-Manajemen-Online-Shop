<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request());
        if (request()->start_date) {
            if (request()->end_date == null) {
                $start_date = request()->start_date;
                $barangmasuk = BarangMasuk::where('created_at', 'like', '%' . $start_date . '%')->get();
                return view('dashboard.barangmasuk.index', ['barangmasuk' => $barangmasuk]);
            } else {

                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->endOfDay();
                $barangmasuk = BarangMasuk::whereBetween('created_at', [$start_date, $end_date])->get();
                // dd($barangmasuk);
                return view('dashboard.barangmasuk.index', ['barangmasuk' => $barangmasuk]);
            }
        } else {
            $barangmasuk = BarangMasuk::latest()->get();
            return view('dashboard.barangmasuk.index', ['barangmasuk' => $barangmasuk]);
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        //
    }
    public function showbarangmasukproduk($id)
    {

        if (request()->start_date) {
            if (request()->end_date == null) {
                $barangmasuk = BarangMasuk::where('id', $id)->first();
                $start_date = request()->start_date;
                $data = BarangMasuk::where('produk_stok_slug', $barangmasuk->produk_stok_slug)->where('created_at', 'like', '%' . $start_date . '%')->get();
                $id = $barangmasuk->id;
                if ($barangmasuk->VariasiProdukOption == null) {

                    $namaproduk = $barangmasuk->nonVariasiProduk->Produk->namaproduk;
                } else {
                    $namaproduk = $barangmasuk->VariasiProdukOption->VariasiProduk->Produk->namaproduk;
                }

                return view('dashboard.barangmasuk.show', ['data' => $data, 'id' => $id, 'namaproduk' => $namaproduk]);
            } else {
                $barangmasuk = BarangMasuk::where('id', $id)->first();

                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->endOfDay();
                $data = barangmasuk::where('produk_stok_slug', $barangmasuk->produk_stok_slug)->whereBetween('created_at', [$start_date, $end_date])->get();
                $id = $barangmasuk->id;
                if ($barangmasuk->VariasiProdukOption == null) {

                    $namaproduk = $barangmasuk->nonVariasiProduk->Produk->namaproduk;
                } else {
                    $namaproduk = $barangmasuk->VariasiProdukOption->VariasiProduk->Produk->namaproduk;
                }
                // dd($penjualan);
                return view('dashboard.barangmasuk.show', ['data' => $data, 'id' => $id, 'namaproduk' => $namaproduk]);
            }
        } else {
            $barangmasuk = BarangMasuk::where('id', $id)->first();
            $data = BarangMasuk::where('produk_stok_slug', $barangmasuk->produk_stok_slug)->latest()->get();
            $id = $barangmasuk->id;
            if ($barangmasuk->VariasiProdukOption == null) {

                $namaproduk = $barangmasuk->nonVariasiProduk->Produk->namaproduk;
            } else {
                $namaproduk = $barangmasuk->VariasiProdukOption->VariasiProduk->Produk->namaproduk;
            }

            // dd($id);
            return view('dashboard.barangmasuk.show', ['data' => $data, 'id' => $id, 'namaproduk' => $namaproduk]);
        }
    }

    public function showbarangmasuknamasumber($id)
    {

        if (request()->start_date) {
            if (request()->end_date == null) {
                $barangmasuk = BarangMasuk::where('id', $id)->first();
                $start_date = request()->start_date;
                $data = BarangMasuk::where('slugsumber', $barangmasuk->slugsumber)->where('created_at', 'like', '%' . $start_date . '%')->get();
                $id = $barangmasuk->id;
                $nama = $barangmasuk->SumberBarang->namasumber;
                return view('dashboard.barangmasuk.show', ['data' => $data, 'id' => $id, 'nama' => $nama]);
            } else {
                $barangmasuk = BarangMasuk::where('id', $id)->first();

                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->endOfDay();
                $data = BarangMasuk::where('slugsumber', $barangmasuk->slugsumber)->whereBetween('created_at', [$start_date, $end_date])->get();
                $id = $barangmasuk->id;
                $nama = $barangmasuk->SumberBarang->namasumber;
                // dd($penjualan);
                return view('dashboard.barangmasuk.show', ['data' => $data, 'id' => $id, 'nama' => $nama]);
            }
        } else {
            $barangmasuk = BarangMasuk::where('id', $id)->first();
            $data = BarangMasuk::where('slugsumber', $barangmasuk->slugsumber)->latest()->get();
            $id = $barangmasuk->id;
            $nama = $barangmasuk->SumberBarang->namasumber;

            // dd($id);
            return view('dashboard.barangmasuk.show', ['data' => $data, 'id' => $id, 'nama' => $nama]);
        }
    }
}
