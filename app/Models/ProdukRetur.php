<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukRetur extends Model
{
    use HasFactory;

    protected $table = 'produk_retur';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_produk',
        'id_pelanggan',
        'jumlah',
        'status',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }


    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }
}
