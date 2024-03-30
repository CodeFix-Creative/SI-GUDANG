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
        <div class="col-2">
            <div class="card {{ ( $item->stock < 20 ) ? 'bg-danger' : ''}}">
                <div class="card-body text-center">
                    <h4>{{ $item->stock }}</h4>
                    <p>{{ $item->nama_produk }}</p>
                </div>
            </div>
        </div>
        @endforeach

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
