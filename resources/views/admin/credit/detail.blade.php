@extends('layouts.template')

@section('credit' , 'active')

@section('content')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('credit.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Credit</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
          <a href="https://api.whatsapp.com/send?phone={{$hp}}" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i> Follow Up!</a>
          @if ($credit->status != 'Lunas')
          <a href="{{ route('credit.edit' , $credit->id) }}" class="btn btn-primary">Lunas</a>
          @endif
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Credit {{ $credit->pelanggan->nama_pelanggan }}</h2>


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
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Tanggal Di Bayar</th>
                                    <th>Total Bayar</th>
                                    <th>Last Updater</th>
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
                                    <td>{{ date('d/m/Y', strtotime($data->tanggal_jatuh_tempo)) }}</td>
                                    <td>
                                      @if ($data->tanggal_bayar != null)
                                      {{ date('d/m/Y', strtotime($data->tanggal_bayar)) }}
                                      @else
                                      -
                                      @endif
                                    
                                    </td>
                                    <td>Rp. {{ number_format($data->total_bayar, 0, '', '.') }}</td>
                                    <td>{{ $data->user->nama }}</td>
                                    <td>
                                        @if ($data->status == "Lunas")
                                        <div class="badge badge-success">{{ $data->status }}</div>
                                        @else
                                        <div class="badge badge-danger">{{ $data->status }}</div>
                                        @endif
                                    </td>
                                    <td>
                                      @if ($data->status != "Lunas")
                                      <a href="#!" class="btn btn-info detail-lunasi" data-toggle="modal" data-target="#detailLunasi" data-id="{{ $data->id }}">Lunasi</a>
                                      @else
                                      -
                                      @endif
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
<!-- Modal add -->
<div class="modal fade" id="detailLunasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabahdatalabel">Lunasi Credit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- FORM -->
            <form action="{{ route('lunas.detail') }}" method="post">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="id_detail_credit" id="id_detail_credit">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Bayar</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="date" class="form-control" name="tanggal_bayar">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top:none;">
                <button type="submit" class="btn btn-primary">Lunasi</button>
            </div>
            </form>
            <!-- /FORM -->
        </div>
    </div>
</div>
<!-- End Modal Edit -->
@endpush


@push('script')
<script>
  $('.detail-lunasi').on('click', function () {
      var id = $(this).data('id');
      $('#detailLunasi #id_detail_credit').val(id);
  });
</script>
@endpush


@endsection
