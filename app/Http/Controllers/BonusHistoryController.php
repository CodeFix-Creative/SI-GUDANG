<?php

namespace App\Http\Controllers;

use App\Models\BonusHistory;
use App\Models\Bonus;
use App\Models\Pelanggan;
use App\Models\Sales;
use App\Models\Produk;
use Illuminate\Http\Request;

class BonusHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = BonusHistory::orderBy('created_at' , 'ASC')->get();
        $bonus = Bonus::where('status' , 'Aktif')->orderBy('created_at' , 'ASC')->get();
        $pelanggan = Pelanggan::orderBy('nama_pelanggan' , 'ASC')->get();
        $sales = Sales::where('status' , 'Aktif')->get();

        return view('admin.bonus.history' , compact('datas' , 'bonus' , 'pelanggan' , 'sales'));
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
        // dd($request->all());

        $data = BonusHistory::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_bonus' => $request->id_bonus,
            'jumlah_bonus' => $request->jumlah_bonus,
            'total_bonus' => $request->jumlah_bonus,
            'tanggal_bonus' => $request->tanggal_bonus,
            'id_sales' => $request->id_sales,
            'status' => 'Aktif',
            'id_user' => auth()->user()->id,
        ]);

        $bonus = Bonus::find($request->id_bonus);
        $produk = Produk::find($bonus->id_produk);

        $produk->stock = $produk->stock - $request->jumlah_bonus;
        $produk->save();
        
        return redirect()->back()->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BonusHistory  $bonusHistory
     * @return \Illuminate\Http\Response
     */
    public function show(BonusHistory $bonusHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BonusHistory  $bonusHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(BonusHistory $bonusHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BonusHistory  $bonusHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonusHistory $bonusHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BonusHistory  $bonusHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonusHistory $bonusHistory)
    {
        //
    }
}
