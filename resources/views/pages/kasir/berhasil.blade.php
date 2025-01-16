@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@push('style')
    <style>
        .nota-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .nota-header img {
            width: 100px;
            margin-bottom: 10px;
        }

        .nota-header h1 {
            font-size: 24px;
            margin: 0;
        }

        .nota-header p {
            font-size: 14px;
            margin: 5px 0;
        }

        .order-details {
            margin-top: 20px;
            width: 100%;
        }

        .order-details th,
        .order-details td {
            padding: 8px;
            text-align: left;
        }

        .order-details th {
            background-color: #f8f9fa;
        }

        .order-details td {
            border-bottom: 1px solid #ddd;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .nota-footer {
            text-align: center;
            margin-top: 40px;
        }

        .nota-footer p {
            font-size: 12px;
            margin: 5px 0;
        }

        .action-buttons {
            text-align: center;
            margin-top: 30px;
        }

        .action-buttons button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 0 10px;
            cursor: pointer;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card" id="nota">
                    <div class="card-body">
                        <!-- Nota Content to be printed -->
                        <div class="nota-header" id="nota-container">
                            <img src="{{ $usaha['logo'] }}" alt="Logo Usaha">
                            <h1>{{ $usaha['nama_usaha'] }}</h1>
                            <p>{{ $usaha['alamat'] }}</p>
                            <p>No. Telepon: {{ $usaha['no_telepon'] }}</p>
                        </div>

                        <div class="order-details">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Pemesan</th>
                                    <td>{{ $order->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Total Harga</th>
                                    <td>Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Pembayaran</th>
                                    <td>{{ $order->pembayaran->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Produk yang Dipesan</th>
                                    <td>
                                        <ul>
                                            @foreach ($order->orderProduk as $item)
                                                <li>{{ $item->produk->nama }} - {{ $item->jumlah }} x Rp.
                                                    {{ number_format($item->harga, 0, ',', '.') }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="total">
                            <p>Total: Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        </div>

                        <div class="nota-footer">
                            <p>Terima kasih telah berbelanja di {{ $usaha['nama_usaha'] }}!</p>
                            <p>Harap simpan nota ini sebagai bukti pembayaran.</p>
                        </div>
                    </div>
                </div>
                {{-- tombol action nya --}}
                <div class="row">
                    <div class="col-md-12">
                        <!-- Card for action buttons -->
                        <div class="card">
                            <div class="card-body">
                                <div class="action-buttons d-flex justify-content-center">
                                    <!-- Cetak Nota Button with Icon -->
                                    <button onclick="printReceipt()" class="btn btn-primary btn-lg m-3">
                                        <i class="fas fa-print"></i> Cetak Nota
                                    </button>
                                    
                                    <!-- Kembali ke Kasir Button with Icon -->
                                    <a href="{{ route('kasir.index') }}" class="btn btn-warning btn-lg m-3">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Kasir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function printReceipt() {
            var printContents = document.getElementById('nota').innerHTML;
            var originalContents = document.body.innerHTML;

            // Ganti isi body dengan konten nota
            document.body.innerHTML = printContents;

            // Cetak halaman
            window.print();

            // Kembalikan isi body ke konten aslinya
            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
