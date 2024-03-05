@extends('layouts.template')

@section('bonus-history' , 'active')

@section('content')
<div class="section-header">
    <h1>Bonus History</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            {{-- <a href="{{ route('bonus.create') }}" class="btn btn-primary">Add New</a> --}}
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Bonus History</h2>


    {{-- Content --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Masukan History Bonus</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bonus-history.store') }}" method="post">
                      @csrf
                      <div class="form-group row mb-4">
                          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pelanggan</label>
                          <div class="col-sm-12 col-md-7">
                              <select class="form-control select2" name="id_pelanggan">
                                  <option value="" disabled selected>Pilih Pelanggan</option>
                                  @foreach ($pelanggan as $item)
                                  <option value="{{ $item->id }}">{{ $item->nama_pelanggan }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
  
                      <div class="form-group row mb-4">
                          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bonus</label>
                          <div class="col-sm-12 col-md-7">
                              <select class="form-control select2" name="id_bonus">
                                  <option value="" disabled selected>Pilih Bonus</option>
                                  @foreach ($bonus as $item)
                                  <option value="{{ $item->id }}">{{ $item->produk->nama_produk }} - {{ $item->aturan }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
  
                      <div class="form-group row mb-4">
                          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">jumlah</label>
                          <div class="col-sm-12 col-md-7">
                              <input type="number" class="form-control" name="jumlah_bonus">
                          </div>
                      </div>
  
                      <div class="form-group row mb-4">
                          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Keluar</label>
                          <div class="col-sm-12 col-md-7">
                              <input type="text" class="form-control datepicker" name="tanggal_bonus">
                          </div>
                      </div>
  
                      <div class="form-group row mb-4">
                          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sales</label>
                          <div class="col-sm-12 col-md-7">
                              <select class="form-control select2" name="id_sales">
                                  <option value="" disabled selected>Pilih Sales</option>
                                  @foreach ($sales as $item)
                                  <option value="{{ $item->id }}">{{ $item->user->nama }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
  
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                                    <th>Bonus</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Sales</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                                    <td>{{ $data->bonus->produk->nama_produk }} - {{ $data->bonus->aturan }}</td>
                                    <td>{{ $data->jumlah_bonus }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_bonus)); }}</td>
                                    <td>{{ $data->sales->user->nama }}</td>
                                    {{-- <td><a href="{{ route('bonus.edit' , $data->id) }}" class="btn btn-warning">Ubah</a></td> --}}
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
