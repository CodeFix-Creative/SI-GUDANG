<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'produk';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'stock',
        'satuan',
        // 'harga',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function kategori(){
        return $this->belongsTo(KategoriProduk::class, 'id_kategori', 'id');
    }
}
