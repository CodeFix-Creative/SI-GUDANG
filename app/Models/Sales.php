<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id_user',
        'nomor_telephone',
        'email',
        'alamat',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
