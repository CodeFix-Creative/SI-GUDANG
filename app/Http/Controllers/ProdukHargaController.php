<?php

namespace App\Http\Controllers;

use App\Models\ProdukHarga;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class ProdukHargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = ProdukHarga::orderBy('created_at' , 'ASC')->get();

        return view('admin.produkHarga.index' , compact('datas'));
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

        return view('admin.produkharga.create', compact('produk' , 'pelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = ProdukHarga::create([
            'id_produk' => $request->id_produk,
            'id_pelanggan' => $request->id_pelanggan,
            'harga' => $request->harga,
         ]);

         return redirect()->route('produk-harga.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProdukHarga  $produkHarga
     * @return \Illuminate\Http\Response
     */
    public function show(ProdukHarga $produkHarga)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProdukHarga  $produkHarga
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdukHarga $produkHarga)
    {
        $produk = Produk::orderBy('nama_produk' , 'ASC')->get();
        $pelanggan = Pelanggan::orderBy('nama_pelanggan' , 'ASC')->get();
        $data = $produkHarga;

        return view('admin.produkharga.edit', compact('produk' , 'pelanggan' , 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProdukHarga  $produkHarga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdukHarga $produkHarga)
    {
        $produkHarga->id_produk = $request->id_produk; 
        $produkHarga->id_pelanggan = $request->id_pelanggan; 
        $produkHarga->harga = $request->harga; 
        $produkHarga->save();

        return redirect()->route('produk-harga.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdukHarga  $produkHarga
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukHarga $produkHarga)
    {
        // dd($produkHarga);
        $produkHarga->delete();

        return redirect()->route('produk.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }
}
