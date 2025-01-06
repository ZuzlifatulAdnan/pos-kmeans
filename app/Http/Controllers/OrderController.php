<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'kasir';

        // ambil data dari tabel user berdasarkan nama jika terdapat request
        $keyword = trim($request->input('nama'));
        // $role = $request->input('role');

        // Query users dengan filter pencarian dan role
        $orders = Order::when($keyword, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            // ->when($role, function ($query, $role) {
            //     $query->where('role', $role);
            // })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $orders->appends(['name' => $keyword]);

        // arahkan ke file pages/users/index.blade.php
        return view('pages.order.index', compact('type_menu', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'kasir';

        // arahkan ke file pages/users/create.blade.php
        return view('pages.order.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah user
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'total_harga' => 'required',
            'note' => 'nullabel',
            'pembayaran_id' => 'required',
        ]);
        
        //masukan data kedalam tabel users
        Order::create([
            'nama' => $validatedData['nama'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'total_harga' => $validatedData['total_harga'],
            'note' => $validatedData['note'],
            'pembayaran_id' => $validatedData['pembayaran_id'],
        ]);

        //jika proses berhsil arahkan kembali ke halaman users dengan status success
        return Redirect::route('order.index')->with('success', 'Order berhasil di tambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Order $order)
    {
        $type_menu = 'kasir';

        // arahkan ke file pages/users/edit
        return view('pages.order.edit', compact('order', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Order $order)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'total_harga' => 'required',
            'note' => 'nullabel',
            'pembayaran_id' => 'required',
        ]);

        // Update the user data
        $order->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'total_harga' => $request->total_harga,
            'note' => $request->note,
            'pembayaran_id' => $request->pembayaran_id,
        ]);

        return Redirect::route('order.index')->with('success', 'Order berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return Redirect::route('order.index')->with('success', 'Order berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'kasir';
        $order = Order::find($id);

        // arahkan ke file pages/users/edit
        return view('pages.order.show', compact('order', 'type_menu'));
    }
}
