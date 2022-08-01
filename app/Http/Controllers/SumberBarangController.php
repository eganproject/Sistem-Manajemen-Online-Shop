<?php

namespace App\Http\Controllers;

use App\Models\SumberBarang;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class SumberBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validate = $request->validate(['jenissumber' => 'required', 'namasumber' => 'required|unique:sumber_barangs', 'slugsumber' => 'required|unique:sumber_barangs|unique:kategori_penjualans,slugkategoripenjualan']);

        if ($validate == true) {
            SumberBarang::create($validate);
            return redirect('/dashboard/masterdata')->with('success', 'Data Ditambah');
        } else {
            return redirect('/dashboard/masterdata')->with('notsuccess', 'Data Sudah Ada');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SumberBarang  $sumberBarang
     * @return \Illuminate\Http\Response
     */
    public function show(SumberBarang $sumberBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SumberBarang  $sumberBarang
     * @return \Illuminate\Http\Response
     */
    public function edit(SumberBarang $sumberBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SumberBarang  $sumberBarang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        dd($request);
        $update = [
            'jenissumber' => $request->jenissumber,
            'namasumber' => $request->namasumber
        ];
        SumberBarang::where('id', $request->id)->update($update);
        return redirect('/dashboard/masterdata')->with('success', 'Data Sumber Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SumberBarang  $sumberBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SumberBarang::destroy($id);
        return redirect('/dashboard/masterdata')->with('success', 'Data Sumber dihapus');
    }

    public function checkSlugSumber(Request $request)
    {
        $slug = SlugService::createSlug(SumberBarang::class, 'slugsumber', $request->namasumber);
        return response()->json(['slugsumber' => $slug]);
    }
}
