<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemasukan extends Model
{
    use HasFactory;

    protected $table = 'detail_pemasukan';
    public $primaryKey = 'id';
    public $incrementing = false;
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
        return $this->belongsTo(TransaksiPemasukan::class, 'id_transaksi', 'id');
    }

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk', 'id')->withTrashed();
    }
}
