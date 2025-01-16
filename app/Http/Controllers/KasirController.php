<?php

namespace App\Http\Controllers;

use App\Models\Kategori_produk;
use App\Models\Order;
use App\Models\Order_produk;
use App\Models\Pembayaran;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Redirect;

class KasirController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $type_menu = 'kasir';
        $produks = Produk::where('status', 'Aktif')->get();
        $pembayarans = Pembayaran::all();

        return view('pages.kasir.create', compact('type_menu', 'produks', 'pembayarans'));
    }

    /**
     * Menyimpan data order
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'exists:produks,id|distinct',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'integer|min:1',
            'pembayaran_id' => 'required|exists:pembayarans,id',
        ]);

        if (count($request->produk_id) !== count($request->jumlah)) {
            return back()->withErrors(['error' => 'Jumlah produk dan kuantitas tidak sesuai!']);
        }

        DB::transaction(function () use ($request, &$order) {
            $totalHarga = 0;

            // Ambil data produk yang dipesan berdasarkan produk_id
            $produks = Produk::whereIn('id', $request->produk_id)->get()->keyBy('id');

            foreach ($request->produk_id as $index => $produkId) {
                $produk = $produks[$produkId];

                // Validasi apakah stok mencukupi
                if ($produk->stock < $request->jumlah[$index]) {
                    throw new \Exception('Stok produk ' . $produk->nama . ' tidak mencukupi!');
                }

                // Hitung total harga
                $totalHarga += $produk->harga * $request->jumlah[$index];
            }

            // Simpan data order
            $order = Order::create([
                'nama' => $request->nama_pemesan,
                'total_harga' => $totalHarga,
                'pembayaran_id' => $request->pembayaran_id,
            ]);

            // Simpan detail produk yang dipesan dan kurangi stok
            foreach ($request->produk_id as $index => $produkId) {
                $produk = $produks[$produkId];

                // Kurangi stok produk
                $produk->stock -= $request->jumlah[$index];
                $produk->save();

                // Simpan detail produk yang dipesan
                Order_produk::create([
                    'order_id' => $order->id,
                    'produk_id' => $produkId,
                    'jumlah' => $request->jumlah[$index],
                    'harga' => $produk->harga,
                ]);
            }
        });

        // Redirect to show the created order page
        return redirect()->route('kasir.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }
    /**
     * Menampilkan halaman pesanan berhasil
     */
    public function show($orderId)
    {
        $type_menu = 'kasir';
        $order = Order::with('orderProduk.produk', 'pembayaran')
            ->findOrFail($orderId);
        $usaha = [
            'nama_usaha' => 'Calma',
            'alamat' => 'DSC Lantai 2 IIB Darmajaya',
            'no_telepon' => '08123456789',
            'logo' => asset('img/logo/logo.png')  // Sesuaikan dengan path logo Anda
        ];
        return view('pages.kasir.berhasil', compact('order', 'type_menu', 'usaha'));
    }
}
