@extends('layouts.template')

@section('pelanggan' , 'active')

@section('content')
<div class="section-header">
    <h1>Pelanggan</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Pelanggan</h2>


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
                                    <th>Kode Pelanggan</th>
                                    <th>Nama</th>
                                    <th>Toko</th>
                                    <th>Email</th>
                                    <th>Nomor Telephone</th>
                                    <th>Alamat</th>
                                    <th>Sales</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->kode_pelanggan }}</td>
                                    <td>{{ $data->nama_pelanggan }}</td>
                                    <td>{{ $data->toko }}</td>
                                    <td>
                                        {{ $data->email }}
                                    </td>
                                    <td>
                                        {{ $data->nomor_telephone }}
                                    </td>
                                    <td>
                                        {{ $data->alamat }}
                                    </td>
                                    <td>
                                        {{ $data->sales->user->nama }}
                                    </td>
                                    {{-- <td>
                                        @if ($data->status == "Aktif")
                                        <div class="badge badge-success">{{ $data->status }}</div>
                                        @else
                                        <div class="badge badge-danger">{{ $data->status }}</div>
                                        @endif
                                    </td> --}}
                                    <td>
                                      <a href="{{ route('pelanggan.edit' , $data->id) }}" class="btn btn-warning">Ubah</a>
                                      <form method="POST" action="{{ route('pelanggan.destroy' , $data->id) }}" id="delete" class="d-inline">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}

                                          <div class="d-inline">
                                              <input type="submit" class="btn btn-danger delete-user" value="Hapus">
                                          </div>
                                      </form>
                                      {{-- <a href="{{ route('pelanggan.destroy' , $data->id) }}" class="btn btn-danger">Hapus</a> --}}
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
