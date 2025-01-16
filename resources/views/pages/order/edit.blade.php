@extends('layouts.app')

@section('title', 'Edit Order')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        .form-control-inline {
            display: inline-block;
            width: auto;
        }

        .remove-product {
            color: red;
            cursor: pointer;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .product-item {
            margin-bottom: 15px;
        }

        .product-image {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="col-12">
                @include('layouts.alert')
            </div>
            <div class="section-header">
                <h1>Edit Order</h1>
            </div>

            <div class="section-body">
                <form action="{{ route('order.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4>Produk Dipesan</h4>
                        </div>
                        <div class="card-body">
                            <div id="product-list">
                                @foreach ($order->orderProduk as $orderProduk)
                                    <div class="product-item row mb-3">
                                        <input type="hidden" name="order_produk_id[]" value="{{ $orderProduk->id }}">
                                        <div class="col-md-4">
                                            <label>Produk<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="produk_id[]" required>
                                                <option value="" disabled>Pilih Produk</option>
                                                @foreach ($produks->groupBy('kategori.nama') as $kategoriNama => $produk)
                                                    <optgroup label="{{ $kategoriNama }}">
                                                        @foreach ($produk as $item)
                                                            <option value="{{ $item->id }}"
                                                                data-stock="{{ $item->stock }}"
                                                                data-harga="{{ $item->harga }}"
                                                                data-image="{{ asset('img/produk/' . $item->image) }}"
                                                                {{ $orderProduk->produk_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->nama }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Jumlah<span class="text-danger">*</span></label>
                                            <input type="number" name="jumlah[]" class="form-control jumlah" min="1"
                                                value="{{ $orderProduk->jumlah }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Stock<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control stock"
                                                value="{{ $orderProduk->produk->stock }}" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Harga<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control harga-saat-ini" name="harga"
                                                value="Rp. {{ number_format($orderProduk->produk->harga, 0, ',', '.') }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <img src="{{ asset('img/produk/' . $orderProduk->produk->image) }}"
                                                class="img-fluid product-image" alt="Gambar Produk">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-product">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-product" class="btn btn-success btn-sm">Tambah Produk</button>

                            <hr>

                            <div class="form-group">
                                <label>Nama Pemesan<span class="text-danger">*</span></label>
                                <input type="text" name="nama_pemesan" class="form-control"
                                    placeholder="Masukkan Nama Pemesan" value="{{ $order->nama }}" required>
                            </div>
                            <div class="form-group">
                                <label>Total Pesanan<span class="text-danger">*</span></label>
                                <input type="text" id="total-pesanan" class="form-control" name="total_harga"
                                    value="Rp. {{ number_format($order->total_harga, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Pembayaran<span class="text-danger">*</span></label>
                                <select class="form-control" name="pembayaran_id" required>
                                    <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                                    @foreach ($pembayarans as $pembayaran)
                                        <option value="{{ $pembayaran->id }}"
                                            {{ $order->pembayaran_id == $pembayaran->id ? 'selected' : '' }}>
                                            {{ $pembayaran->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Proses Pembaruan</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.select2').select2();

            function calculateTotal() {
                let totalHarga = 0;
                $('#product-list .product-item').each(function() {
                    const jumlah = parseInt($(this).find('.jumlah').val()) || 0;
                    const harga = parseInt($(this).find('.select2 option:selected').data('harga')) || 0;
                    totalHarga += jumlah * harga;
                });
                $('#total-pesanan').val('Rp. ' + totalHarga.toLocaleString('id-ID'));
            }

            function createProductItem() {
                const produkOptions = ` 
                    <option value="" disabled selected>Pilih Produk</option>
                    @foreach ($produks->groupBy('kategori.nama') as $kategoriNama => $produk)
                        <optgroup label="{{ $kategoriNama }}">
                            @foreach ($produk as $item)
                                <option value="{{ $item->id }}"
                                    data-stock="{{ $item->stock }}"
                                    data-harga="{{ $item->harga }}"
                                    data-image="{{ asset('img/produk/' . $item->image) }}">
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                `;

                return `
                    <div class="product-item row mb-3">
                        <div class="col-md-4">
                            <label>Produk<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="produk_id[]" required>
                                ${produkOptions}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Jumlah<span class="text-danger">*</span></label>
                            <input type="number" name="jumlah[]" class="form-control jumlah" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <label>Stock<span class="text-danger">*</span></label>
                            <input type="text" class="form-control stock" value="0" readonly>
                        </div>
                        <div class="col-md-2">
                            <label>Harga<span class="text-danger">*</span></label>
                            <input type="text" name="harga" class="form-control harga-saat-ini" value="Rp. 0" readonly>
                        </div>
                        <div class="col-md-2">
                            <img src="{{ asset('img/avatar/avatar-1.png') }}" class="img-fluid product-image" alt="Gambar Produk">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-product">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;
            }

            $('#add-product').on('click', function() {
                const newItem = createProductItem();
                $('#product-list').append(newItem);
                $('.select2').select2();
            });

            $('#product-list').on('click', '.remove-product', function() {
                const orderProdukId = $(this).closest('.product-item').find('input[name="order_produk_id[]"]').val();
                const productItem = $(this).closest('.product-item');

                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    // Send an AJAX request to delete the product
                    $.ajax({
                        url: `{{ url('/order/' . $order->id . '/produk/') }}/${orderProdukId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.success) {
                                productItem.remove();
                                calculateTotal();
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menghapus produk.');
                        }
                    });
                }
            });

            $('#product-list').on('change input', '.select2, .jumlah', function() {
                const row = $(this).closest('.product-item');
                const selectedOption = row.find('.select2 option:selected');
                const stock = selectedOption.data('stock') || 0;
                const harga = selectedOption.data('harga') || 0;
                const image = selectedOption.data('image') || "{{ asset('img/default-product.png') }}";

                row.find('.stock').val(stock);
                row.find('.harga-saat-ini').val('Rp. ' + harga.toLocaleString('id-ID'));
                row.find('.product-image').attr('src', image);

                // Set maximum quantity to available stock
                row.find('.jumlah').attr('max', stock);

                calculateTotal();
            });

            calculateTotal();
        });
    </script>
@endpush
