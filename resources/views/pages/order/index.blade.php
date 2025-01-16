@extends('layouts.app')

@section('title', 'Order')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/d') }}">
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
                            <h4>Data Order</h4>
                        </div>
                        <div class="card-body">
                            <div class="p-2">
                                <div class="float-left mt-4">
                                    <div class="section-header-button">
                                        <a href="{{ route('order.create') }}" class="btn btn-primary mr-2">Tambah</a>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#exportModal"><i
                                                class="fas fa-download"></i> Export</button>
                                    </div>
                                </div>
                                <div class="float-right mt-4">
                                    <form action="{{ route('order.index') }}" method="GET">
                                        <div class="row">
                                            <!-- Filter: Bulan -->
                                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                                <div class="form-group">
                                                    <select name="bulan" class="form-control"
                                                        onchange="this.form.submit()">
                                                        <option value="">Bulan</option>
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
                                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                                <div class="form-group">
                                                    <select name="tahun" class="form-control"
                                                        onchange="this.form.submit()">
                                                        <option value="">Tahun</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year }}"
                                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                                {{ $year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Filter: Pembayaran -->
                                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                                <div class="form-group">
                                                    <select name="pembayaran_id" class="form-control"
                                                        onchange="this.form.submit()">
                                                        <option value="">Jenis Pembayaran</option>
                                                        @foreach ($pembayarans as $pembayaran)
                                                            <option value="{{ $pembayaran->id }}"
                                                                {{ request('pembayaran_id') == $pembayaran->id ? 'selected' : '' }}>
                                                                {{ $pembayaran->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Filter: Search -->
                                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Search Name"
                                                            name="nama" value="{{ request('nama') }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary"><i
                                                                    class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
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
                                            <h5 class="modal-title" id="exportModalLabel">Export Data Order</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('export.create') }}" method="GET">
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
                                <table class="table table-hover table-bordered table-lg">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%">No</th>
                                            <th>Nama Pemesan</th>
                                            <th class="text-center">Created_At</th>
                                            <th class="text-center">Jenis Pembayaran</th>
                                            <th style="width: 5%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $index => $order)
                                            <tr>
                                                <td>{{ $orders->firstItem() + $index }}</td>
                                                <td>{{ $order->nama }}</td>
                                                <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                                                <td class="text-center">{{ $order->pembayaran->nama }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('order.edit', $order) }}"
                                                            class="btn btn-sm btn-icon btn-primary m-1"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="{{ route('order.show', $order) }}"
                                                            class="btn btn-sm btn-icon btn-info m-1"><i
                                                                class="fas fa-eye"></i></a>
                                                        <form action="{{ route('order.destroy', $order) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button
                                                                class="btn btn-sm btn-icon m-1 btn-danger confirm-delete"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between">
                                    <span>Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of
                                        {{ $orders->total() }} entries</span>
                                    {{ $orders->onEachSide(1)->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
@endpush
