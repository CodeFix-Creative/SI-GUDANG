<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'nama_pelanggan',
        'id_toko',
        'nomor_telephone',
        'alamat',
        'email',
    ];

    public function toko(){
        return $this->belongsTo(Toko::class, 'id_toko', 'id');
    }
}
