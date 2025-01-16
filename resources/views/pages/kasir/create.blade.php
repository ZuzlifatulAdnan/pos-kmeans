@extends('layouts.app')

@section('title', 'POS Kasir')

@push('style')
    <!-- CSS Libraries -->
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
                <h1>POS Kasir</h1>
            </div>

            <div class="section-body">
                <form action="{{ route('kasir.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Produk Dipesan</h4>
                        </div>
                        <div class="card-body">
                            <!-- Produk yang dipesan -->
                            <div id="product-list">
                                <div class="product-item row mb-3">
                                    <div class="col-md-4">
                                        <label>Produk<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="produk_id[]" required>
                                            <option value="" disabled selected>Pilih Produk</option>
                                            @foreach ($produks->groupBy('kategori.nama') as $kategoriNama => $produk)
                                                <optgroup label="{{ $kategoriNama }}">
                                                    @foreach ($produk as $item)
                                                        <option value="{{ $item->id }}" data-stock="{{ $item->stock }}"
                                                            data-harga="{{ $item->harga }}"
                                                            data-image="{{ asset('img/produk/' . $item->image) }}">
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
                                            value="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Stock<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control stock" value="-" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Harga saat ini<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control harga-saat-ini" value="Rp. -" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Gambar Produk</label>
                                        <img src="{{ asset('img/avatar/avatar-1.png') }}" class="img-fluid product-image"
                                            alt="Gambar Produk">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-product">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-product" class="btn btn-success btn-sm">Tambah Produk</button>

                            <hr>

                            <!-- Informasi tambahan -->
                            <div class="form-group">
                                <label>Nama Pemesan<span class="text-danger">*</span></label>
                                <input type="text" name="nama_pemesan" class="form-control"
                                    placeholder="Masukkan Nama Pemesan" required>
                            </div>
                            <div class="form-group">
                                <label>Total Pesanan<span class="text-danger">*</span></label>
                                <input type="text" id="total-pesanan" class="form-control" name="total_harga"
                                    value="Rp. 0" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Pembayaran<span class="text-danger">*</span></label>
                                <select class="form-control" name="pembayaran_id" required>
                                    <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                                    @foreach ($pembayarans as $pembayaran)
                                        <option value="{{ $pembayaran->id }}">{{ $pembayaran->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Proses Pesanan</button>
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

            const productTemplate = `
            <div class="product-item row mb-3">
                                    <div class="col-md-4">
                                        <label>Produk<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="produk_id[]" required>
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
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Quantity<span class="text-danger">*</span></label>
                                        <input type="number" name="jumlah[]" class="form-control jumlah" min="1" value="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Stock<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control stock" value="-" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Harga saat ini<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control harga-saat-ini" value="Rp. -" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Gambar Produk</label>
                                        <img src="{{ asset('img/avatar/avatar-1.png') }}" class="img-fluid product-image" alt="Gambar Produk">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-product">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
            `;

            function updateSelectedProducts() {
                let selectedProducts = [];
                $('#product-list .product-item .select2').each(function() {
                    const value = $(this).val();
                    if (value) {
                        selectedProducts.push(value);
                    }
                });

                $('#product-list .product-item .select2').each(function() {
                    const currentSelect = $(this);
                    const currentValue = currentSelect.val();

                    currentSelect.find('option').each(function() {
                        const optionValue = $(this).val();
                        if (selectedProducts.includes(optionValue) && optionValue !==
                            currentValue) {
                            $(this).attr('disabled', 'disabled');
                        } else {
                            $(this).removeAttr('disabled');
                        }
                    });

                    currentSelect.trigger('change.select2');
                });
            }

            function calculateTotal() {
                let total = 0;
                $('#product-list .product-item').each(function() {
                    const quantity = $(this).find('.jumlah').val() || 0;
                    const price = $(this).find('.harga-saat-ini').val().replace('Rp. ', '').replace(/\./g,
                        '') || 0;
                    total += parseInt(quantity) * parseInt(price);
                });
                $('#total-pesanan').val(`Rp. ${total.toLocaleString('id-ID')}`);
            }

            $('#add-product').on('click', function() {
                $('#product-list').append(productTemplate);
                $('.select2').select2();
                updateSelectedProducts();
                calculateTotal();
            });

            $('#product-list').on('change', '.select2', function() {
                const selectedOption = $(this).find('option:selected');
                const stock = selectedOption.data('stock') || '-';
                const harga = selectedOption.data('harga') || 0;
                const image = selectedOption.data('image') || '{{ asset('images/placeholder.png') }}';

                const productItem = $(this).closest('.product-item');
                productItem.find('.stock').val(stock);
                productItem.find('.harga-saat-ini').val(`Rp. ${harga.toLocaleString('id-ID')}`);
                productItem.find('.product-image').attr('src', image);

                updateSelectedProducts();
                calculateTotal();
            });

            $('#product-list').on('input', '.jumlah', function() {
                calculateTotal();
            });

            $('#product-list').on('click', '.remove-product', function() {
                $(this).closest('.product-item').remove();
                updateSelectedProducts();
                calculateTotal();
            });
        });
    </script>
@endpush
