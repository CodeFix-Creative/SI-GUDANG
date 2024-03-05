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
        'total_credit',
        'tenor',
        'tanggal_mulai',
        'tanggal_jatuh_tempo',
        'status',
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id');
    }
}
