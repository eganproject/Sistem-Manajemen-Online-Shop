<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->start_date) {
            if (request()->end_date == null) {
                $start_date = request()->start_date;
                $penjualans = Penjualan::where('created_at', 'like', '%' . $start_date . '%')->get();
                return view('dashboard.penjualan.index', ['penjualans' => $penjualans]);
            } else {

                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->endOfDay();
                $penjualans = Penjualan::whereBetween('created_at', [$start_date, $end_date])->get();
                // dd($penjualan);
                return view('dashboard.penjualan.index', ['penjualans' => $penjualans]);
            }
        } else {
            $penjualans = Penjualan::with('VariasiProdukOption')->latest()->get();
            return view('dashboard.penjualan.index', ['penjualans' => $penjualans]);
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
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {

        // if (request()->start_date) {
        //     if (request()->end_date == null) {
        //         $start_date = request()->start_date;
        //         $data = Penjualan::where('produk_stok_slug', $penjualan->produk_stok_slug)->where('created_at', 'like', '%' . $start_date . '%')->get();
        //         return view('dashboard.penjualan.show', ['data' => $data]);
        //     } else {

        //         $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
        //         $end_date = Carbon::parse(request()->end_date)->endOfDay();
        //         $data = Penjualan::where('produk_stok_slug', $penjualan->produk_stok_slug)->whereBetween('created_at', [$start_date, $end_date])->get();
        //         // dd($penjualan);
        //         return view('dashboard.penjualan.show', ['data' => $data]);
        //     }
        // } else {
        //     $data = Penjualan::where('produk_stok_slug', $penjualan->produk_stok_slug)->latest()->get();
        //     $id = $penjualan->id;

        //     // dd($id);
        //     return view('dashboard.penjualan.show', ['data' => $data, 'id' => $id]);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }

    public function showpenjualanproduk($id)
    {

        if (request()->start_date) {
            if (request()->end_date == null) {
                $penjualan = Penjualan::where('id', $id)->first();
                $start_date = request()->start_date;
                $data = Penjualan::where('produk_stok_slug', $penjualan->produk_stok_slug)->where('created_at', 'like', '%' . $start_date . '%')->get();
                $id = $penjualan->id;
                if ($penjualan->VariasiProdukOption == null) {
                    $namaproduk = $penjualan->nonVariasiProduk->Produk->namaproduk;
                } else {
                    $namaproduk = $penjualan->VariasiProdukOption->VariasiProduk->Produk->namaproduk;
                }

                return view('dashboard.penjualan.show', ['data' => $data, 'id' => $id, 'namaproduk' => $namaproduk]);
            } else {
                $penjualan = Penjualan::where('id', $id)->first();

                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->endOfDay();
                $data = Penjualan::where('produk_stok_slug', $penjualan->produk_stok_slug)->whereBetween('created_at', [$start_date, $end_date])->get();
                $id = $penjualan->id;
                if ($penjualan->VariasiProdukOption == null) {
                    $namaproduk = $penjualan->nonVariasiProduk->Produk->namaproduk;
                } else {
                    $namaproduk = $penjualan->VariasiProdukOption->VariasiProduk->Produk->namaproduk;
                }

                return view('dashboard.penjualan.show', ['data' => $data, 'id' => $id, 'namaproduk' => $namaproduk]);
            }
        } else {
            $penjualan = Penjualan::where('id', $id)->first();
            $data = Penjualan::where('produk_stok_slug', $penjualan->produk_stok_slug)->latest()->get();
            $id = $penjualan->id;

            if ($penjualan->VariasiProdukOption == null) {
                $namaproduk = $penjualan->nonVariasiProduk->Produk->namaproduk;
            } else {
                $namaproduk = $penjualan->VariasiProdukOption->VariasiProduk->Produk->namaproduk;
            }

            return view('dashboard.penjualan.show', ['data' => $data, 'id' => $id, 'namaproduk' => $namaproduk]);
        }
    }

    public function showpenjualannamakategoripenjualan($id)
    {

        if (request()->start_date) {
            if (request()->end_date == null) {
                $penjualan = Penjualan::where('id', $id)->first();
                $start_date = request()->start_date;
                $data = Penjualan::where('slugkategoripenjualan', $penjualan->slugkategoripenjualan)->where('created_at', 'like', '%' . $start_date . '%')->get();
                $id = $penjualan->id;
                $nama = $penjualan->KategoriPenjualan->namakategoripenjualan;
                return view('dashboard.penjualan.show', ['data' => $data, 'id' => $id, 'nama' => $nama]);
            } else {
                $penjualan = Penjualan::where('id', $id)->first();

                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->endOfDay();
                $data = Penjualan::where('slugkategoripenjualan', $penjualan->slugkategoripenjualan)->whereBetween('created_at', [$start_date, $end_date])->get();
                $id = $penjualan->id;
                $nama = $penjualan->KategoriPenjualan->namakategoripenjualan;
                return view('dashboard.penjualan.show', ['data' => $data, 'id' => $id, 'nama' => $nama]);
            }
        } else {
            $penjualan = Penjualan::where('id', $id)->first();
            $data = Penjualan::where('slugkategoripenjualan', $penjualan->slugkategoripenjualan)->latest()->get();
            $id = $penjualan->id;

            $nama = $penjualan->KategoriPenjualan->namakategoripenjualan;
            return view('dashboard.penjualan.show', ['data' => $data, 'id' => $id, 'nama' => $nama]);
        }
    }
}
