<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $table = 'credit';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id_pelanggan',
        'id_transaksi',
        'total_credit',
        'tenor',
        'tanggal_mulai',
        'tanggal_jatuh_tempo',
        'status',
        'jenis_credit',
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id')->withTrashed();
    }
    public function transaksi(){
        return $this->belongsTo(TransaksiPemasukan::class, 'id_transaksi', 'id');
    }
}
