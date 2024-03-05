<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPemasukanSales extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pemasukan_sales';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id_pelanggan',
        'id_user',
        'id_sales',
        'pembayaran',
        'bukti',
        'tenor',
        'total_transaksi',
        'tanggal_transaksi',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }


    public function sales(){
        return $this->belongsTo(Sales::class, 'id_sales', 'id');
    }
}
