<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';

    protected $primaryKey = 'id_brand';

    public $timestamps = false;

    protected $fillable = [
        'nama_brand',
        'slug',
        'deskripsi',
        'logo',
        'status',
    ];
}
