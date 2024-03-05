<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPengeluaranSales extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pengeluaran_sales';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id_user',
        'id_sales',
        'total_transaksi',
        'tanggal_transaksi',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


    public function sales(){
        return $this->belongsTo(Sales::class, 'id_sales', 'id');
    }
}
