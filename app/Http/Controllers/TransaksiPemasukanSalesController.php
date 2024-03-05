<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPemasukanSales;
use App\Models\DetailPemasukanSales;
use App\Models\Sales;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Credit;
use App\Models\PembayaranCredit;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class TransaksiPemasukanSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::orderBy('nama_produk' , 'ASC')->get();
        $pelanggan = Pelanggan::orderBy('nama_pelanggan' , 'ASC')->get();
        $sales = Sales::where('status' , 'Aktif')->get();

        return view('admin.pemasukanSales.index' , compact('produk' , 'pelanggan' , 'sales'));
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
     * @param  \App\Models\TransaksiPemasukanSales  $transaksiPemasukanSales
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiPemasukanSales $transaksiPemasukanSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiPemasukanSales  $transaksiPemasukanSales
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiPemasukanSales $transaksiPemasukanSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransaksiPemasukanSales  $transaksiPemasukanSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransaksiPemasukanSales $transaksiPemasukanSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiPemasukanSales  $transaksiPemasukanSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiPemasukanSales $transaksiPemasukanSales)
    {
        //
    }

    public function inCart($id) {
        $carts = session()->get('CartSales');

        if ($carts->count() > 0) {
            foreach ($carts->all() as $data) {
                if ($data['id'] == $id) {
                    return true;
                }
            }
        }

        return false;
    }



    public function addToCart(Request $request)
    {

        $totalOrder = 0;

        if(Session::has('CartSales')) {
            $carts = Session::get('CartSales')->all();

            if ($this->inCart($request->id)) {
                $index = 0;
                foreach ($carts as $cart) {
                    if ($cart['id'] == $request->id) {
                        $cart['jumlah'] += $request['jumlah'];
                        $cart['total'] = $cart['jumlah'] * $cart['harga'];
                        $carts[$index] = $cart;
                    }
                    $index++;
                }
                // $carts['0']['totalCart'] = $carts['0']['totalCart'] + $request['qty'];
                //price
                // $price = $request['qty'] * $request->price;
                
            } else {
                $carts[] = [
                    'id' => $request->id,
                    'nama_barang' => $request->nama_barang,
                    'jumlah' => $request->jumlah,
                    'harga'=> $request->harga,
                    'total'=> $request->harga * $request->jumlah,
                    'new' => true,
                ];
                // $carts['0']['totalCart'] = $carts['0']['totalCart'] + $request['qty'];
                //price
                // $price = $request['qty'] * $request->price;
            }
            $data = $carts;
            Session::put('CartSales', collect($data));

        } else {
            $data = collect([
            [
                'id' => $request->id,
                'nama_barang' => $request->nama_barang,
                'jumlah' => $request->jumlah,
                'harga'=> $request->harga,
                'total'=> $request->harga * $request->jumlah,
            ]
            ]);
            Session::put('CartSales', $data);
        }

        foreach ($data as $dt) {
            $totalOrder += $dt['total'];
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'total' => $totalOrder,
        ], 200);
    }




    public function removeCart(Request $request)
    {
        // return $request->all();
        if($this->inCart($request->id)){
            $carts = Session::get('CartSales')->all();

            $totalOrder = 0;

            $index = 0;
            foreach ($carts as $cart) {
                if ($cart['id'] == $request->id) {
                    unset($carts[$index]);
                    // $cart['total'] = $cart['price'] * $cart['qty'];
                }
                $index++;
            }

            $data = Session::put('CartSales', collect($carts));

            $dataTotal = Session::get('CartSales')->all();

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





    public function checkout(Request $request){
        
        $sales = Sales::find($request->id_sales);
        
        // Check Cart Isi
        if(!Session::has('CartSales')){
            return redirect()->route('transaksi-pemasukan.index')
                ->with('toast_error', 'Pilih Barang Terlebih Dahulu!')
                ->withInput();
        }

        $carts = Session::get('CartSales')->all();

        $index = 0;
        // dd($carts);

        // Check Ketersediaan Barang
        foreach ($carts as $cart) {
            $produk = Produk::find($cart['id']);
            
            if( $produk->stock < $cart['jumlah']  ){
                return redirect()->route('transaksi-pemasukan.index')
                    ->with('toast_error', 'Stock Barang Tidak Memenuhi Pesanan!')
                    ->withInput();
            }
        }

        // Metode Pembayaran
        if ($request->jenis_pembayaran == 'Cash') {
            // Save data to pemasukan table
            $pemasukan = TransaksiPemasukanSales::create([
                'total_transaksi' => $request->total_order,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_pelanggan' => $request->id_pelanggan,
                'id_user' => auth()->user()->id,
                'pembayaran' => 'Cash',
            ]);
        }

        if ($request->jenis_pembayaran == 'Transfer') {
            $pelanggan = Pelanggan::find($request->id_pelanggan);
            $dt = Carbon::now();
            $timeNow = $dt->toTimeString();
            

            if ($request->bukti != null) {
                $extension = $request->file('bukti')->extension();
                $nameFile = str_replace(' ', '-', $request->tanggal_transaksi);
                $nameToko = str_replace(' ', '-', $pelanggan->toko->nama_toko);
                $time = str_replace(':', '-', $timeNow);
                $bukti = $nameFile . '-' . $nameToko. '-' . $time . '.' . $extension;
                // dd($bukti);
                // Validasi file
                $validate = $request->validate([
                    'bukti' => 'required|file|mimes:jpg,bmp,png,jpeg'
                ]);
                      
                // Upload file
                $path = Storage::putFileAs('public/bukti', $request->file('bukti'), $bukti);
            }

            // Save data to pemasukan table
            $pemasukan = TransaksiPemasukanSales::create([
                'total_transaksi' => $request->total_order,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_pelanggan' => $request->id_pelanggan,
                'id_sales' => $request->id_sales,
                'id_user' => auth()->user()->id,
                'pembayaran' => 'Transfer',
                'bukti' => $bukti,
            ]);
        }

        if ($request->jenis_pembayaran == 'Credit') {
            
            if ($request->tenor == '15 Hari') {
                $tanggal_start = Carbon::createFromFormat('Y-m-d', $request->tanggal_start);

                $jatuh_tempo = $tanggal_start->addDay(15);

                // Save data to pemasukan table
                $credit = Credit::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                ]);

                
                $detailCredit = PembayaranCredit::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'id_credit' => $credit->id,
                    'id_user' => auth()->user()->id,
                    'total_bayar' => $request->total_order,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                ]);

                
                
            }

            if ($request->tenor == '30 Hari') {
                $tanggal_start = Carbon::createFromFormat('Y-m-d', $request->tanggal_start);

                $jatuh_tempo = $tanggal_start->addDay(30);

                // Save data to pemasukan table
                $credit = Credit::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                ]);

                
                $detailCredit = PembayaranCredit::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'id_credit' => $credit->id,
                    'id_user' => auth()->user()->id,
                    'total_bayar' => $request->total_order,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                ]);
            }

            if ($request->tenor == '3 Bulan') {
                $tanggal_start = Carbon::createFromFormat('Y-m-d', $request->tanggal_start);

                $jatuh_tempo = $tanggal_start->addDay(90);

                $bayar_bulanan = round($request->total_order / 3);

                $bayar_bulanan = number_format($bayar_bulanan, 0, ".", "");

                $jatuh_tempo_bulanan = $tanggal_start;
                // dd($bayar_bulanan);

                $credit = Credit::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                ]);

                for ($i=0; $i <3 ; $i++) { 
                    $jatuh_tempo_bulanan = $jatuh_tempo_bulanan->addDay(30);
                    $detailCredit = PembayaranCredit::create([
                        'id_pelanggan' => $request->id_pelanggan,
                        'id_credit' => $credit->id,
                        'id_user' => auth()->user()->id,
                        'total_bayar' => $bayar_bulanan,
                        'tanggal_jatuh_tempo' => $jatuh_tempo_bulanan,
                        'status' => 'Belum Lunas',
                    ]);
                }
            }

            if ($request->tenor == '6 Bulan') {
                $tanggal_start = Carbon::createFromFormat('Y-m-d', $request->tanggal_start);

                $jatuh_tempo = $tanggal_start->addDay(180);

                $bayar_bulanan = round($request->total_order / 6);

                $bayar_bulanan = number_format($bayar_bulanan, 0, ".", "");

                $jatuh_tempo_bulanan = $tanggal_start;
                // dd($bayar_bulanan);

                $credit = Credit::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                ]);

                for ($i=0; $i <6 ; $i++) { 
                    $jatuh_tempo_bulanan = $jatuh_tempo_bulanan->addDay(30);
                    $detailCredit = PembayaranCredit::create([
                        'id_pelanggan' => $request->id_pelanggan,
                        'id_credit' => $credit->id,
                        'id_user' => auth()->user()->id,
                        'total_bayar' => $bayar_bulanan,
                        'tanggal_jatuh_tempo' => $jatuh_tempo_bulanan,
                        'status' => 'Belum Lunas',
                    ]);
                }
            }

            if ($request->tenor == '12 Bulan') {
                $tanggal_start = Carbon::createFromFormat('Y-m-d', $request->tanggal_start);

                $jatuh_tempo = $tanggal_start->addDay(360);

                $bayar_bulanan = round($request->total_order / 12);

                $bayar_bulanan = number_format($bayar_bulanan, 0, ".", "");

                $jatuh_tempo_bulanan = $tanggal_start;
                // dd($bayar_bulanan);

                $credit = Credit::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                ]);

                for ($i=0; $i <12 ; $i++) { 
                    $jatuh_tempo_bulanan = $jatuh_tempo_bulanan->addDay(30);
                    $detailCredit = PembayaranCredit::create([
                        'id_pelanggan' => $request->id_pelanggan,
                        'id_credit' => $credit->id,
                        'id_user' => auth()->user()->id,
                        'total_bayar' => $bayar_bulanan,
                        'tanggal_jatuh_tempo' => $jatuh_tempo_bulanan,
                        'status' => 'Belum Lunas',
                    ]);
                }
            }

            // Save data to pemasukan table
            $pemasukan = TransaksiPemasukanSales::create([
                'total_transaksi' => $request->total_order,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_pelanggan' => $request->id_pelanggan,
                'id_sales' => $request->id_sales,
                'id_user' => auth()->user()->id,
                'pembayaran' => 'Credit',
                'tenor' => $request->tenor,
            ]);

        }

        // $pemasukan = TransaksiPemasukan::latest()->first();

        // dd($pemasukan);

        foreach ($carts as $cart) {
            $detailPemasukan = DetailPemasukanSales::create([
                'id_transaksi' => $pemasukan->id,
                'id_produk' => $cart['id'],
                'jumlah' => $cart['jumlah'],
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'harga_produk' => $cart['harga'],
                'total_harga' => $cart['total'],
            ]);

            $produk = Produk::find($cart['id']);

            $produk->update([
                'stock' => $produk->stock - $cart['jumlah']
            ]);
        }

        Session::forget('CartSales');

        return redirect()->route('transaksi-pemasukan-sales.index')->with('toast_success', 'Order berhasil ditambahkan!');   

    }


    public function Report()
    {
        $datas = TransaksiPemasukanSales::orderBy('created_at' , 'ASC')->get();

        return view('admin.reportPemasukanSales.index' , compact('datas'));
    }

    public function ReportDetail($id)
    {
        $parent = TransaksiPemasukanSales::find($id);
        $datas = DetailPemasukanSales::where('id_transaksi' , $id)->get();

        return view('admin.reportPemasukanSales.detail' , compact('datas' , 'parent'));
    }
}
