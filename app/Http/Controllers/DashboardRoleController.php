<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\DashboardMenu;
use App\Models\DashboardRole;
use App\Models\DashboardRoleAccess;
use Illuminate\Http\Request;

class DashboardRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard.role.index', ['role' => DashboardRole::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.role.create', ['role' => DashboardRole::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['role' => 'required']);

        DashboardRole::create($validatedData);

        return redirect('/dashboard/administrator/role')->with('success', 'Role ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DashboardRole  $dashboardRole
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $roleasli = DashboardRole::where('id', auth()->user()->dashboard_role_id)->first();

        $dmenu = DashboardMenu::all();
        $dashboardRole = DashboardRole::findOrfail($id);
        return view('dashboard.role.show', ['dmenu' => $dmenu, 'role' => $dashboardRole]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DashboardRole  $dashboardRole
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $dashboardRole = DashboardRole::findOrfail($id);
        // $acm = DB::select("select * from dashboard_role_accesses as a join dashboard_menus as b on a.menu_id = b.id where a.role_id = $id")->first();

        return view('dashboard.role.edit', ['role' => $dashboardRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DashboardRole  $dashboardRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate(['role' => 'required']);

        DashboardRole::where('id', $request->id)->update($validatedData);

        return redirect('/dashboard/administrator/role')->with('success', 'Role diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DashboardRole  $dashboardRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dashboardRole = DashboardRole::findOrfail($id);
        $dashboardRole->delete();
        return redirect('/dashboard/administrator/role')->with('success', 'Data dihapus');
    }
    public function createaccess(Request $request)
    {
        $create = ['dashboard_role_id' => $request->role_id, 'menu_id' => $request->menu_id];
        DashboardRoleAccess::create($create);
        return redirect("dashboard/administrator/role/$request->role_id")->with('success', 'data ditambahkan');
    }

    public function deleteaccess(Request $request)
    {
        $dashboardRole = DashboardRoleAccess::findOrfail($request->id);
        $dashboardRole->delete();
        return redirect('/dashboard/administrator/role')->with('success', 'Data dihapus');
    }
}
