<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'total_harga',
        'note',
        'pembayaran_id'
    ];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
