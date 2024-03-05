@extends('layouts.template')

@section('produk' , 'active')


@section('content')
<div class="section-header">
   {{-- back button --}}
    <div class="section-header-back">
        <a href="{{ route('produk.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Ubah Data</h1>
</div>

<div class="section-body">
    <h2 class="section-title">Ubah Data</h2>
    <p class="section-lead">
        Harap isi sesuai aturan
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Produk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.update' , $data->id) }}" enctype="multipart/form-data" method="post">
                     @method('PUT')
                     @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="nama" value="{{ $data->nama_produk }}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori Produk</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="id_kategori">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" {{ ($data->id_kategori == $item->id) ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Stok</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" min="0" class="form-control" name="stock" value="{{ $data->stock }}">
                            </div>
                        </div> --}}
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan Produk</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="satuan">
                                    <option value="" disabled selected>Pilih Satuan</option>
                                    <option value="Bal" {{ ($data->satuan == 'Bal') ? 'selected' : '' }}>Bal</option>
                                    <option value="Dus" {{ ($data->satuan == 'Dus') ? 'selected' : '' }}>Dus</option>
                                    <option value="Karton" {{ ($data->satuan == 'Karton') ? 'selected' : '' }}>Karton</option>
                                    <option value="Pcs" {{ ($data->satuan == 'Pcs') ? 'selected' : '' }}>Pcs</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" min="0" class="form-control" name="harga" value="{{ $data->harga }}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="status">
                                    <option value="Aktif" {{ ($data->status == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ ($data->status == 'Tidak Aktif') ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
