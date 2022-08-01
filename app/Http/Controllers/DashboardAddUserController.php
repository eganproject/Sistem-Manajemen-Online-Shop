<?php

namespace App\Http\Controllers;

use App\Models\DashboardRole;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DashboardAddUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.adduser.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.adduser.create', ['role' => DashboardRole::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['nama' => 'required', 'username' => 'required|unique:users', 'email' => 'required|email:dns|unique:users', 'password' => 'required|min:4', 'dashboard_role_id' => 'required']);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/dashboard/administrator/adduser')->with('success', 'Pengguna ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $u = User::find($id);
        return view('dashboard.adduser.edit', ['usr' => $u, 'role' => DashboardRole::all()]);
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
        $user = User::where('id', $id)->first();

        $validatedData = $request->validate(['nama' => 'required', 'username' => 'required|min:3', 'email' => 'required|email:dns', 'dashboard_role_id' => 'required']);

        if ($request['username'] !== $user['username']) {
            $validatedData = $request->validate(['nama' => 'required', 'username' => 'required|min:3|unique:users']);
        }

        if ($request['email'] !== $user['email']) {
            $validatedData = $request->validate(['email' => 'required|email:dns|unique:users', 'dashboard_role_id' => 'required']);
        }

        User::where('id', $id)->update($validatedData);

        return redirect('/dashboard/administrator/adduser')->with('success', 'Pengguna diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usr = User::findOrfail($id);
        $usr->delete();
        return redirect('/dashboard/administrator/adduser')->with('success', 'Data dihapus');
    }
}
