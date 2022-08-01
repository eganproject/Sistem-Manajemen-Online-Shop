<?php

namespace App\Http\Controllers;

use App\Models\TagihanBarangKeluar;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class TagihanBarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tagihan = TagihanBarangKeluar::latest()->paginate(5);
        // dd($tagihan);
        return view('dashboard.tagihan.tagihanbarangkeluar.index', ['tagihan' => $tagihan]);
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
        $bayar = ['keterangan' => $request->keterangan, 'slugmain' => $request->slugsumber, 'jumlahbayar' => $request->jumlahbayar];
        Pembayaran::create($bayar);

        $x = Transaksi::where('slugmain', $request->slugsumber)->latest()->first();
        $y = $x->sisa - $request->jumlahbayar;
        Transaksi::create(['keterangan' => $request->keterangan, 'slugmain' => $request->slugsumber,  'jumlah_tagihan' => $request->jumlahbayar, 'sisa' => $y]);
        TagihanBarangKeluar::where('slugmain', $request->slugsumber)->update(['total_tagihan' => $y]);

        return redirect('/dashboard/tagihan/barangkeluar')->with('success', 'Pembayaran berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $tagihan = TagihanBarangKeluar::where('id', $id)->first();
        $pembayaran = Pembayaran::where('slugmain', $tagihan->slugmain)->latest()->get();
        $transaksi = Transaksi::where('slugmain', $tagihan->slugmain)->latest()->get();
        $penjualan = Penjualan::where('slugkategoripenjualan', $tagihan->slugmain)->latest()->get();

        return view('dashboard.tagihan.tagihanbarangkeluar.show', ['tagihan' => $tagihan, 'pembayaran' => $pembayaran, 'transaksi' => $transaksi, 'penjualan' => $penjualan]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
