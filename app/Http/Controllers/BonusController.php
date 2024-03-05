<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Produk;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Bonus::orderBy('created_at' , 'ASC')->get();

        return view('admin.bonus.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produk = Produk::where('status' , 'Aktif')->orderBy('nama_produk' , 'ASC')->get();

        return view('admin.bonus.create', compact('produk'));
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
            'id_produk' => 'required',
            'aturan' => 'required',
            'keterangan' => 'required',
            'jenis_bonus' => 'required',
            'satuan' => 'required',
            'status' => 'required',
         ]);

         $data = Bonus::create([
            'id_produk' => $request->id_produk,
            'aturan' => $request->aturan,
            'keterangan' => $request->keterangan,
            'jenis_bonus' => $request->jenis_bonus,
            'satuan' => $request->satuan,
            'status' => $request->status,
         ]);

         return redirect()->route('bonus.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function show(Bonus $bonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bonus $bonu)
    {
        // dd($bonu);
        $data = $bonu;

        $produk = Produk::where('status' , 'Aktif')->orderBy('nama_produk' , 'ASC')->get();

        return view('admin.bonus.edit' , compact('data' , 'produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bonus $bonu)
    {
        // dd($request->all());
        $bonu->id_produk = $request->id_produk; 
        $bonu->aturan = $request->aturan; 
        $bonu->keterangan = $request->keterangan; 
        $bonu->jenis_bonus = $request->jenis_bonus; 
        $bonu->satuan = $request->satuan; 
        $bonu->status = $request->status; 
        $bonu->save();

        return redirect()->route('bonus.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bonus $bonus)
    {
        //
    }
}
