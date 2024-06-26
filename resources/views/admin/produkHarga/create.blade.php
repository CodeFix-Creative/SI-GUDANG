@extends('layouts.template')

@section('produk-harga' , 'active')


@section('content')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('produk-harga.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Data</h1>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Data Baru</h2>
    <p class="section-lead">
        Harap isi sesuai aturan
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Produk Harga</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk-harga.store') }}" enctype="multipart/form-data" method="post">
                     @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Produk</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="id_produk">
                                    @foreach ($produk as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" min="0" class="form-control" name="harga">
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
