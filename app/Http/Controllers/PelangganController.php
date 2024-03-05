<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Toko;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Pelanggan::orderBy('created_at' , 'ASC')->get();

        return view('admin.pelanggan.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $toko = Toko::all();

        return view('admin.pelanggan.create', compact('toko'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'email' => 'required|unique:users',
            'nama' => 'required',
            'nomor_telephone' => 'required',
         ]);

         $data = Pelanggan::create([
            'nama_pelanggan' => $request->nama,
            'id_toko' => $request->id_toko,
            'email' => $request->email,
            'nomor_telephone' => $request->nomor_telephone,
            'alamat' => $request->alamat,
         ]);

         return redirect()->route('pelanggan.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        $data = $pelanggan;
        $toko = Toko::all();

        return view('admin.pelanggan.edit' , compact('data' , 'toko'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $pelanggan->nama_pelanggan = $request->nama; 
        $pelanggan->id_toko = $request->id_toko; 
        $pelanggan->email = $request->email; 
        $pelanggan->nomor_telephone = $request->nomor_telephone; 
        $pelanggan->alamat = $request->alamat; 
        $pelanggan->save();

        return redirect()->route('pelanggan.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        //
    }
}
