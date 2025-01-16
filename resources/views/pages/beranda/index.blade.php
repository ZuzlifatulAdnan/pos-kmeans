@extends('layouts.app')

@section('title', 'Beranda')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Selamat Datang! {{ Auth::user()->name }} di POS Calma Kmeans</h1>
            </div>
            <div class="section-body">
                <!-- Filter Bulan dan Tahun -->
                <div class="row mb-4">
                    <div class="col-12">
                        <form method="GET" action="{{ route('beranda.index') }}">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Filter Berdasarkan Bulan dan Tahun</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-4 form-group">
                                            <label for="bulan">Pilih Bulan</label>
                                            <select name="bulan" id="bulan" class="form-control">
                                                <option value="01" {{ $bulan == '01' ? 'selected' : '' }}>Januari
                                                </option>
                                                <option value="02" {{ $bulan == '02' ? 'selected' : '' }}>Februari
                                                </option>
                                                <option value="03" {{ $bulan == '03' ? 'selected' : '' }}>Maret</option>
                                                <option value="04" {{ $bulan == '04' ? 'selected' : '' }}>April</option>
                                                <option value="05" {{ $bulan == '05' ? 'selected' : '' }}>Mei</option>
                                                <option value="06" {{ $bulan == '06' ? 'selected' : '' }}>Juni</option>
                                                <option value="07" {{ $bulan == '07' ? 'selected' : '' }}>Juli</option>
                                                <option value="08" {{ $bulan == '08' ? 'selected' : '' }}>Agustus
                                                </option>
                                                <option value="09" {{ $bulan == '09' ? 'selected' : '' }}>September
                                                </option>
                                                <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober
                                                </option>
                                                <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November
                                                </option>
                                                <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Desember
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="tahun">Pilih Tahun</label>
                                            <select name="tahun" id="tahun" class="form-control">
                                                @for ($i = 2020; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group align-self-end">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                <i class="fas fa-filter"></i> Terapkan Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="row">
                    <!-- Total User -->
                    @if (Auth::user()->role == 'Admin')
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>{{ __('Users') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        {{ $totalUser }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                    @endif
                    <!-- Total Produk -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Produk') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalProduk }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Order -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Total Order') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalOrder }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Harga -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Total Harga') }}</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ $totalHarga }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
