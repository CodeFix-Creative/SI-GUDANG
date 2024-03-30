@extends('layouts.template')

{{-- @section('user' , 'active') --}}


@section('content')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Ubah Password</h1>
</div>

<div class="section-body">
    <h2 class="section-title">Ubah Password</h2>
    <p class="section-lead">
        Harap isi sesuai aturan
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('password.post') }}" enctype="multipart/form-data" method="post">
                     @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password lama</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="password" class="form-control" name="password_lama">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password Baru</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="password" class="form-control" name="password_baru">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Confirmasi Password Baru</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="password" class="form-control" name="confirm_password_baru">
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
