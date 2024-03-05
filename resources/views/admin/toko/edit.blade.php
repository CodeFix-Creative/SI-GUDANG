@extends('layouts.template')

@section('toko' , 'active')


@section('content')
<div class="section-header">
   {{-- back button --}}
    <div class="section-header-back">
        <a href="{{ route('toko.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                    <h4>Data Toko</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('toko.update' , $data->id) }}" enctype="multipart/form-data" method="post">
                     @method('PUT')
                     @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="nama" value="{{ $data->nama_toko }}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="email" class="form-control" name="email" value="{{ $data->email }}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor
                                Telephone<br><span style="color: #aeaeae;">( ex. 6281xxxx )</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" class="form-control" name="nomor_telephone" value="{{ $data->nomor_telephone }}">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" id="alamat" rows="3" name="alamat">{{ $data->alamat }}</textarea>
                            </div>
                        </div>
                        {{-- <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor
                                Telephone<br><span style="color: #aeaeae;">( ex. 6281xxxx )</span></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" class="form-control" name="nomor_telephone" value="{{ $data->nomor_telephone }}">
                            </div>
                        </div> --}}
                        {{-- <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Role</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="role">
                                    <option value="Admin" {{ ($data->role == 'Admin') ? 'selected' : '' }}>Admin</option>
                                    <option value="Sales" {{ ($data->role == 'Sales') ? 'selected' : '' }}>Sales</option>
                                    <option value="Super Admin" {{ ($data->role == 'Super Admin') ? 'selected' : '' }}>Super Admin</option>
                                </select>
                            </div>
                        </div> --}}
                        {{-- <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="status">
                                    <option value="Aktif" {{ ($data->status == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ ($data->status == 'Tidak Aktif') ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div> --}}
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
