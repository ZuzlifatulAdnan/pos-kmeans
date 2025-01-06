@extends('layouts.app')

@section('title', 'Produk')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/d') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
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
                                <h4>Data Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="p-2">
                                    <div class="float-left">
                                        <div class="section-header-button">
                                            <a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah</a>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <form action="{{ route('produk.index') }}" method="GET">
                                            <div class="input-group">
                                                <select name="kategori_id" class="form-control"
                                                    onchange="this.form.submit()">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach ($kategoris as $kategori)
                                                        <option value="{{ $kategori->id }}"
                                                            {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                            {{ $kategori->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>
                                                        Semua Status</option>
                                                    <option value="Aktif"
                                                        {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="Tidak Aktif"
                                                        {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                                        Aktif</option>
                                                </select>
                                                <input type="text" class="form-control" placeholder="Search"
                                                    name="nama" value="{{ request('nama') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="clearfix  divider mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-lg" id="table-1">
                                        <tr>
                                            <th style="width: 3%">No</th>
                                            <th class="text-center">Image</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th style="width: 5%" class="text-center">Action</th>
                                        </tr>
                                        @foreach ($produks as $index => $produk)
                                            <tr>
                                                <td>
                                                    {{ $produks->firstItem() + $index }}
                                                </td>
                                                <td class="text-center">
                                                    <img alt="image"
                                                        src="{{ $produk->image ? asset('img/produk/' . $produk->image) : asset('img/avatar/avatar-1.png') }}"
                                                        class="rounded-circle" width="35" height="35"
                                                        data-toggle="tooltip" title="avatar">
                                                </td>
                                                <td>
                                                    {{ $produk->nama }}
                                                </td>
                                                <td>
                                                    {{ $produk->kategori->nama }}
                                                </td>
                                                <td>
                                                    @if ($produk->status == 'Aktif')
                                                        <span class="badge badge-success">{{ $produk->status }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $produk->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('produk.edit', $produk) }}"
                                                            class="btn btn-sm btn-icon btn-primary m-1"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="{{ route('produk.show', $produk) }}"
                                                            class="btn btn-sm btn-icon btn-info m-1"><i
                                                                class="fas fa-eye"></i></a>
                                                        <form action="{{ route('produk.destroy', $produk) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button
                                                                class="btn btn-sm btn-icon m-1 btn-danger confirm-delete ">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="card-footer d-flex justify-content-between">
                                        <span>
                                            Showing {{ $produks->firstItem() }}
                                            to {{ $produks->lastItem() }}
                                            of {{ $produks->total() }} entries
                                        </span>
                                        <div class="paginate-sm">
                                            {{ $produks->onEachSide(0)->links() }}
                                        </div>
                                    </div>
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush
