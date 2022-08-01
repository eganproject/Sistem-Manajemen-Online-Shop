<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\TagihanBarangMasuk;
use App\Models\TagihanBarangKeluar;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        $tagihanbarangmasuk = TagihanBarangMasuk::all();
        $tagihanbarangkeluar = TagihanBarangKeluar::all();
        $penjualan = Penjualan::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();
        return view('dashboard.index', ['penjualan' => $penjualan, 'tagihanbarangmasuk' => $tagihanbarangmasuk, 'tagihanbarangkeluar' => $tagihanbarangkeluar]);
    }
}
