<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'pelanggan';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'kode_pelanggan',
        'nama_pelanggan',
        'toko',
        'nomor_telephone',
        'alamat',
        'email',
        'id_sales',
    ];
    protected $dates = ['deleted_at'];

    public function sales(){
        return $this->belongsTo(Sales::class, 'id_sales', 'id')->withTrashed();
    }
}
