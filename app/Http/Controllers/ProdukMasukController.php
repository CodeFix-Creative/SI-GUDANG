<?php

namespace App\Http\Controllers;

use App\Models\ProdukMasuk;
use App\Models\Produk;
use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = ProdukMasuk::orderBy('created_at' , 'ASC')->get();

        return view('admin.produkMasuk.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produk = Produk::orderBy('nama_produk' , 'ASC')->get();
        $suplier = Suplier::orderBy('nama_suplier' , 'ASC')->get();

        return view('admin.produkMasuk.create', compact('produk' , 'suplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = ProdukMasuk::create([
            'id_produk' => $request->id_produk,
            'id_suplier' => $request->id_suplier,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'id_user' => Auth::user()->id,
            'status' => 'Pending',
         ]);

         return redirect()->route('produk-masuk.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdukMasuk $produkMasuk)
    {
        // dd($produkMasuk);
        $data = $produkMasuk;
        $produk = Produk::orderBy('nama_produk' , 'ASC')->get();
        $suplier = Suplier::orderBy('nama_suplier' , 'ASC')->get();

        return view('admin.produkMasuk.edit', compact('produk' , 'suplier' , 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdukMasuk $produkMasuk)
    {
        // dd($request->all());
        $produkMasuk->id_produk = $request->id_produk; 
        $produkMasuk->id_suplier = $request->id_suplier; 
        $produkMasuk->jumlah = $request->jumlah; 
        $produkMasuk->tanggal_masuk = $request->tanggal_masuk;  
        $produkMasuk->save();

        return redirect()->route('produk-masuk.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukMasuk $produkMasuk)
    {
        //
    }


    public function diterima(ProdukMasuk $produkMasuk)
    {
        $produk = Produk::where('id' , $produkMasuk->id_produk)->first();
        $produk->stock = $produk->stock + $produkMasuk->jumlah;
        $produk->save();

        $produkMasuk->status = 'Diterima';
        $produkMasuk->save();
        return redirect()->route('produk-masuk.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    public function ditolak(ProdukMasuk $produkMasuk)
    {

        $produkMasuk->status = 'Ditolak';
        $produkMasuk->save();
        return redirect()->route('produk-masuk.index')->with('toast_success' , 'Data berhasil di ubah!');
    }
}
