<?php

namespace App\Http\Controllers;

use App\Models\Order_produk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KmeansClusterExport;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\DB;
use Phpml\Clustering\KMeans;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Ambil data order_produk untuk clustering
        $orderProduks = Order_produk::select(DB::raw('SUM(jumlah) as jumlah_pesanan'))
            ->when($bulan, fn($query) => $query->whereMonth('created_at', $bulan))
            ->when($tahun, fn($query) => $query->whereYear('created_at', $tahun))
            ->groupBy('produk_id')
            ->get();

        $data = $orderProduks->map(fn($produk) => [$produk->jumlah_pesanan])->toArray();

        // Jalankan KMeans Clustering
        $kmeans = new KMeans(3); // Jumlah cluster
        $clusters = $kmeans->cluster($data);

        // Ekspor ke Excel
        return Excel::download(new KmeansClusterExport($bulan, $tahun, $clusters), 'kmeans_cluster-' . now()->format('Y-m-d') . '.xlsx');
    }
    public function create(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer',
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        return Excel::download(new OrdersExport($bulan, $tahun), 'orders-' . now()->format('Y-m-d') . '.xlsx');   
    }
}
