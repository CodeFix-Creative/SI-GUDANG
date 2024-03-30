@extends('layouts.template')

@section('pemasukan' , 'active')

@section('content')
<div class="section-header">
    <h1>Pemasukan</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            {{-- <a href="{{ route('transaksi-pemasukan.create') }}" class="btn btn-primary">Add New</a> --}}
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Pemasukan</h2>


    {{-- Content --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->nama_pelanggan }}</td>
                                    <td>
                                        <a href="{{ route('transaksi-pemasukan.form' , $data->id) }}" class="btn btn-primary">pilih</a>
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

    @push('modal')


    @endpush


    @endsection

    @push('script')
    <script>


    </script>
    @endpush
