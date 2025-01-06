<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori_id',
        'nama',
        'stock',
        'harga',
        'image',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori_produk::class);
    }
}
