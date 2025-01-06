<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'pembayaran';

        // ambil data dari tabel user berdasarkan nama jika terdapat request
        $keyword = trim($request->input('nama'));
        $status = $request->input('status');

        // Query users dengan filter pencarian dan status
        $pembayarans = Pembayaran::when($keyword, function ($query, $nama) {
            $query->where('nama', 'like', '%' . $nama . '%');
        })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $pembayarans->appends(['nama' => $keyword, 'status' => $status]);

        // arahkan ke file pages/users/index.blade.php
        return view('pages.pembayaran.index', compact('type_menu', 'pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'pembayaran';

        // arahkan ke file pages/users/create.blade.php
        return view('pages.pembayaran.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah user
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
            'status' => 'required|string',
        ]);
        // Handle the image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('img/pembayaran/', $imagePath);
        }
        //masukan data kedalam tabel users
        Pembayaran::create([
            'nama' => $validatedData['nama'],
            'image' => $imagePath,
            'status' => $validatedData['status'],
        ]);

        //jika proses berhsil arahkan kembali ke halaman users dengan status success
        return Redirect::route('pembayaran.index')->with('success', 'Pembayaran berhasil di tambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $type_menu = 'pembayaran';

        // arahkan ke file pages/users/edit
        return view('pages.pembayaran.edit', compact('pembayaran', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required|string',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
            'status' => 'required|string',
        ]);

        // Update the user data
        $pembayaran->update([
            'nama' => $request->nama,
            'status' => $request->status,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('img/pembayaran/', $path);
            $pembayaran->update([
                'image' => $path
            ]);
        }

        return Redirect::route('pembayaran.index')->with('success', 'Pembayaran berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return Redirect::route('pembayaran.index')->with('success', 'Pembayaran berhasil di hapus.');
    }
}
