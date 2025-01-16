<?php

namespace App\Http\Controllers;

use App\Models\Order_produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Phpml\Clustering\KMeans;

class KmeansController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'order';

        $keyword = trim($request->input('nama'));
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $years = range(date('Y') - 10, date('Y'));

        // Mengatur filter bulan dan tahun dengan kondisi jika tidak ada input
        $order_produks = Order_produk::with('produk')
            ->select('produk_id', DB::raw('SUM(jumlah) as jumlah_pesanan'))
            ->when($keyword, fn($query) =>
                $query->whereHas('produk', fn($q) =>
                    $q->where('nama', 'like', "%$keyword%")))
            ->when($bulan, fn($query) => $query->whereMonth('created_at', $bulan))
            ->when($tahun, fn($query) => $query->whereYear('created_at', $tahun))
            ->groupBy('produk_id')
            ->get();

        // Pastikan data bukan null atau false
        if ($order_produks && !$order_produks->isEmpty()) {
            $data = $order_produks->map(fn($produk) => [$produk->jumlah_pesanan])->toArray();

            // Menggunakan KMeans
            $kmeans = new KMeans(3);
            $clusters = $kmeans->cluster($data);

            // Menentukan cluster untuk setiap produk
            foreach ($order_produks as $index => $produk) {
                foreach ($clusters as $clusterIndex => $clusterData) {
                    if (in_array([$produk->jumlah_pesanan], $clusterData)) {
                        // Tambahkan +1 ke nilai cluster
                        $produk->cluster = $clusterIndex + 1;
                        break;
                    }
                }
            }

            $order_produks = $order_produks->sortByDesc('jumlah_pesanan');
        }

        return view('pages.kmeans.index', compact(
            'order_produks',
            'months',
            'years',
            'bulan',
            'tahun',
            'keyword',
            'type_menu'
        ));
    }
}
