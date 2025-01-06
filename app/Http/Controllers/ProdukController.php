<?php

namespace App\Http\Controllers;

use App\Models\Kategori_produk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProdukController extends Controller
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
        $kategori = $request->input('kategori_id');

        // Query users dengan filter pencarian dan role
        $produks = Produk::when($keyword, function ($query, $nama) {
            $query->where('nama', 'like', '%' . $nama . '%');
        })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($kategori, function ($query, $kategori) {
                $query->where('kategori_id', $kategori);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $produks->appends(['nama' => $keyword, 'status' => $status, 'kategori_id' => $kategori]);
        $kategoris = Kategori_produk::all();

        // arahkan ke file pages/users/index.blade.php
        return view('pages.produk.index', compact('type_menu', 'produks', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'produk';

        $kategoris = Kategori_produk::where('status', 'Aktif')->get();

        // arahkan ke file pages/users/create.blade.php
        return view('pages.produk.create', compact('type_menu', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah user
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'stock' => 'required|integer',
            'harga' => 'required|string',
            'kategori_id' => 'required|integer',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
            'status' => 'required|string'
        ]);
        // Handle the image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('img/produk/', $imagePath);
        }
        //masukan data kedalam tabel users
        Produk::create([
            'nama' => $validatedData['nama'],
            'stock' => $validatedData['stock'],
            'harga' => $validatedData['harga'],
            'image' => $imagePath,
            'kategori_id' => $validatedData['kategori_id'],
            'status' => $validatedData['status']
        ]);

        //jika proses berhsil arahkan kembali ke halaman users dengan status success
        return Redirect::route('produk.index')->with('success', 'Produk berhasil di tambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Produk $produk)
    {
        $type_menu = 'produk';
        $kategoris = Kategori_produk::where('status', 'Aktif')->get();

        // arahkan ke file pages/users/edit
        return view('pages.produk.edit', compact('produk', 'type_menu', 'kategoris'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Produk $produk)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required|string',
            'stock' => 'required|integer',
            'harga' => 'required|string',
            'kategori_id' => 'required|integer',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
            'status' => 'required|string'
        ]);

        // Update the  data
        $produk->update([
            'nama' => $request->nama,
            'stock' => $request->stock,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori_id,
            'status' => $request->status
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('img/produk/', $path);
            $produk->update([
                'image' => $path
            ]);
        }

        return Redirect::route('produk.index')->with('success', 'Produk berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return Redirect::route('produk.index')->with('success', 'Produk berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'produk';
        $produk = produk::find($id);

        // arahkan ke file pages/users/edit
        return view('pages.produk.show', compact('produk', 'type_menu'));
    }
}
