@extends('layouts.app')

@section('title', 'Detail Produk')

@push('style')
    <style>
        .detail-header {
            font-weight: bold;
            color: #555;
        }

        .detail-value {
            margin-bottom: 10px;
        }

        .image-preview {
            width: 200px;
            height: 200px;
            border: 2px dashed #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Nama:</span>
                                <p>{{ $produk->nama }}</p>
                            </div>
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Harga:</span>
                                <p>Rp. {{ $produk->harga }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Kategori:</span>
                                <p>{{ $produk->kategori->nama }}</p>
                            </div>
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Harga:</span>
                                <p>{{ $produk->stock }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Role -->
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">status:</span>
                                <p>{{ $produk->status }}</p>
                            </div>
                            <!-- Image -->
                            <div class="col-md-6 detail-value">
                                <span class="detail-header">Image:</span>
                                <div class="image-preview">
                                    @if ($produk->image)
                                        <img src="{{ asset('img/produk/' . $produk->image) }}" alt="produk Image">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('produk.index') }}" class="btn btn-warning">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
