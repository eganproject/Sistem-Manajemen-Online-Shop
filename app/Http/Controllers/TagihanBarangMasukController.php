<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Pembayaran;
use App\Models\TagihanBarangMasuk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TagihanBarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.tagihan.tagihanbarangmasuk.index', ['tagihan' => TagihanBarangMasuk::latest()->get()]);
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
     * @param  \App\Models\TagihanBarangMasuk  $tagihanBarangMasuk
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tagihan = TagihanBarangMasuk::where('id', $id)->first();
        $pembayaran = Pembayaran::where('slugmain', $tagihan->slugsumber)->latest()->get();
        $transaksi = Transaksi::where('slugmain', $tagihan->slugsumber)->latest()->get();
        $barangmasuk = BarangMasuk::where('slugsumber', $tagihan->slugsumber)->latest()->get();

        return view('dashboard.tagihan.tagihanbarangmasuk.show', ['tagihan' => $tagihan, 'transaksi' => $transaksi, 'barangmasuk' => $barangmasuk, 'pembayaran' => $pembayaran]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TagihanBarangMasuk  $tagihanBarangMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(TagihanBarangMasuk $tagihanBarangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TagihanBarangMasuk  $tagihanBarangMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TagihanBarangMasuk $tagihanBarangMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TagihanBarangMasuk  $tagihanBarangMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(TagihanBarangMasuk $tagihanBarangMasuk)
    {
        //
    }

    public function bayarbarangmasuk(Request $request)
    {
        // dd($request);
        $bayar = ['keterangan' => $request->keterangan, 'slugmain' => $request->slugsumber, 'jumlahbayar' => $request->jumlahbayar];
        Pembayaran::create($bayar);

        $x = Transaksi::where('slugmain', $request->slugsumber)->latest()->first();
        $y = $x->sisa - $request->jumlahbayar;
        Transaksi::create(['keterangan' => $request->keterangan, 'slugmain' => $request->slugsumber,  'jumlah_bayar' => $request->jumlahbayar, 'sisa' => $y]);
        TagihanBarangMasuk::where('slugsumber', $request->slugsumber)->update(['total_tagihan' => $y]);

        return redirect('/dashboard/tagihan/barangmasuk')->with('success', 'Pembayaran berhasil');
    }
}
