@extends('layouts.template')

@section('bonus' , 'active')

@section('content')
<div class="section-header">
    <h1>Bonus</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            <a href="{{ route('bonus.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Bonus</h2>


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
                                    <th>Aturan Bonus</th>
                                    <th>Keterangan</th>
                                    <th>Jenis Bonus</th>
                                    <th>Satuan</th>
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
                                    <td>{{ $data->produk->nama_produk }}</td>
                                    <td>{{ $data->aturan }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td>{{ $data->jenis_bonus }}</td>
                                    <td>{{ $data->satuan }}</td>
                                    <td>
                                        @if ($data->status == "Aktif")
                                        <div class="badge badge-success">{{ $data->status }}</div>
                                        @else
                                        <div class="badge badge-danger">{{ $data->status }}</div>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('bonus.edit' , $data->id) }}" class="btn btn-warning">Ubah</a></td>
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
