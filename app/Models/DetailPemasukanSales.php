<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemasukanSales extends Model
{
    use HasFactory;

    protected $table = 'detail_pemasukan_sales';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'tanggal_transaksi',
        'harga_produk',
        'total_harga',
    ];

    public function transaksi(){
        return $this->belongsTo(TransaksiPemasukanSales::class, 'id_transaksi', 'id');
    }

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
}
