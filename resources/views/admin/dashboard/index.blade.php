@extends('layouts.template')

@section('dashboard' , 'active')

@section('content')
<div class="section-header">
    <h1>Dashboard</h1>
</div>

<div class="section-body">
    <h2 class="section-title">Stok Produk</h2>
    <div class="row">
        @foreach ($produk as $item)
        <div class="col-lg-2 col-md-6 col-sm-6 col-12">
            <div class="card {{ ( $item->stock < 20 ) ? 'bg-danger' : ''}}">
                <div class="card-body text-center">
                    <h4>{{ $item->stock }}</h4>
                    <p>{{ $item->nama_produk }}</p>
                </div>
            </div>
        </div>
        @endforeach

    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4>List Data User</h4>
                </div> --}}
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Tenor</label>
                        <div class="selectgroup selectgroup-pills">
                            <label class="selectgroup-item">
                                <input type="radio" value="15 Hari" class="selectgroup-input" name="tenor">
                                <span class="selectgroup-button selectgroup-button-icon">15 Hari</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" value="30 Hari" class="selectgroup-input" name="tenor">
                                <span class="selectgroup-button selectgroup-button-icon">30 Hari</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" value="3 Bulan" class="selectgroup-input" name="tenor">
                                <span class="selectgroup-button selectgroup-button-icon">3 Bulan</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" value="6 Bulan" class="selectgroup-input" name="tenor">
                                <span class="selectgroup-button selectgroup-button-icon">6 Bulan</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" value="12 Bulan" class="selectgroup-input" name="tenor">
                                <span class="selectgroup-button selectgroup-button-icon">12 Bulan</span>
                            </label>
                        </div>
                    </div>

                    <form action="{{ route('report.pemasukan.filter') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="text" class="form-control datepicker" name="tanggal_mulai">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="text" class="form-control datepicker" name="tanggal_akhir">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-lg mt-4">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Pengeluaran --}}
    <h2 class="section-title">Pengeluaran</h2>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($pengeluaranHariIni, 0, '', '.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Bulan Ini</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($pengeluaranBulanIni, 0, '', '.') }}
                    </div>
                </div>
            </div>
        </div>


    </div>


    {{-- Pemasukan Hari Ini--}}
    <h2 class="section-title">Pemasukan Hari Ini</h2>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pembayaran Cash</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($penjualanCashHariIni, 0, '', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-arrow-alt-circle-up"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pembayaran Transfer</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($penjualanTransferHariIni, 0, '', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pembayaran Credit</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($penjualanCreditHariIni, 0, '', '.') }}
                    </div>
                </div>
            </div>
        </div>


    </div>


    {{-- Credit --}}
    <h2 class="section-title">Sisa Credit</h2>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Credit Lancar</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($creditLancar, 0, '', '.') }}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Credit Macet</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($creditMacet, 0, '', '.') }}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Credit Tidak Tertagih</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ number_format($creditTidakTertagih, 0, '', '.') }}
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>
@endsection
