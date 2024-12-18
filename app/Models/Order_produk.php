<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'produk_id',
        'jumlah',
        'harga'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
