<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPemasukan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pemasukan';
    public $primaryKey = 'id';
    // public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_pelanggan',
        'id_user',
        'total_transaksi',
        'tanggal_transaksi',
        'pembayaran',
        'tenor',
        'bukti',
        'note',
        'invoice',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id')->withTrashed();
    }

    public function detailPemasukan(){
        return $this->hasMany(DetailPemasukan::class, 'id_transaksi');
    }

    public function dataDetailPemasukan(){
        $datas = DetailPemasukan::where('id_transaksi' , $this->id)->get();

        return $datas;
    }

    public function countDetailPemasukan(){
        $datas = DetailPemasukan::where('id_transaksi' , $this->id)->count();

        return $datas;
    }
}
