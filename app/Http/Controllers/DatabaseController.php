<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\HargaJual;
use App\Models\KategoriPenjualan;
use App\Models\ManajemenHarga;
use App\Models\NonVariasiProduk;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\ProdukStok;
use App\Models\SumberBarang;
use App\Models\TagihanBarangKeluar;
use App\Models\TagihanBarangMasuk;
use App\Models\Transaksi;
use App\Models\VariasiProdukOption;
use Illuminate\Support\Facades\DB;
use Session;

class DatabaseController extends Controller
{
    public function index()
    {

        $produk = Produk::all();
        return view('dashboard.database.index', ['produk' => $produk]);
    }
    public function barangmasuk()
    {
        $penjahit = SumberBarang::where('jenissumber', 'Penjahit')->get();
        $produk = Produk::all();
        return view('dashboard.database.barangmasuk', ['produk' => $produk, 'penjahit' => $penjahit]);
    }

    public function penjualan()
    {

        return view('dashboard.database.penjualan', ['produk' => Produk::all()]);
    }

    public function tambahsessionbarang(Request $request)
    {
        $p = Produk::find($request->id);

        // dd($p->VariasiProduk->VariasiProdukOption);
        if ($p->is_variasi == 1) {

            $variasiOption = null;
            foreach ($p->VariasiProduk->VariasiProdukOption as $ps) {
                $variasiOption[] = ['namavariasioption' => $ps->namavariasioption, 'produk_stok_slug' => $ps->produk_stok_slug, 'oldstok' => $ps->ProdukStok->stok];
            }
        }
        // dd($variasiOption);
        if ($request->session()->get('barangmasuk') == null) {

            if ($p->is_variasi == 1) {

                $barangmasuk = ['namabarang' => $p->namaproduk, 'slug' => $p->slug, 'variasi' => $variasiOption, 'is_variasi' => '1', 'id_array' => 0];

                Session()->push('barangmasuk', $barangmasuk);
                return redirect()->back();
            } else {
                $v[] = ['namavariasioption' => 'Stok', 'produk_stok_slug' => $p->nonVariasiProduk->produk_stok_slug, 'oldstok' => $p->nonVariasiProduk->ProdukStok->stok];
                $barangmasuk = ['namabarang' => $p->namaproduk, 'slug' => $p->slug, 'variasi' => $v, 'id_array' => 0, 'is_variasi' => '0'];


                Session()->push('barangmasuk', $barangmasuk);
                return redirect()->back();
            }
        } else {
            $x = count($request->session()->get('barangmasuk'));
            $i = $x;
            if ($p->is_variasi == 1) {
                $barangmasuk = ['namabarang' => $p->namaproduk, 'slug' => $p->slug, 'variasi' => $variasiOption, 'id_array' => $i, 'is_variasi' => '1'];
                Session()->push('barangmasuk', $barangmasuk);

                return redirect()->back();
            } else {
                $v[] = ['namavariasioption' => 'Stok', 'produk_stok_slug' => $p->nonVariasiProduk->produk_stok_slug, 'oldstok' => $p->nonVariasiProduk->ProdukStok->stok];
                $barangmasuk = ['namabarang' => $p->namaproduk, 'slug' => $p->slug, 'variasi' => $v, 'id_array' => $i, 'is_variasi' => '0'];
                Session()->push('barangmasuk', $barangmasuk);

                return redirect()->back();
            }
        }
    }



    public function hapussessionbarangmasuk(Request $request)
    {

        // dd($request);
        // $barangmasuk = $request->session()->get('barangmasuk');
        $nomor = $request->id;
        // $k = array_filter($barangmasuk, function ($var) use ($slug) {
        //     return ($var['slug'] == $slug);
        // });
        // dd(session()->get("barangmasuk.$nomor"));

        session()->forget("barangmasuk.$nomor");
        // reset image array
        // Session()->pull('barangmasuk');
        // $final_session = array_values($final_session);

        return redirect()->back();
    }

    public function hapussessiontambahsemua(Request $request)
    {
        session()->forget("barangmasuk");
        return redirect()->back();
    }

    public function tambahbarang(Request $request)
    {
        // dd($request);
        $validate = $request->validate(['jenissumber' => 'required', 'slugsumber' => 'required']);

        if ($validate) {
            $ps = [];
            $totaltagihan1 = null;
            $totaltagihan2 = null;
            $jumlah1 = null;
            $jumlah2 = null;

            // Cek dulu harga produksi/pemasoknya
            for ($i = 0; $i < count($request->produk_stok_slug); $i++) {
                if ($request->stok[$i] != 0) {
                    if (VariasiProdukOption::where('produk_stok_slug', $request->produk_stok_slug[$i])->first() == null) {
                        $s = NonVariasiProduk::where('produk_stok_slug', $request->produk_stok_slug[$i])->first();
                        if (ManajemenHarga::where('slugmain', $request->slugsumber)->where('produk_slug', $s->Produk->slug)->first() == null) {
                            return redirect()->back()->with('danger', 'Harga Produksi/Pemasok pada produk ini belum ada');
                        }
                    } else {
                        $s = VariasiProdukOption::where('produk_stok_slug', $request->produk_stok_slug[$i])->first();

                        if (ManajemenHarga::where('slugmain', $request->slugsumber)->where('produk_slug', $s->VariasiProduk->produk_slug)->first() == null) {
                            return redirect()->back()->with('danger', 'Harga Produksi/Pemasok pada produk ini belum ada');
                        }
                    }
                }
            }

            for ($i = 0; $i < count($request->produk_stok_slug); $i++) {
                if ($request->stok[$i] != 0) {

                    if (VariasiProdukOption::where('produk_stok_slug', $request->produk_stok_slug[$i])->first() == null) {
                        $produkStoknya = ProdukStok::where('stokslug', $request->produk_stok_slug[$i])->first();
                        $s = NonVariasiProduk::where('produk_stok_slug', $request->produk_stok_slug[$i])->first();


                        $ps[] = ['produk_slug' => $s->Produk->slug, 'jumlah' => $request->stok[$i], 'slugsumber' => $request->slugsumber, 'hargapokok' => $produkStoknya->hargapokok];
                    } else {
                        $produkStoknya = ProdukStok::where('stokslug', $request->produk_stok_slug[$i])->first();


                        $s = VariasiProdukOption::where('produk_stok_slug', $request->produk_stok_slug[$i])->first();
                        $ps[] =  ['produk_slug' => $s->VariasiProduk->Produk->slug, 'jumlah' => $request->stok[$i], 'slugsumber' => $request->slugsumber, 'hargapokok' => $produkStoknya->hargapokok];
                    }

                    $x = ProdukStok::where('stokslug', $request->produk_stok_slug[$i])->first();
                    $newstok = $x->stok +  $request->stok[$i];
                    ProdukStok::where('stokslug',  $request->produk_stok_slug[$i])->update(['stok' => $newstok]);
                    BarangMasuk::create(['produk_stok_slug' =>  $request->produk_stok_slug[$i], 'slugsumber' => $request->slugsumber, 'jumlah' => $request->stok[$i]]);
                }
            }
            foreach ($ps as $ps) {
                if (TagihanBarangMasuk::where('slugsumber', $ps['slugsumber'])->first() == null) {
                    $hrgjht = ManajemenHarga::where('slugmain', $ps['slugsumber'])->where('produk_slug', $ps['produk_slug'])->first();
                    $total_tagihan = $ps['jumlah'] * $hrgjht->harga;

                    $totaltagihan1 += $total_tagihan;
                    $jumlah1 += $ps['jumlah'];
                    TagihanBarangMasuk::create([
                        'slugsumber' => $ps['slugsumber'],
                        'total_tagihan' => $total_tagihan
                    ]);
                } else {
                    $hrgjht = ManajemenHarga::where('slugmain', $ps['slugsumber'])->where('produk_slug', $ps['produk_slug'])->first();
                    $total_tagihan = $ps['jumlah'] * $hrgjht->harga;

                    $psx = TagihanBarangMasuk::where('slugsumber', $ps['slugsumber'])->first();
                    $total_tagihanbaru = $total_tagihan + $psx->total_tagihan;
                    $totaltagihan2 += $total_tagihan;
                    $jumlah2 += $ps['jumlah'];
                    TagihanBarangMasuk::where('slugsumber', $ps['slugsumber'])->update([
                        'slugsumber' => $ps['slugsumber'],
                        'total_tagihan' => $total_tagihanbaru
                    ]);
                }
            }
            $totalsemuatagihan = $totaltagihan1 + $totaltagihan2;
            $totalsemuajumlah = $jumlah1 + $jumlah2;
            $transaksi['keterangan'] = 'Barang masuk dari ' . $request->slugsumber . ' sebanyak ' . $totalsemuajumlah .  ' pcs';
            $transaksi['slugmain'] = $request->slugsumber;
            $transaksi['jumlah_tagihan'] = $totalsemuatagihan;
            $transaksi['sisa'] = $totalsemuatagihan;
            if (Transaksi::where('slugmain', $transaksi['slugmain'])->latest()->first() == TRUE) {
                $adatransaksiga = Transaksi::where('slugmain', $transaksi['slugmain'])->latest()->first();
                $transaksi['sisa'] = $adatransaksiga->sisa + $totalsemuatagihan;
            }
            // dd($transaksi);
            Transaksi::create($transaksi);
            session()->forget("barangmasuk");
            return redirect()->back()->with('success', 'Berhasil Stok update');
        }
        return redirect()->back();
    }

    public function checkJenisSumber(Request $request)
    {
        $p = null;

        $y = SumberBarang::where('jenissumber', $request->jenissumber)->get();


        return response()->json(['sumber' => $y]);
    }


    public function storepenjualan(Request $request)
    {
        // dd($request);

        $validate = $request->validate(['kategoripenjualan' => 'required', 'slugkategoripenjualan' => 'required']);

        if ($validate) {
            $totalharga = null;
            $totalpcs = null;
            $namaproduknya = null;
            $variasiproduknya = null;
            for ($i = 0; $i < count($request->produk_stok_slug); $i++) {
                if ($request->stok[$i] != 0) {
                    $x = ProdukStok::where('stokslug', $request->produk_stok_slug[$i])->first();
                    if (HargaJual::where('slugkategoripenjualan', $request->slugkategoripenjualan)->where('produk_stok_slug', $request->produk_stok_slug[$i])->first() == false) {
                        if ($x->VariasiProdukOption == null) {
                            $namaproduknya = $x->nonVariasiProduk->Produk->namaproduk;
                            return redirect()->back()->with('danger', "Harga jual untuk $namaproduknya  belum diatur");
                            break;
                        } else {
                            $namaproduknya = $x->VariasiProdukOption->VariasiProduk->Produk->namaproduk;
                            $variasiproduknya = $x->VariasiProdukOption->namavariasioption;
                            return redirect()->back()->with('danger', "Harga jual untuk $namaproduknya : $variasiproduknya belum diatur");
                            break;
                        }
                    }
                }
            }


            for ($i = 0; $i < count($request->produk_stok_slug); $i++) {
                if ($request->stok[$i] != 0) {
                    $x = ProdukStok::where('stokslug', $request->produk_stok_slug[$i])->first();

                    $hrgjual = HargaJual::where('slugkategoripenjualan', $request->slugkategoripenjualan)->where('produk_stok_slug', $request->produk_stok_slug[$i])->first();

                    $totalpcs += $request->stok[$i];
                    $newstok = $x->stok - $request->stok[$i];
                    ProdukStok::where('stokslug',  $request->produk_stok_slug[$i])->update(['stok' => $newstok]);
                    Penjualan::create(['produk_stok_slug' =>  $request->produk_stok_slug[$i], 'slugkategoripenjualan' => $request->slugkategoripenjualan, 'jumlah' => $request->stok[$i]]);
                    $totalharga += $hrgjual->hargajual * $request->stok[$i];
                }
            }
            $kategoripnjl = KategoriPenjualan::where('slugkategoripenjualan', $request->slugkategoripenjualan)->first();
            if ($kategoripnjl->kategori == "Reseller") {
                if (Transaksi::where('slugmain', $request->slugkategoripenjualan)->latest()->first() == true) {
                    $lasttransks = Transaksi::where('slugmain', $request->slugkategoripenjualan)->latest()->first();
                    $newsisa = $lasttransks->sisa + $totalharga;
                    $keterangan = 'Penjualan pada ' . $kategoripnjl->kategori . ' ' .  $kategoripnjl->namakategoripenjualan . ' sebanyak ' .  $totalpcs . ' pcs';
                    Transaksi::create(['slugmain' => $request->slugkategoripenjualan, 'keterangan' => $keterangan, 'jumlah_bayar' => $totalharga, 'sisa' => $newsisa]);
                    if (TagihanBarangKeluar::where('slugmain', $request->slugkategoripenjualan)->latest()->first() == true) {
                        TagihanBarangKeluar::where('slugmain', $request->slugkategoripenjualan)->update(['total_tagihan' => $newsisa]);
                    } else {
                        TagihanBarangKeluar::create(['slugmain' => $request->slugkategoripenjualan, 'total_tagihan' => $newsisa]);
                    }
                } else {
                    $keterangan = 'Penjualan pada ' . $kategoripnjl->kategori . ' ' .  $kategoripnjl->namakategoripenjualan . ' sebanyak ' .  $totalpcs . ' pcs';
                    Transaksi::create(['slugmain' => $request->slugkategoripenjualan, 'keterangan' => $keterangan, 'jumlah_bayar' => $totalharga, 'sisa' => $totalharga]);
                    if (TagihanBarangKeluar::where('slugmain', $request->slugkategoripenjualan)->latest()->first() == true) {
                        TagihanBarangKeluar::where('slugmain', $request->slugkategoripenjualan)->update(['total_tagihan' => $totalharga]);
                    } else {
                        TagihanBarangKeluar::create(['slugmain' => $request->slugkategoripenjualan, 'total_tagihan' => $totalharga]);
                    }
                }
            } else {
                $keterangan = 'Penjualan pada ' . $kategoripnjl->kategori . ' ' .  $kategoripnjl->namakategoripenjualan . ' sebanyak ' .  $totalpcs . ' pcs';
                Transaksi::create(['slugmain' => $request->slugkategoripenjualan, 'keterangan' => $keterangan, 'sisa' => $totalharga]);
            }
            // dd($totalharga);
            session()->forget("barangmasuk");
            return redirect()->back()->with('success', 'Berhasil Stok update');
        }
        return redirect()->back();
    }

    public function riwayattransaksi()
    {

        return view('dashboard.riwayattransaksi', ['transaksi' => Transaksi::latest()->get()]);
    }
}
