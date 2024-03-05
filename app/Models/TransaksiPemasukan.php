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
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }

    public function detailPemasukan(){
        return $this->hasMany(DetailPemasukan::class, 'id_transaksi');
    }
}
