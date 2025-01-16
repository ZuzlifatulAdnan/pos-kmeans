<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $orders = Order::with(['orderProduk.produk', 'pembayaran'])
            ->when($this->bulan, function ($query) {
                $query->whereMonth('created_at', $this->bulan);
            })
            ->when($this->tahun, function ($query) {
                $query->whereYear('created_at', $this->tahun);
            })
            ->get();

        return view('pages.export.order', compact('orders'));
    }
}
