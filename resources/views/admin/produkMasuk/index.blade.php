@extends('layouts.template')

@section('produk-masuk' , 'active')

@section('content')
<div class="section-header">
    <h1>Produk Masuk</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            <a href="{{ route('produk-masuk.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Produk Masuk</h2>


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
                                    <th>Suplier</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Admin</th>
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
                                    <td>{{ $data->suplier->nama_suplier }}</td>
                                    <td>{{ $data->jumlah }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_masuk)); }}</td>
                                    <td>{{ $data->user->nama }}</td>
                                    <td>
                                        @if ($data->status == "Pending")
                                        <div class="badge badge-warning">{{ $data->status }}</div>
                                        @elseif ($data->status == "Diterima")
                                        <div class="badge badge-success">{{ $data->status }}</div>
                                        @else
                                        <div class="badge badge-danger">{{ $data->status }}</div>
                                        @endif
                                    </td>
                                    <td>
                                      @if ($data->status == "Pending" && auth()->user()->role == 'Admin')
                                      <a href="{{ route('produk-masuk.edit' , $data->id) }}" class="btn btn-warning">Ubah</a>
                                      @endif
                                      @if ($data->status == "Pending" && auth()->user()->role == 'Super Admin')
                                      <a href="{{ route('produk-masuk.diterima' , $data->id) }}" class="btn btn-success" title="Diterima"><i class="fa fa-check"></i></a>
                                      <a href="{{ route('produk-masuk.ditolak' , $data->id) }}" class="btn btn-danger" title="Ditolak"><i class="fa fa-xmark"></i></a>
                                      @endif
                                      @if ($data->status == "Diterima" && auth()->user()->role == 'Super Admin')
                                      <form method="POST" action="{{ route('produk-masuk.destroy' , $data->id) }}" id="delete" class="d-inline">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}

                                          <div class="d-inline">
                                              <input type="submit" class="btn btn-danger delete-user" value="Hapus">
                                          </div>
                                      </form>
                                      @endif
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
