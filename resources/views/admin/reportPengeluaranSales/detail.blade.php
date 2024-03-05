@extends('layouts.template')

@section('report-pengeluaran-sales' , 'active')

@section('content')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('report.pengeluaran.sales.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Report Pengeluaran</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            {{-- <a href="{{ route('produk-masuk.create') }}" class="btn btn-primary">Add New</a> --}}
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Report Pengeluaran Sales "{{ $parent->sales->user->nama }}" Tanggal {{ date('d/m/Y', strtotime($parent->tanggal_transaksi)) }}</h2>


    {{-- Content --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4>List Data User</h4>
                </div> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama Pengeluaran</th>
                                    <th>Tanggal transaksi</th>
                                    <th>Jumlah</th>
                                    <th>Harga Produk</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->nama_pengeluaran }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_transaksi)); }}</td>
                                    <td>{{ $data->jumlah }}</td>
                                    <td>Rp. {{ number_format($data->harga, 0, '', '.') }}</td>
                                    <td>Rp. {{ number_format($data->total_harga, 0, '', '.') }}</td>
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
@endsection
