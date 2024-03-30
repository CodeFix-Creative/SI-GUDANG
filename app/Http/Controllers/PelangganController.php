<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Sales;
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
        $sales = Sales::all();

        return view('admin.pelanggan.create', compact('sales'));
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
        $pelanggan = Pelanggan::withTrashed()->count();
        $current = $pelanggan + 1;
        // dd($current);

        $validated = $request->validate([
            'email' => 'required|unique:users',
            'nama' => 'required',
            'nomor_telephone' => 'required',
         ]);

         $data = Pelanggan::create([
            'kode_pelanggan' => 'P' . $current,
            'nama_pelanggan' => $request->nama,
            'toko' => $request->toko,
            'email' => $request->email,
            'nomor_telephone' => $request->nomor_telephone,
            'alamat' => $request->alamat,
            'id_sales' => $request->id_sales,
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
        $sales = Sales::all();

        return view('admin.pelanggan.edit' , compact('data' , 'sales'));
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
        $pelanggan->toko = $request->toko; 
        $pelanggan->email = $request->email; 
        $pelanggan->nomor_telephone = $request->nomor_telephone; 
        $pelanggan->alamat = $request->alamat; 
        $pelanggan->id_sales = $request->id_sales; 
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
        // dd($pelanggan);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }
}
