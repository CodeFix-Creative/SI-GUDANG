<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukHarga extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pelanggan_produk';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_pelanggan',
        'id_produk',
        'harga',
    ];

    protected $dates = ['deleted_at'];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id')->withTrashed();
    }

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk', 'id')->withTrashed();
    }
}
