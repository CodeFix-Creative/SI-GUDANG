<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPengeluaranSales;
use App\Models\DetailPengeluaranSales;
use App\Models\Sales;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TransaksiPengeluaranSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::where('status' , 'Aktif')->get();
        return view('admin.pengeluaranSales.index' , compact('sales'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransaksiPengeluaranSales  $transaksiPengeluaranSales
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiPengeluaranSales $transaksiPengeluaranSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiPengeluaranSales  $transaksiPengeluaranSales
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiPengeluaranSales $transaksiPengeluaranSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransaksiPengeluaranSales  $transaksiPengeluaranSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransaksiPengeluaranSales $transaksiPengeluaranSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiPengeluaranSales  $transaksiPengeluaranSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiPengeluaranSales $transaksiPengeluaranSales)
    {
        //
    }



    public function inCart($id) {
        $carts = session()->get('PengeluaranSales');

        if ($carts->count() > 0) {
            foreach ($carts->all() as $data) {
                if ($data['id'] == $id) {
                    return true;
                }
            }
        }

        return false;
    }




    public function addCartPengeluaran(Request $request)
    {
        // return json_encode($request->all());

        $totalOrder = 0;
        $idTotal = 1;

        // return $request->all();

        if(Session::has('PengeluaranSales')) {
            $carts = Session::get('PengeluaranSales')->all();

            $carts[] = [
                'id' => $request->id,
                'nama_pengeluaran' => $request->nama_pengeluaran,
                'harga'=> $request->harga,
                'jumlah' => $request->jumlah,
                'total'=> $request->harga * $request->jumlah,
            ];
            // $carts['0']['totalCart'] = $carts['0']['totalCart'] + $request['qty'];
            //price
            // $price = $request['qty'] * $request->price;
            $data = $carts;
            Session::put('PengeluaranSales', collect($data));

        } else {
            $data = collect([
                [
                'id' => $request->id,
                'nama_pengeluaran' => $request->nama_pengeluaran,
                'harga'=> $request->harga,
                'jumlah' => $request->jumlah,
                'total'=> $request->harga * $request->jumlah,
                ]
            ]);
            Session::put('PengeluaranSales', $data);
        }

        $idTotal = rand(1,30);
        
        foreach ($data as $dt) {
            $totalOrder += $dt['total'];
            if ($dt['id'] == $idTotal) {
                $idTotal = rand(1,30);
            }
        }


        return response()->json([
            'status' => 'success',
            'data' => $data,
            'total' => $totalOrder,
            'idtotal' => $idTotal,
        ], 200);
    }


    public function removeCartPengeluaran(Request $request)
    {
        // return json_encode($request->all());
        if($this->inCart($request->id)){
            $carts = Session::get('PengeluaranSales')->all();

            $totalOrder = 0;

            $index = 0;
            // return $carts;
            foreach ($carts as $cart) {
                if ($cart['id'] == $request->id) {
                    // $index = $cart['id'];
                    unset($carts[$index]);
                    // $cart['total'] = $cart['price'] * $cart['qty'];
                }
                $index++;
            }

            $data = Session::put('PengeluaranSales', collect($carts));

            
            $dataTotal = Session::get('PengeluaranSales')->all();

            foreach($dataTotal as $dt){
                $totalOrder += $dt['total'];
            }

            if($totalOrder == 'Undefined'){
                $totalOrder = 0;
            }

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'total' => $totalOrder,
            ], 200);
        }
    }




    public function checkoutPengeluaran(Request $request)
    {

        if(!Session::has('PengeluaranSales')){
            return redirect()->route('transaksi-pengeluaran.index')
                ->with('toast_error', 'Masukan Pengeluaran Terlebih Dahulu!')
                ->withInput();
        }

        $carts = Session::get('PengeluaranSales')->all();

        $index = 0;

        $pengeluaran = TransaksiPengeluaranSales::create([
            'total_transaksi' => $request->total_order,
            'id_sales' => $request->id_sales,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'id_user' => auth()->user()->id,
        ]);

        foreach ($carts as $cart) {
            $detailPengeluaran = DetailPengeluaranSales::create([
                'id_transaksi' => $pengeluaran->id,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'nama_pengeluaran' => $cart['nama_pengeluaran'],
                'harga' => $cart['harga'],
                'jumlah' => $cart['jumlah'],
                'total_harga' => $cart['total'],
            ]);

        }

        Session::forget('PengeluaranSales');

        return redirect()->route('transaksi-pengeluaran-sales.index')->with('toast_success', 'pengeluaran berhasil ditambahkan!');
    }


    public function Report()
    {
        $datas = TransaksiPengeluaranSales::orderBy('created_at' , 'ASC')->get();

        return view('admin.reportPengeluaranSales.index' , compact('datas'));
    }

    public function ReportDetail($id)
    {
        $parent = TransaksiPengeluaranSales::find($id);
        $datas = DetailPengeluaranSales::where('id_transaksi' , $id)->get();

        return view('admin.reportPengeluaranSales.detail' , compact('datas' , 'parent'));
    }
}
