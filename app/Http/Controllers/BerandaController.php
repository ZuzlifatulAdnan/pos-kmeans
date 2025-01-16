<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'beranda';
        // Menentukan bulan dan tahun default
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Statistik total user dan produk
        $totalUser = User::count();
        $totalProduk = Produk::count();

        // Statistik total order dan total harga berdasarkan bulan dan tahun
        $totalOrder = Order::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->count();
        $totalHarga = number_format(Order::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->sum('total_harga'), 0, ',', '.');
        return view('pages.beranda.index', compact('type_menu', 'totalUser', 'totalProduk', 'totalOrder', 'totalHarga', 'bulan', 'tahun'));
    }
}
