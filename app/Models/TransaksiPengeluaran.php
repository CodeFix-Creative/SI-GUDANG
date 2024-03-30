<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pengeluaran';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id_user',
        'total_transaksi',
        'tanggal_transaksi',
        'note',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function dataDetailPengeluaran(){
        $datas = DetailPengeluaran::where('id_transaksi' , $this->id)->get();

        return $datas;
    }

    public function countDetailPengeluaran(){
        $datas = DetailPengeluaran::where('id_transaksi' , $this->id)->count();

        return $datas;
    }
}
