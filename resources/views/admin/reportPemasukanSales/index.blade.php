@extends('layouts.template')

@section('report-pemasukan' , 'active')

@section('content')
<div class="section-header">
    <h1>Report Pemasukan</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            <a href="#!" class="btn btn-success" data-toggle="modal" data-target="#export"><i class="fas fa-download"></i> Export</a>
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Report Pemasukan</h2>


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
                                    <th>Pelanggan</th>
                                    <th>Total Transaksi</th>
                                    <th>Tanggal transaksi</th>
                                    <th>Pembayaran</th>
                                    <th>Bukti</th>
                                    <th>Tenor</th>
                                    <th>Updater</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                                    <td>Rp. {{ number_format($data->total_transaksi, 0, '', '.') }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_transaksi)); }}</td>
                                    <td>{{ $data->pembayaran }}</td>
                                    <td>
                                      @if ($data->bukti != null)
                                          <a href="{{ asset('storage/bukti/' . $data->bukti) }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary"><i class="fa fa-file"></i></a>
                                      @else
                                          -
                                      @endif
                                    </td>
                                    <td>
                                      @if ($data->tenor != null)
                                          {{ $data->tenor }}
                                      @else
                                          -
                                      @endif
                                    </td>
                                    <td>
                                      {{ $data->user->nama }}
                                    </td>
                                    <td>
                                      <a href="{{ route('report.pemasukan.sales.detail' , $data->id) }}" class="btn btn-info">Detail</a>
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

@push('modal')
<!-- Modal Tambah-->
<div class="modal fade bd-example-modal-lg" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabahdatalabel">Export</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- FORM -->
                <form action="{{ route('report.pemasukan.export') }}" method="post">
                    @csrf

                    <!-- Tanggal Awal -->
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="Date" class="form-control" id="tanggal_awal" placeholder="tanggal_awal"
                            name="tanggal_awal" required>
                    </div>

                    <!-- Tanggal Awal -->
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="Date" class="form-control" id="tanggal_akhir" placeholder="tanggal_akhir"
                            name="tanggal_akhir" required>
                    </div>

            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="submit" class="btn btn-primary">Export</button>
            </div>
        </div>
        </form>
        <!-- /FORM -->
    </div>
</div>
<!-- End Modal Tambah-->
@endpush
@endsection
