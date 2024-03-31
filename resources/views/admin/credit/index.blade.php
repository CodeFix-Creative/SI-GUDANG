@extends('layouts.template')

@section('credit' , 'active')

@section('content')
<div class="section-header">
    <h1>Credit</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            {{-- <a href="{{ route('produk-masuk.create') }}" class="btn btn-primary">Add New</a> --}}
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Credit</h2>


    {{-- Content --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4>List Data User</h4>
                </div> --}}
                <div class="card-body">
                  <form action="{{ route('credit.filter') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="text" class="form-control datepicker" name="tanggal_mulai">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="text" class="form-control datepicker" name="tanggal_akhir">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              <label for="status">Status</label>
                              <select class="form-control select2" id="status" name="status">
                                <option value="Semua" selected>Semua</option>
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                              <label for="status">Jenis Credit</label>
                              <select class="form-control select2" id="status" name="jenis_credit">
                                <option value="Semua" selected>Semua</option>
                                <option value="Lancar">Lancar</option>
                                <option value="Macet">Macet</option>
                                <option value="Tidak Tertagih">Tidak Tertagih</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary btn-lg mt-4">Filter</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
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
                                    <th>Invoice Transaksi</th>
                                    <th>Pelanggan</th>
                                    <th>Total Credit</th>
                                    <th>Tenor</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Jenis Credit</th>
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
                                    <td>{{ $data->transaksi->invoice}}</td>
                                    <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                                    <td>Rp. {{ number_format($data->total_credit, 0, '', '.') }}</td>
                                    <td>{{ $data->tenor }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_mulai)); }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_jatuh_tempo)); }}</td>
                                    <td>
                                        @if ($data->jenis_credit == 'Lancar')
                                          <a href="#!" data-toggle="modal" data-target="#jenis_popup" id="btn-edit" data-id="{{ $data->id }}" data-jenis-credit="{{ $data->jenis_credit }}">
                                            <div class="badge badge-primary">
                                                {{ $data->jenis_credit }}
                                            </div>
                                          </a>
                                        @elseif ($data->jenis_credit == 'Macet')
                                          <a href="#!" data-toggle="modal" data-target="#jenis_popup" id="btn-edit" data-id="{{ $data->id }}" data-jenis-credit="{{ $data->jenis_credit }}">
                                            <div class="badge badge-warning">
                                                {{ $data->jenis_credit }}
                                            </div>
                                          </a>
                                        @else
                                          <a href="#!" data-toggle="modal" data-target="#jenis_popup" id="btn-edit" data-id="{{ $data->id }}" data-jenis-credit="{{ $data->jenis_credit }}">
                                            <div class="badge badge-danger">
                                                {{ $data->jenis_credit }}
                                            </div>
                                          </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->status == "Lunas")
                                        <div class="badge badge-success">{{ $data->status }}</div>
                                        @else
                                        <div class="badge badge-danger">{{ $data->status }}</div>
                                        @endif
                                    </td>
                                    <td>
                                      <a href="{{ route('credit.show' , $data->id) }}" class="btn btn-info">Detail</a>
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

@push('modal')
<!-- Modal Tambah-->
<div class="modal fade bd-example-modal-lg" id="jenis_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabahdatalabel">Jenis Credit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- FORM -->
                <form action="{{ route('credit.jenis') }}" method="post">
                    @csrf
                      <input type="hidden" name="id" id="id-credit">
                      <div class="form-group">
                        {{-- <label for="edit-jenis">Jenis Credit</label> --}}
                        <select class="form-control" id="edit-jenis" name="jenis_credit">
                          <option value="Lancar">Lancar</option>
                          <option value="Macet">Macet</option>
                          <option value="Tidak Tertagih">Tidak Tertagih</option>
                        </select>
                      </div>  

            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
        </form>
        <!-- /FORM -->
    </div>
</div>
<!-- End Modal Tambah-->
@endpush

@push('script')
  <script>
     $('#btn-edit').on('click', function () {
        var id = $(this).data('id');
        var jenis_credit = $(this).data('jenis-credit');
        // console.log(jenis_credit);

        $('#jenis_popup #edit-jenis').val(jenis_credit);
        $('#jenis_popup #id-credit').val(id);
     });
  </script>
@endpush
