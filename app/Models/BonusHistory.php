<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusHistory extends Model
{
    use HasFactory;

    protected $table = 'bonus_history';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_pelanggan',
        'id_user',
        'id_bonus',
        'id_sales',
        'jumlah_bonus',
        'total_bonus',
        'tanggal_bonus',
        'status',
    ];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id')->withTrashed();
    }


    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id')->withTrashed();
    }


    public function bonus(){
        return $this->belongsTo(Bonus::class, 'id_bonus', 'id');
    }


    public function sales(){
        return $this->belongsTo(Sales::class, 'id_sales', 'id')->withTrashed();
    }
}
