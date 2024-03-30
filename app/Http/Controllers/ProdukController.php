<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Produk::orderBy('created_at' , 'ASC')->get();

        return view('admin.produk.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = KategoriProduk::where('status' , 'Aktif')->orderBy('nama_kategori' , 'ASC')->get();

        return view('admin.produk.create', compact('kategori'));
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
            'nama' => 'required',
            'id_kategori' => 'required',
            'stock' => 'required',
            'satuan' => 'required',
            // 'harga' => 'required',
         ]);

         $data = Produk::create([
            'nama_produk' => $request->nama,
            'id_kategori' => $request->id_kategori,
            'stock' => $request->stock,
            'satuan' => $request->satuan,
            // 'harga' => $request->harga,
            'status' => $request->status,
         ]);

         return redirect()->route('produk.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        $data = $produk;

        $kategori = KategoriProduk::where('status' , 'Aktif')->orderBy('nama_kategori' , 'ASC')->get();

        return view('admin.produk.edit' , compact('data' , 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        $produk->nama_produk = $request->nama; 
        $produk->id_kategori = $request->id_kategori; 
        // $produk->stock = $request->stock; 
        $produk->satuan = $request->satuan; 
        // $produk->harga = $request->harga; 
        $produk->status = $request->status; 
        $produk->save();

        return redirect()->route('produk.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }
}
