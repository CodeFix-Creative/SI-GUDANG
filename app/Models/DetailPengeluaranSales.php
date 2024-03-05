<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengeluaranSales extends Model
{
    use HasFactory;

    protected $table = 'detail_pengeluaran_sales';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id_transaksi',
        'nama_pengeluaran',
        'jumlah',
        'tanggal_transaksi',
        'harga',
        'total_harga',
    ];

    public function transaksi(){
        return $this->belongsTo(TransaksiPengeluaranSales::class, 'id_transaksi', 'id');
    }
}
