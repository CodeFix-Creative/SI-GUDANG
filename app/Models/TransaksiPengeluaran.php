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
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
