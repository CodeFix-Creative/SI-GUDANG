<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPemasukan;
use App\Models\DetailPemasukan;
use App\Models\Produk;
use App\Models\ProdukHarga;
use App\Models\Pelanggan;
use App\Models\Credit;
use App\Models\Sales;
use App\Models\PembayaranCredit;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PemasukanExport;

class TransaksiPemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Pelanggan::orderBy('nama_pelanggan' , 'ASC')->get();

        return view('admin.pemasukan.index' , compact('datas'));
    }

    public function form($id)
    {
        // Session::forget('Cart');
        $pelanggan = Pelanggan::find($id);
        $produk = ProdukHarga::where('id_pelanggan' , $pelanggan->id)->get();
        $sales = Sales::find($pelanggan->id_sales);

        if ($pelanggan->sales->trashed()) {
            return redirect()->back()->with('toast_error', 'Ups, Mohon atur ulang sales untuk pelanggan ini!');
        }

        // dd($pelanggan->sales->trashed());

        return view('admin.pemasukan.form' , compact('produk' , 'pelanggan' , 'sales'));
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
     * @param  \App\Models\TransaksiPemasukan  $transaksiPemasukan
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiPemasukan $transaksiPemasukan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiPemasukan  $transaksiPemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiPemasukan $transaksiPemasukan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransaksiPemasukan  $transaksiPemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransaksiPemasukan $transaksiPemasukan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiPemasukan  $transaksiPemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiPemasukan $transaksiPemasukan)
    {
        if ($transaksiPemasukan->pembayaran == 'Credit') {
            $credit = Credit::where('id_transaksi' , $transaksiPemasukan->id)->first();

            if ($credit != null) {
              $detailCredit = PembayaranCredit::where('id_credit' , $credit->id)->get();
  
              foreach ($detailCredit as $item) {
                  $item->delete();
              }
  
              $credit->delete();
            }
        }

        $detailtransaksi = DetailPemasukan::where('id_transaksi' , $transaksiPemasukan->id)->get();
        foreach ($detailtransaksi as $item) {
            // kembalikan Stock
            $produk = Produk::find($item->id_produk);
            $produk->stock = $produk->stock + $item->jumlah;
            $produk->save();
            
            // dd($produk);
            $item->delete();
        }

        $transaksiPemasukan->delete();

        return redirect()->back()->with('toast_success', 'Order berhasil ditambahkan!');
    }

    public function inCart($id) {
        $carts = session()->get('Cart');

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
        // return $request->all();
        $totalOrder = 0;

        if(Session::has('Cart')) {
            $carts = Session::get('Cart')->all();

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
                    'id_pelanggan' => $request->id_pelanggan,
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
            Session::put('Cart', collect($data));

        } else {
            $data = collect([
            [
                'id' => $request->id,
                'nama_barang' => $request->nama_barang,
                'id_pelanggan' => $request->id_pelanggan,
                'jumlah' => $request->jumlah,
                'harga'=> $request->harga,
                'total'=> $request->harga * $request->jumlah,
            ]
            ]);
            Session::put('Cart', $data);
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
            $carts = Session::get('Cart')->all();

            $totalOrder = 0;

            $index = 0;
            foreach ($carts as $cart) {
                if ($cart['id'] == $request->id) {
                    unset($carts[$index]);
                    // $cart['total'] = $cart['price'] * $cart['qty'];
                }
                $index++;
            }

            $data = Session::put('Cart', collect($carts));

            $dataTotal = Session::get('Cart')->all();

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

        // foreach($carts as $key => $cart) {
        //     if($cart['id'] == $request->id) {
        //         unset($carts[$key]);

        //         Session::put('Cart', $carts);

        //         return response()->json([
        //             'status' => 'success',
        //             'data' => $carts,
        //         ], 200);
        //     }
        // }
        // Session::forget('Cart');
    }

    public function checkout(Request $request){
        
        // Check Cart Isi
        if(!Session::has('Cart')){
            return redirect()->route('transaksi-pemasukan.index')
                ->with('toast_error', 'Pilih Barang Terlebih Dahulu!')
                ->withInput();
        }

        $carts = Session::get('Cart')->where('id_pelanggan' , $request->id_pelanggan)->all();

        $index = 0;
        
        // Generate Invoice Number
        $transaksi = TransaksiPemasukan::latest()->first();
        if ($transaksi == null) {
          $latestId = 1;
        }else{
          $latestId = $transaksi->id + 1;
        }

        $tanggal = explode('-' , $request->tanggal_transaksi);

        $invoice = 'INV-' . $latestId . $tanggal[2] . $tanggal[1];

        // dd($invoice);

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
            $pemasukan = TransaksiPemasukan::create([
                'invoice' => $invoice,
                'total_transaksi' => $request->total_order,
                'note' => $request->note,
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
                $nameToko = str_replace(' ', '-', $pelanggan->toko);
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
            $pemasukan = TransaksiPemasukan::create([
                'invoice' => $invoice,
                'total_transaksi' => $request->total_order,
                'note' => $request->note,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_pelanggan' => $request->id_pelanggan,
                'id_user' => auth()->user()->id,
                'pembayaran' => 'Transfer',
                'bukti' => $bukti,
            ]);
        }

        if ($request->jenis_pembayaran == 'Credit') {

            // Save data to pemasukan table
            $pemasukan = TransaksiPemasukan::create([
                'invoice' => $invoice,
                'total_transaksi' => $request->total_order,
                'note' => $request->note,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_pelanggan' => $request->id_pelanggan,
                'id_user' => auth()->user()->id,
                'pembayaran' => 'Credit',
                'tenor' => $request->tenor,
            ]);
            
            if ($request->tenor == '15 Hari') {
                $tanggal_start = Carbon::createFromFormat('Y-m-d', $request->tanggal_start);

                $jatuh_tempo = $tanggal_start->addDay(15);

                // Save data to pemasukan table
                $credit = Credit::create([
                    'id_transaksi' => $pemasukan->id,
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                    'jenis_credit' => 'Lancar',
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
                    'id_transaksi' => $pemasukan->id,
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                    'jenis_credit' => 'Lancar',
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
                    'id_transaksi' => $pemasukan->id,
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                    'jenis_credit' => 'Lancar',
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
                    'id_transaksi' => $pemasukan->id,
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                    'jenis_credit' => 'Lancar',
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
                    'id_transaksi' => $pemasukan->id,
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_credit' => $request->total_order,
                    'tenor' => $request->tenor,
                    'tanggal_mulai' => $request->tanggal_start,
                    'tanggal_jatuh_tempo' => $jatuh_tempo,
                    'status' => 'Belum Lunas',
                    'jenis_credit' => 'Lancar',
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

        }

        // $pemasukan = TransaksiPemasukan::latest()->first();

        // dd($pemasukan);

        foreach ($carts as $cart) {
            $detailPemasukan = DetailPemasukan::create([
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

        Session::forget('Cart');

        return redirect()->route('transaksi-pemasukan.index')->with('toast_success', 'Order berhasil ditambahkan!');

        

    }



    public function Report()
    {
        $datas = TransaksiPemasukan::orderBy('created_at' , 'ASC')->get();

        return view('admin.reportPemasukan.index' , compact('datas'));
    }

    public function ReportDetail($id)
    {
        $parent = TransaksiPemasukan::find($id);
        $datas = DetailPemasukan::where('id_transaksi' , $id)->get();

        return view('admin.reportPemasukan.detail' , compact('datas' , 'parent'));
    }

    public function export(Request $request)
    {
        // dd($request->all());
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        return Excel::download(new PemasukanExport($tanggal_awal , $tanggal_akhir), 'Data-Pemasukan-'. $tanggal_awal .'-'. $tanggal_akhir .'.xlsx');
    }

    public function filter(Request $request){
        // dd($request->all());
        if ($request->pembayaran == 'Semua') {
            $datas = TransaksiPemasukan::whereBetween('tanggal_transaksi', [$request->tanggal_mulai, $request->tanggal_akhir])->orderBy('created_at' , 'ASC')->get();
        }else{
            $datas = TransaksiPemasukan::whereBetween('tanggal_transaksi', [$request->tanggal_mulai, $request->tanggal_akhir])->where('pembayaran' , $request->pembayaran)->orderBy('created_at' , 'ASC')->get();
        }

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;
        $pembayaran = $request->pembayaran;

        return view('admin.reportPemasukan.filtered' , compact('datas' , 'tanggalMulai' , 'tanggalAkhir' , 'pembayaran'));
    }
}
