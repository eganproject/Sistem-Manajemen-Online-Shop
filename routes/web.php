<?php

use App\Http\Controllers\BarangMasukController;
use App\Models\DashboardMenu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\CobaReactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardMenuController;
use App\Http\Controllers\DashboardRoleController;
use App\Http\Controllers\DashboardAddUserController;
use App\Http\Controllers\DashboardMasterDataController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SumberBarangController;
use App\Http\Controllers\TagihanBarangKeluar;
use App\Http\Controllers\TagihanBarangMasukController;
use App\Models\SumberBarang;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/beranda', ['title' => 'Beranda']);
});

// ditambahkan name untuk mengkonfirmasi url arah middleware auth
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
// 
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/dashboard/administrator/menu/checkSlugMenu', [DashboardMenuController::class, 'checkSlugMenu'])->middleware('auth');
Route::resource('/dashboard/administrator/menu', DashboardMenuController::class)->middleware('auth');

Route::resource('/dashboard/administrator/role', DashboardRoleController::class)->middleware('auth');
Route::post('/dashboard/administrator/roleaccess', [DashboardRoleController::class, 'createaccess'])->middleware('auth');
Route::get('/dashboard/administrator/roleaccess/delete/{id}', [DashboardRoleController::class, 'deleteaccess'])->middleware('auth');

Route::resource('/dashboard/administrator/adduser', DashboardAddUserController::class)->middleware('auth');



Route::get('/dashboard/produk/checkSlug', [ProdukController::class, 'checkSlug'])->middleware('auth');
Route::get('/dashboard/produk/checkSlugVariasi', [ProdukController::class, 'checkSlugVariasi'])->middleware('auth');
Route::get('/dashboard/produk/create2', [ProdukController::class, 'create2'])->middleware('auth');
Route::post('/dashboard/produk/store2', [ProdukController::class, 'store2'])->middleware('auth');
Route::resource('/dashboard/produk', ProdukController::class)->middleware('auth');


Route::get('/dashboard/cobareact', [CobaReactController::class, 'index'])->middleware('auth');
Route::get('/dashboard/employe/list', [CobaReactController::class, 'getEmployeList'])->name('employe.list')->middleware('auth');
Route::post('/dashboard/individual/employe/detail', [CobaReactController::class, 'getEmployeDetail'])->name('employe.detail')->middleware('auth');
Route::post('/dashboard/employe/update', [CobaReactController::class, 'updateEmployeData'])->middleware('auth');
Route::delete('/dashboard/employe/delete/{employe}', [CobaReactController::class, 'destroyEmployeData']);
Route::post('/dashboard/employe/store', [CobaReactController::class, 'storeEmployeData'])->middleware('auth');

Route::get('dashboard/database', [DatabaseController::class, 'index'])->middleware('auth');
Route::get('dashboard/database/barangmasuk', [DatabaseController::class, 'barangmasuk'])->middleware('auth');
Route::get('/dashboard/database/penjualan', [DatabaseController::class, 'penjualan'])->middleware('auth');
Route::get('dashboard/database/tambahsessionbarang', [DatabaseController::class, 'tambahsessionbarang'])->middleware('auth');
Route::get('dashboard/database/hapussessionbarangmasuk/{id}', [DatabaseController::class, 'hapussessionbarangmasuk'])->middleware('auth');
Route::get('dashboard/database/hapussessiontambahsemua', [DatabaseController::class, 'hapussessiontambahsemua'])->middleware('auth');
Route::post('dashboard/database/tambahbarang', [DatabaseController::class, 'tambahbarang']);
Route::get('/dashboard/database/checkJenisSumber', [DatabaseController::class, 'checkJenisSumber'])->middleware('auth');

Route::get('/dashboard/masterdata/checkProduknya', [DashboardMasterDataController::class, 'checkProduknya'])->middleware('auth');
Route::get('/dashboard/masterdata/checkSlugKategoriPenjualan', [DashboardMasterDataController::class, 'checkSlugKategoriPenjualan'])->middleware('auth');
Route::get('/dashboard/masterdata/checkKategoriPenjualan', [DashboardMasterDataController::class, 'checkKategoriPenjualan'])->middleware('auth');
Route::post('/dashboard/database/storepenjualan', [DatabaseController::class, 'storepenjualan'])->middleware('auth');
Route::post('/dashboard/masterdata/storekategoripenjualan', [DashboardMasterDataController::class, 'storekategoripenjualan'])->middleware('auth');
Route::post('/dashboard/masterdata/updatekategoripenjualan/{id}', [DashboardMasterDataController::class, 'updatekategoripenjualan'])->middleware('auth');
Route::post('/dashboard/masterdata/deletekategoripenjualan/{id}', [DashboardMasterDataController::class, 'deletekategoripenjualan'])->middleware('auth');
Route::get('/dashboard/masterdata/tambahsessionbaranghargajual', [DashboardMasterDataController::class, 'tambahsessionbaranghargajual'])->middleware('auth');
Route::get('/dashboard/masterdata/hapussessionbaranghargajual/{id}', [DashboardMasterDataController::class, 'hapussessionbaranghargajual'])->middleware('auth');
Route::get('/dashboard/masterdata/hapussessionsemuabaranghargajual', [DashboardMasterDataController::class, 'hapussessionsemuabaranghargajual'])->middleware('auth');
Route::get('/dashboard/tambahhargajual', [DashboardMasterDataController::class, 'tambahhargajual'])->middleware('auth');

Route::resource('/dashboard/masterdata', DashboardMasterDataController::class)->middleware('auth');
Route::get('/dashboard/masterdata/sumberbarang/checkSlugSumber', [SumberBarangController::class, 'checkSlugSumber'])->middleware('auth');
Route::resource('/dashboard/masterdata/sumberbarang', SumberBarangController::class)->middleware('auth');

Route::get('/dashboard/barangmasuk/index', 'BarangMasukController@index')->middleware('auth');
Route::get('/dashboard/barangmasuk/showbarangmasuknamasumber/{id}', 'BarangMasukController@showbarangmasuknamasumber')->middleware('auth');
Route::get('/dashboard/barangmasuk/showbarangmasukproduk/{id}', 'BarangMasukController@showbarangmasukproduk')->middleware('auth');
Route::resource('/dashboard/barangmasuk', BarangMasukController::class)->middleware('auth');
Route::get('/dashboard/penjualan/index', 'PenjualanController@index')->middleware('auth');
Route::get('/dashboard/penjualan/showpenjualanproduk/{id}', 'PenjualanController@showpenjualanproduk')->middleware('auth');
Route::get('/dashboard/penjualan/showpenjualannamakategoripenjualan/{id}', 'PenjualanController@showpenjualannamakategoripenjualan')->middleware('auth');
Route::get('/dashboard/penjualan/showpenjualankategori/{id}', 'PenjualanController@showpenjualankategori')->middleware('auth');
Route::resource('/dashboard/penjualan', PenjualanController::class)->middleware('auth');

Route::post('/dashboard/tagihan/bayarbarangmasuk', [TagihanBarangMasukController::class, 'bayarbarangmasuk'])->middleware('auth');
Route::resource('/dashboard/tagihan/barangmasuk', TagihanBarangMasukController::class)->middleware('auth');
Route::resource('/dashboard/tagihan/barangkeluar', TagihanBarangKeluarController::class)->middleware('auth');

Route::get('/dashboard/riwayattransaksi', [DatabaseController::class, 'riwayattransaksi'])->middleware('auth');
Route::post('/dashboard/masterdata/storehargajahit', [DashboardMasterDataController::class, 'storehargajahit'])->middleware('auth');
Route::post('/dashboard/masterdata/deletehargajahit/{id}', [DashboardMasterDataController::class, 'deletehargajahit'])->middleware('auth');
Route::post('/dashboard/masterdata/edithargajahit', [DashboardMasterDataController::class, 'edithargajahit'])->middleware('auth');
Route::post('/dashboard/masterdata/storehargajual', [DashboardMasterDataController::class, 'storehargajual'])->middleware('auth');
Route::post('/dashboard/masterdata/edithargajual', [DashboardMasterDataController::class, 'edithargajual'])->middleware('auth');
