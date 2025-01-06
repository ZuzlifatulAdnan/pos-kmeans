<?php

namespace App\Http\Controllers;

use App\Models\Kategori_produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KategoriProdukController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'produk';

        // ambil data dari tabel user berdasarkan nama jika terdapat request
        $keyword = trim($request->input('nama'));
        $status = $request->input('status');

        $kategoris = Kategori_produk::when($keyword, function ($query, $nama) {
            $query->where('nama', 'like', '%' . $nama . '%');
        })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $kategoris->appends(['nama' => $keyword, 'status' => $status]);

        // arahkan ke file pages/users/index.blade.php
        return view('pages.kategori_produk.index', compact('type_menu', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'produk';

        // arahkan ke file pages/users/create.blade.php
        return view('pages.kategori_produk.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'status' => 'required|'
        ]);
        Kategori_produk::create([
            'nama' => $validatedData['nama'],
            'status' => $validatedData['status']
        ]);

        //jika proses berhsil arahkan kembali ke halaman users dengan status success
        return Redirect::route('kategori.index')->with('success', 'Kategori berhasil di tambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Kategori_produk $kategori)
    {
        $type_menu = 'produk';

        // arahkan ke file pages/users/edit
        return view('pages.kategori_produk.edit', compact('kategori', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Kategori_produk $kategori)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required',
            'status' => 'required'
        ]);

        // Update the user data
        $kategori->update([
            'nama' => $request->nama,
            'status' => $request->status
        ]);

        return Redirect::route('kategori.index')->with('success', 'Kategori berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori_produk $kategori)
    {
        $kategori->delete();
        return Redirect::route('kategori.index')->with('success', 'Kategori berhasil di hapus.');
    }
}
