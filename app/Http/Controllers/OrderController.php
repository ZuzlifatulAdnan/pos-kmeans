<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_produk;
use App\Models\Pembayaran;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menu type for active state (optional, can be removed if unused)
        $type_menu = 'order';

        // Filter inputs
        $keyword = trim($request->input('nama'));
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $pembayaran = $request->input('pembayaran_id');

        // Month and year lists
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
        $years = range(date('Y') - 10, date('Y')); // Last 10 years

        // Query orders with filters
        $orders = Order::with(['orderProduk.produk', 'pembayaran']) // Eager load relationships
            ->when($keyword, fn($query) => $query->where('nama', 'like', "%$keyword%"))
            ->when($pembayaran, fn($query) => $query->where('pembayaran_id', $pembayaran))
            ->when($bulan, fn($query) => $query->whereMonth('created_at', $bulan))
            ->when($tahun, fn($query) => $query->whereYear('created_at', $tahun))
            ->latest()
            ->paginate(10);

        $orders->appends(['nama' => $keyword, 'bulan' => $bulan, 'tahun' => $tahun, 'pembayaran_id' => $pembayaran]);
        // Fetch payment methods
        $pembayarans = Pembayaran::all();

        // Pass variables to the view
        return view('pages.order.index', compact(
            'type_menu',
            'months',
            'years',
            'orders',
            'keyword',
            'bulan',
            'tahun',
            'pembayarans'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'order';
        $produks = Produk::where('status', 'Aktif')->get();
        $pembayarans = Pembayaran::all();

        // arahkan ke file pages/users/create.blade.php
        return view('pages.order.create', compact('type_menu', 'produks', 'pembayarans'));
    }

    /**
     * Store a newly created resource in storage.
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
        return redirect()->route('order.index')->with('success', 'Pesanan berhasil dibuat!');
    }
    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $type_menu = 'order';
        $order = Order::with('orderProduk.produk')->findOrFail($id);
        $produks = Produk::with('kategori')->get();
        $pembayarans = Pembayaran::all();

        return view('pages.order.edit', compact('order', 'produks', 'pembayarans', 'type_menu'));
    }

    /**
     * Update the specified order in the database.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->nama = $request->input('nama_pemesan');
        $order->pembayaran_id = $request->input('pembayaran_id');

        // Update the products and quantities
        $totalHarga = 0;
        foreach ($request->produk_id as $key => $produkId) {
            $produk = Produk::findOrFail($produkId);
            $jumlah = $request->jumlah[$key];

            // Ensure stock is sufficient for the quantity
            if ($jumlah > $produk->stock) {
                return redirect()->back()->withErrors(['quantity' => 'Jumlah produk ' . $produk->nama . ' melebihi stok tersedia']);
            }

            // Update or create order product entry
            $orderProduk = $order->orderProduk()->updateOrCreate(
                ['produk_id' => $produkId],
                ['jumlah' => $jumlah, 'harga' => $produk->harga]
            );

            // Calculate total price
            $totalHarga += $produk->harga * $jumlah;
        }

        $order->total_harga = $totalHarga;
        $order->save();

        return redirect()->route('order.index', $order->id)->with('success', 'Order Berhasil Diperbahrui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order, Order_produk $order_produk)
    {
        $order->delete();
        return Redirect::route('order.index')->with('success', 'Pemesanan berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'order';
        $order = Order::find($id);
        $usaha = [
            'nama_usaha' => 'Calma',
            'alamat' => 'DSC Lantai 2 IIB Darmajaya',
            'no_telepon' => '08123456789',
            'logo' => asset('img/logo/logo.png')  // Sesuaikan dengan path logo Anda
        ];
        // arahkan ke file pages/users/edit
        return view('pages.order.show', compact('order', 'type_menu', 'usaha'));
    }
    public function removeProduct(Order $order, $orderProdukId)
    {
        // Find the product in the order
        $orderProduk = $order->orderProduk()->findOrFail($orderProdukId);

        // Delete the product from the order
        $orderProduk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus.',
        ]);
    }
}
