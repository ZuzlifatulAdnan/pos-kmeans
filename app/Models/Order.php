<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'total_harga',
        'pembayaran_id'
    ];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
    public function orderProduk()
{
    return $this->hasMany(Order_produk::class);
}
}
