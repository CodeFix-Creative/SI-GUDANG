<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use HasFactory;
    use SoftDeletes;

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
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
