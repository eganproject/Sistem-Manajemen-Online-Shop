<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employe;
use App\Models\DashboardMenu;
use App\Models\DashboardRole;
use Illuminate\Database\Seeder;
use App\Models\DashboardRoleAccess;
use App\Models\DashboardSubmenu;
use App\Models\kategori_produk;
use App\Models\VariasiProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Ega Nugraha',
            'username' => 'eganugrahaid',
            'email' => 'eganugrahaid@gmail.com',
            'dashboard_role_id' => 1,
            'password' => bcrypt('1234')
        ]);

        DashboardMenu::create([
            'nama' => 'Dashboard',
            'slugmenu' => 'dashboard',
            'url' => '/dashboard',
            'icon' => 'home'
        ]);
        DashboardMenu::create([
            'nama' => 'Administrator',
            'slugmenu' => 'administrator',
            'url' => '-',
            'is_submenu' => 1,
            'icon' => 'lock'
        ]);
        DashboardMenu::create([
            'nama' => 'Tagihan',
            'slugmenu' => 'tagihan',
            'url' => '-',
            'is_submenu' => 1,
            'icon' => 'book'
        ]);
        DashboardMenu::create([
            'nama' => 'Master Data',
            'slugmenu' => 'master-data',
            'url' => '/dashboard/masterdata',
            'icon' => 'database'
        ]);
        DashboardMenu::create([
            'nama' => 'Produk',
            'slugmenu' => 'produk',
            'url' => '/dashboard/produk',
            'icon' => 'grid'
        ]);
        DashboardMenu::create([
            'nama' => 'Barang Masuk',
            'slugmenu' => 'barang-masuk',
            'url' => '/dashboard/barangmasuk',
            'icon' => 'package'
        ]);

        DashboardMenu::create([
            'nama' => 'Penjualan',
            'slugmenu' => 'penjualan',
            'url' => '/dashboard/penjualan',
            'icon' => 'shopping-bag'
        ]);
        DashboardMenu::create([
            'nama' => 'Coba React',
            'slugmenu' => 'coba-react',
            'url' => '/dashboard/cobareact',
            'icon' => 'circle'
        ]);
        DashboardMenu::create([
            'nama' => 'Database',
            'slugmenu' => 'database',
            'url' => '/dashboard/database',
            'icon' => 'file-text'
        ]);
        DashboardMenu::create([
            'nama' => 'Riwayat Transaksi',
            'slugmenu' => 'riwayat-transaksi',
            'url' => '/dashboard/riwayattransaksi',
            'icon' => 'chrome'
        ]);

        DashboardSubmenu::create([
            'namasubmenu' => 'Menu',
            'slugmenu' => 'administrator',
            'urlsubmenu' => '/dashboard/administrator/menu'
        ]);
        DashboardSubmenu::create([
            'namasubmenu' => 'Role',
            'slugmenu' => 'administrator',
            'urlsubmenu' => '/dashboard/administrator/role'
        ]);
        DashboardSubmenu::create([
            'namasubmenu' => 'User',
            'slugmenu' => 'administrator',
            'urlsubmenu' => '/dashboard/administrator/adduser'
        ]);
        DashboardSubmenu::create([
            'namasubmenu' => 'Tagihan Barang Masuk',
            'slugmenu' => 'tagihan',
            'urlsubmenu' => '/dashboard/tagihan/barangmasuk'
        ]);
        DashboardSubmenu::create([
            'namasubmenu' => 'Tagihan Barang Keluar',
            'slugmenu' => 'tagihan',
            'urlsubmenu' => '/dashboard/tagihan/barangkeluar'
        ]);


        kategori_produk::create([
            'namakategori' => 'Daster'
        ]);
        kategori_produk::create([
            'namakategori' => 'Gamis'
        ]);

        DashboardRole::create([
            'role' => 'Superadmin'
        ]);
        DashboardRole::create([
            'role' => 'Supervisor'
        ]);

        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 1]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 2]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 3]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 4]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 5]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 6]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 7]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 8]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 9]);
        DashboardRoleAccess::create(['dashboard_role_id' => 1, 'menu_id' => 10]);
        DashboardRoleAccess::create(['dashboard_role_id' => 2, 'menu_id' => 1]);
    }
}
