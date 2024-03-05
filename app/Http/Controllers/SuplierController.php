<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Suplier::orderBy('created_at' , 'ASC')->get();

        return view('admin.suplier.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.suplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:suplier',
            'nama' => 'required',
            'nomor_telephone' => 'required',
         ]);

         $data = Suplier::create([
            'nama_suplier' => $request->nama,
            'email' => $request->email,
            'nomor_telephone' => $request->nomor_telephone,
            'jenis' => $request->jenis,
            'status' => $request->status,
         ]);

         return redirect()->route('suplier.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\Response
     */
    public function show(Suplier $suplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Suplier $suplier)
    {
        $data = $suplier;

        return view('admin.suplier.edit' , compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suplier $suplier)
    {
        $suplier->nama_suplier = $request->nama; 
        $suplier->email = $request->email; 
        $suplier->nomor_telephone = $request->nomor_telephone; 
        $suplier->jenis = $request->jenis; 
        $suplier->status = $request->status; 
        $suplier->save();

        return redirect()->route('suplier.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suplier $suplier)
    {
        //
    }
}
