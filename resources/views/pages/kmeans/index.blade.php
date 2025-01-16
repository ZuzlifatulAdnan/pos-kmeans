@extends('layouts.app')

@section('title', 'KMeans Clustering')

@push('style')
    <!-- Memuat CSS DataTables untuk Stisla -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Produk yang Paling Banyak Dipesan</h4>
                        </div>
                        <div class="card-body">
                            <div class="p-2">
                                <div class="float-left mt-4">
                                    <div class="section-header-button">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#exportModal"><i
                                                class="fas fa-download"></i> Export</button>
                                    </div>
                                </div>
                                <div class="float-right mt-4">
                                    <form action="{{ route('kmeans.index') }}" method="GET">
                                        <div class="row">
                                            <!-- Filter: Bulan -->
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <select name="bulan" class="form-control select2"
                                                        onchange="this.form.submit()">
                                                        <option value="">Pilih Bulan</option>
                                                        @foreach ($months as $key => $month)
                                                            <option value="{{ $key }}"
                                                                {{ request('bulan') == $key ? 'selected' : '' }}>
                                                                {{ $month }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Filter: Tahun -->
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <select name="tahun" class="form-control select2"
                                                        onchange="this.form.submit()">
                                                        <option value="">Pilih Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}"
                                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                                {{ $year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal fade" id="exportModal" tabindex="-1" role="dialog"
                                aria-labelledby="exportModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exportModalLabel">Export Data Cluster Kmeans</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('export.index') }}" method="GET">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="bulan">Pilih Bulan</label>
                                                    <select name="bulan" id="bulan" class="form-control selectric">
                                                        <option value="">Pilih Bulan</option>
                                                        @foreach ($months as $key => $month)
                                                            <option value="{{ $key }}">{{ $month }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tahun">Pilih Tahun</label>
                                                    <select name="tahun" id="tahun" class="form-control selectric">
                                                        <option value="">Pilih Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}">{{ $year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Export</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Table Data -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered" id="orderProdukTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%">No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah Pesanan</th>
                                            <th>Cluster</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_produks as $produk)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $produk->produk->nama }}</td>
                                                <td>{{ $produk->jumlah_pesanan }}</td>
                                                <td>
                                                    {{ $produk->cluster }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Memuat JS DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Menginisialisasi DataTables
            $('#orderProdukTable').DataTable({
                // Konfigurasi tambahan untuk DataTables
                "paging": true, // Mengaktifkan pagination
                "searching": false, // Mengaktifkan pencarian
                "ordering": false, // Mengaktifkan pengurutan
                "info": true, // Menampilkan informasi jumlah data
                "lengthChange": false, // Menonaktifkan pilihan untuk mengubah jumlah baris per halaman
                "language": {
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    },
                    "search": "Pencarian:",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri"
                }
            });
        });
    </script>
@endpush
