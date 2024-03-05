@extends('layouts.template')

@section('report-pemasukan' , 'active')

@section('content')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('report.pemasukan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Report Pemasukan</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            {{-- <a href="{{ route('produk-masuk.create') }}" class="btn btn-primary">Add New</a> --}}
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Report Pemasukan Tanggal {{ date('d/m/Y', strtotime($parent->tanggal_transaksi)); }} - {{ $parent->pelanggan->nama_pelanggan }}</h2>


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
                                    <th>Produk</th>
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
                                    <td>{{ $data->produk->nama_produk }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_transaksi)); }}</td>
                                    <td>{{ $data->jumlah }}</td>
                                    <td>Rp. {{ number_format($data->harga_produk, 0, '', '.') }}</td>
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
