<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $table = 'bonus';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_produk',
        'aturan',
        'keterangan',
        'jenis_bonus',
        'jumlah_bonus',
        'satuan',
        'status',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk', 'id')->withTrashed();
    }
}
