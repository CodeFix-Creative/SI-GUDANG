@extends('layouts.template')

@section('bonus' , 'active')


@section('content')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('bonus.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                    <h4>Data Bonus</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bonus.store') }}" enctype="multipart/form-data" method="post">
                     @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Produk</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="id_produk">
                                    <option value="" disabled selected>Pilih produk</option>
                                    @foreach ($produk as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Aturan</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" id="aturan" rows="3" name="aturan"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" id="keterangan" rows="3" name="keterangan"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Bonus</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="jenis_bonus">
                                    <option value="" disabled selected>Pilih Jenis Bonus</option>
                                    <option value="Produk">Produk</option>
                                    <option value="Cashback">Cashback</option>
                                    <option value="Uang Cash">Uang Cash</option>
                                    <option value="Merchendise">Merchendise</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="satuan">
                                    <option value="" disabled selected>Pilih Satuan</option>
                                    <option value="Bal">Bal</option>
                                    <option value="Dus">Dus</option>
                                    <option value="Karton">Karton</option>
                                    <option value="Pcs">Pcs</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="status">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
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
