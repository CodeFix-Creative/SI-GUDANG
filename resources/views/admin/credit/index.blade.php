@extends('layouts.template')

@section('credit' , 'active')

@section('content')
<div class="section-header">
    <h1>Credit</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            {{-- <a href="{{ route('produk-masuk.create') }}" class="btn btn-primary">Add New</a> --}}
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Credit</h2>


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
                                    <th>Pelanggan</th>
                                    <th>Total Credit</th>
                                    <th>Tenor</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                                    <td>Rp. {{ number_format($data->total_credit, 0, '', '.') }}</td>
                                    <td>{{ $data->tenor }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_mulai)); }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_jatuh_tempo)); }}</td>
                                    <td>
                                        @if ($data->status == "Lunas")
                                        <div class="badge badge-success">{{ $data->status }}</div>
                                        @else
                                        <div class="badge badge-danger">{{ $data->status }}</div>
                                        @endif
                                    </td>
                                    <td>
                                      <a href="{{ route('credit.show' , $data->id) }}" class="btn btn-info">Detail</a>
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
@endsection
