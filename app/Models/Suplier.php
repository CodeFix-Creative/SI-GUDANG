<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'suplier';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'nama_suplier',
        'nomor_telephone',
        'email',
        'nomor_telephone',
        'jenis',
        'status',
    ];

    protected $dates = ['deleted_at'];
}
