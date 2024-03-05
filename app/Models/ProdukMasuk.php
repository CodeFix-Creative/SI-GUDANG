<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukMasuk extends Model
{
    use HasFactory;

    protected $table = 'produk_masuk';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_produk',
        'id_suplier',
        'jumlah',
        'tanggal_masuk',
        'id_user',
        'status',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }


    public function suplier(){
        return $this->belongsTo(Suplier::class, 'id_suplier', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
