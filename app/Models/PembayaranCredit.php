<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranCredit extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_credit';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id_pelanggan',
        'id_credit',
        'id_user',
        'total_bayar',
        'tanggal_bayar',
        'tanggal_jatuh_tempo',
        'status',
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function credit(){
        return $this->belongsTo(Credit::class, 'id_credit', 'id');
    }
}
