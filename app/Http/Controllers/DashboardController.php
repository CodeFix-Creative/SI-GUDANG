<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\TransaksiPemasukan;
use App\Models\TransaksiPengeluaran;
use App\Models\Credit;
use App\Models\PembayaranCredit;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::orderBy('nama_produk' , 'ASC')->get();

        // Penjualan
        $penjualan = TransaksiPemasukan::whereDate('tanggal_transaksi', Carbon::today())->get();
        $penjualanCashHariIni = 0;
        $penjualanTransferHariIni = 0;
        $penjualanCreditHariIni = 0;
        foreach ($penjualan as $item) {
            if($item->pembayaran == 'Cash'){
                $penjualanCashHariIni += $item->total_transaksi;
            }
            if($item->pembayaran == 'Transfer'){
                $penjualanTransferHariIni += $item->total_transaksi;
            }
            if($item->pembayaran == 'Credit'){
                $penjualanCreditHariIni += $item->total_transaksi;
            }
        }


        // Pengeluaran
        $pengeluaranToday = TransaksiPengeluaran::whereDate('tanggal_transaksi', Carbon::today())->get();
        $pengeluaranHariIni = 0;

        foreach ($pengeluaranToday as $item) {
            $pengeluaranHariIni += $item->total_transaksi;
        } 



        $pengeluaranMonthly = TransaksiPengeluaran::whereBetween('tanggal_transaksi', [ Carbon::now()->startOfMonth() , Carbon::now()->endOfMonth() ])->get();
        $pengeluaranBulanIni = 0;

        foreach ($pengeluaranMonthly as $item) {
            $pengeluaranBulanIni += $item->total_transaksi;
        } 


        // Credit 
        $creditLancar = 0;
        $creditMacet = 0;
        $creditTidakTertagih = 0;

        $credit = Credit::where('status' , 'Belum Lunas')->get();
        
        foreach ($credit as $data) {
            if ($data->jenis_credit == 'Lancar') {
                $detailCredit = PembayaranCredit::where('id_credit' , $data->id)->where('status' , 'Belum Lunas')->get();
                foreach ($detailCredit as $item) {
                    $creditLancar += $item->total_bayar;
                }
            }

            if ($data->jenis_credit == 'Macet') {
                $detailCredit = PembayaranCredit::where('id_credit' , $data->id)->where('status' , 'Belum Lunas')->get();
                foreach ($detailCredit as $item) {
                    $creditMacet += $item->total_bayar;
                }
            }

            if ($data->jenis_credit == 'Tidak Tertagih') {
                $detailCredit = PembayaranCredit::where('id_credit' , $data->id)->where('status' , 'Belum Lunas')->get();
                foreach ($detailCredit as $item) {
                    $creditTidakTertagih += $item->total_bayar;
                }
            }
        }

        // dd($creditMacet);


        return view ('admin.dashboard.index' , compact('produk' , 'penjualanCashHariIni' , 'penjualanTransferHariIni' , 'penjualanCreditHariIni' , 'creditLancar' , 'creditMacet' , 'creditTidakTertagih', 'pengeluaranHariIni' , 'pengeluaranBulanIni'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
