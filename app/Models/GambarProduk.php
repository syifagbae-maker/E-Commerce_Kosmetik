<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarProduk extends Model
{
    protected $table = 'gambar_produk';

    protected $primaryKey = 'id_gambar';

    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'path_gambar',
        'alt_text',
        'gambar_utama',
        'urutan',
    ];

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk',
            'id_produk'
        );
    }
}
