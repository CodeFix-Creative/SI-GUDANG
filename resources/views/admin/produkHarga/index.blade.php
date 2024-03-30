@extends('layouts.template')

@section('produk-harga' , 'active')

@section('content')
<div class="section-header">
    <h1>Produk Harga</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            <a href="{{ route('produk-harga.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data produk Harga</h2>


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
                                    <th>Nama Produk</th>
                                    <th>Nama Pelanggan</th>
                                    <th>harga</th>
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
                                    <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                                    <td>Rp. {{ number_format($data->harga, 0, '', '.') }}</td>
                                    <td>
                                      <a href="{{ route('produk-harga.edit' , $data->id) }}" class="btn btn-warning">Ubah</a>
                                      <form method="POST" action="{{ route('produk-harga.destroy' , $data->id) }}" id="delete" class="d-inline">
                                          {{ csrf_field() }}
                                          {{ method_field('DELETE') }}

                                          <div class="d-inline">
                                              <input type="submit" class="btn btn-danger delete-user" value="Hapus">
                                          </div>
                                      </form>
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
