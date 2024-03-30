<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Sales::orderBy('created_at' , 'ASC')->get();

        return view('admin.sales.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sales.create');
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
            'email' => 'required|unique:users',
            'nama' => 'required',
         ]);

         $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => bcrypt('123'),
         ]);
        //  dd($user);
         $sales = Sales::create([
            'id_user' => $user->id,
            'nomor_telephone' => $request->nomor_telephone,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'status' => $request->status,
         ]);

         return redirect()->route('sales.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sale)
    {
        $data = $sale;

        return view('admin.sales.edit' , compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales $sale)
    {
        $user = User::where('id' , $request->id_user)->first();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->save();

        $sale->nomor_telephone = $request->nomor_telephone;
        $sale->email = $request->email;
        $sale->alamat = $request->alamat;
        $sale->status = $request->status;
        $sale->save();

        return redirect()->route('sales.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sale)
    {
        // dd($sale);
        $sale->delete();

        return redirect()->route('sales.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }
}
