<?php

namespace App\Exports;

use App\Models\Order_produk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KmeansClusterExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;
    protected $clusters;

    public function __construct($bulan, $tahun, $clusters)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->clusters = $clusters;
    }

    public function collection()
    {
        $orderProduks = Order_produk::with('produk')
            ->select('produk_id', DB::raw('SUM(jumlah) as jumlah_pesanan'))
            ->when($this->bulan, fn($query) => $query->whereMonth('created_at', $this->bulan))
            ->when($this->tahun, fn($query) => $query->whereYear('created_at', $this->tahun))
            ->groupBy('produk_id')
            ->get();

        // Tambahkan cluster ke data
        foreach ($orderProduks as $produk) {
            foreach ($this->clusters as $clusterIndex => $clusterData) {
                if (in_array([$produk->jumlah_pesanan], $clusterData)) {
                    $produk->cluster = $clusterIndex + 1;
                    break;
                }
            }
        }

        return $orderProduks->map(fn($produk) => [
            // 'ID Produk' => $produk->produk_id,
            'Nama Produk' => $produk->produk->nama,
            'Jumlah Pesanan' => $produk->jumlah_pesanan,
            'Cluster' => $produk->cluster,
        ]);
    }

    public function headings(): array
    {
        return ['Nama Produk', 'Jumlah Pesanan', 'Cluster'];
    }
}
