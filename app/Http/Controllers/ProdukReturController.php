<?php

namespace App\Http\Controllers;

use App\Models\ProdukRetur;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class ProdukReturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = ProdukRetur::orderBy('created_at' , 'ASC')->get();

        return view('admin.produkRetur.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produk = Produk::orderBy('nama_produk' , 'ASC')->get();
        $pelanggan = Pelanggan::orderBy('nama_pelanggan' , 'ASC')->get();

        return view('admin.produkRetur.create', compact('produk' , 'pelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = ProdukRetur::create([
          'id_produk' => $request->id_produk,
          'id_pelanggan' => $request->id_pelanggan,
          'jumlah' => $request->jumlah,
          // 'tanggal_masuk' => $request->tanggal_masuk,
          // 'id_user' => Auth::user()->id,
          'status' => 'Pending',
        ]);

        return redirect()->route('produk-retur.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProdukRetur  $produkRetur
     * @return \Illuminate\Http\Response
     */
    public function show(ProdukRetur $produkRetur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProdukRetur  $produkRetur
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdukRetur $produkRetur)
    {
        $data = $produkRetur;
        $produk = Produk::orderBy('nama_produk' , 'ASC')->get();
        $pelanggan = Pelanggan::orderBy('nama_suplier' , 'ASC')->get();

        return view('admin.produkRetur.edit', compact('produk' , 'pelanggan' , 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProdukRetur  $produkRetur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdukRetur $produkRetur)
    {
        $produkRetur->id_produk = $request->id_produk; 
        $produkRetur->id_pelanggan = $request->id_pelanggan; 
        $produkRetur->jumlah = $request->jumlah; 
        $produkRetur->save();

        return redirect()->route('produk-retur.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdukRetur  $produkRetur
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukRetur $produkRetur)
    {
        //
    }

    public function diterima(ProdukRetur $produkRetur)
    {
        $produk = Produk::where('id' , $produkRetur->id_produk)->first();
        $produk->stock = $produk->stock + $produkRetur->jumlah;
        $produk->save();

        $produkRetur->status = 'Diterima';
        $produkRetur->save();
        return redirect()->route('produk-retur.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    public function ditolak(ProdukRetur $produkRetur)
    {

        $produkRetur->status = 'Ditolak';
        $produkRetur->save();
        return redirect()->route('produk-retur.index')->with('toast_success' , 'Data berhasil di ubah!');
    }
}
