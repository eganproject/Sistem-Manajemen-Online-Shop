<?php

namespace App\Http\Controllers;

use App\Models\DashboardMenu;
use App\Models\DashboardSubmenu;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard.menu.index', ['menu' => DashboardMenu::oldest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        if ($request->is_submenu) {
            $menu['nama'] = $request->nama;
            $menu['slugmenu'] = $request->slugmenu;
            $menu['url'] = "-";
            $menu['is_submenu'] = $request->is_submenu;
            $menu['icon'] = $request->icon;
            foreach (array_combine($request->namasubmenu, $request->urlsubmenu) as $namasubmenu => $urlsubmenu) {
                $submenu = [
                    'namasubmenu' => $namasubmenu,
                    'urlsubmenu' => $urlsubmenu,
                    'slugmenu' => $request->slugmenu
                ];
                DashboardSubmenu::create($submenu);
            }
            DashboardMenu::create($menu);

            return redirect('/dashboard/administrator/menu')->with('success', 'Data ditambahkan');
        } else {

            $validatedData = $request->validate(['nama' => 'required', 'slugmenu' => 'required', 'url' => 'required', 'icon' => 'required']);

            DashboardMenu::create($validatedData);

            return redirect('/dashboard/administrator/menu')->with('success', 'Data ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DashboardMenu  $dashboardMenu
     * @return \Illuminate\Http\Response
     */
    public function show(DashboardMenu $dashboardMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DashboardMenu  $dashboardMenu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dashboardMenu = DashboardMenu::findOrfail($id);
        return view('dashboard.menu.edit', ['menu' => $dashboardMenu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DashboardMenu  $dashboardMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request);
        if ($request->is_submenu == 1) {
            $menu['nama'] = $request->nama;
            $menu['url'] = "-";
            $menu['icon'] = $request->icon;
            for ($i = 0; $i < count($request->id_submenu); $i++) {
                $submenu = [
                    'namasubmenu' => $request->namasubmenu[$i],
                    'urlsubmenu' => $request->urlsubmenu[$i]
                ];
                DashboardSubmenu::where('id', $request->id_submenu[$i])->update($submenu);
            }
            DashboardMenu::where('id', $request->id)->update($menu);
            // dd($request);
            return redirect('/dashboard/administrator/menu')->with('success', 'Data diedit');
        } else {
            $validatedData = ['nama' => $request->nama, 'url' => $request->url, 'icon' => $request->icon];
            // dd($request);
            DashboardMenu::where('id', $request->id)->update($validatedData);

            return redirect('/dashboard/administrator/menu')->with('success', 'Data diedit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DashboardMenu  $dashboardMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dashboardMenu = DashboardMenu::findOrfail($id);
        $dashboardMenu->delete();
        return redirect('/dashboard/administrator/menu')->with('success', 'Data dihapus');
    }


    public function checkSlugMenu(Request $request)
    {
        $slugmenu = SlugService::createSlug(DashboardMenu::class, 'slugmenu', $request->nama);

        return response()->json(['slugmenu' => $slugmenu]);
    }
}
