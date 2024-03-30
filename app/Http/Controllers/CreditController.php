<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\PembayaranCredit;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Credit::orderBy('created_at' , 'ASC')->get();

        return view('admin.credit.index' , compact('datas'));
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
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function show(Credit $credit)
    {
        // dd($credit);
        $datas = PembayaranCredit::where('id_credit' , $credit->id)->orderBy('tanggal_jatuh_tempo' , 'ASC')->get();

        $nohp    = $credit->pelanggan->nomor_telephone;
        if(!preg_match("/[^+0-9]/",trim($nohp))){
            // cek apakah no hp karakter ke 1 dan 2 adalah angka 62
            if(substr(trim($nohp), 0, 2)=="62"){
                $hp    =trim($nohp);
            }
            // cek apakah no hp karakter ke 1 adalah angka 0
            else if(substr(trim($nohp), 0, 1)=="0"){
                $hp    ="62".substr(trim($nohp), 1);
            }
        }

        return view('admin.credit.detail' , compact('datas' , 'credit' , 'hp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function edit(Credit $credit)
    {
        // dd($credit);
        $credit->status = 'Lunas';
        $credit->save();
        return redirect()->back()->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Credit $credit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Credit $credit)
    {
        //
    }


    public function detailLunas(Request $request)
    {
        // dd($request->all());
        $detailCredit = PembayaranCredit::find($request->id_detail_credit);
        $detailCredit->tanggal_bayar = $request->tanggal_bayar;
        $detailCredit->status = 'Lunas';
        $detailCredit->id_user = auth()->user()->id;
        $detailCredit->save();

        return redirect()->back()->with('toast_success' , 'Data berhasil di ubah!');
    }


    public function filter(Request $request){
        // dd($request->all());
        if ($request->status == 'Semua' && $request->jenis_credit == 'Semua') {
            $datas = Credit::whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_akhir])->orderBy('created_at' , 'ASC')->get();
        }
        elseif($request->status != 'Semua' && $request->jenis_credit == 'Semua'){
            $datas = Credit::whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_akhir])->where('status' , $request->status)->orderBy('created_at' , 'ASC')->get();
        }
        elseif($request->status == 'Semua' && $request->jenis_credit != 'Semua'){
            $datas = Credit::whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_akhir])->where('jenis_credit' , $request->jenis_credit)->orderBy('created_at' , 'ASC')->get();
        }
        elseif($request->status != 'Semua' && $request->jenis_credit != 'Semua'){
            $datas = Credit::whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_akhir])->where('jenis_credit' , $request->jenis_credit)->where('status' , $request->status)-orderBy('created_at' , 'ASC')->get();
        }

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;
        $status = $request->status;
        $jenisCredit = $request->jenis_credit;

        return view('admin.credit.filtered' , compact('datas' , 'tanggalMulai' , 'tanggalAkhir' , 'status' , 'jenisCredit'));
        
    }

    public function ubahjenis(Request $request){
        $data = Credit::where('id' , $request->id)->first();

        $data->jenis_credit = $request->jenis_credit;
        $data->save();

        return redirect()->back()->with('toast_success' , 'Data berhasil di ubah!');
    }
}
