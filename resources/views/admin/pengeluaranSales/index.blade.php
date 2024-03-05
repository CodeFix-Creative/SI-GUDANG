@extends('layouts.template')

@section('pengeluaran-sales' , 'active')

@section('content')
<div class="section-header">
    <h1>Pengeluaran Sales</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            {{-- <a href="{{ route('transaksi-pemasukan.create') }}" class="btn btn-primary">Add New</a> --}}
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Pengeluaran Sales</h2>


    {{-- Content --}}
    <div class="row">
        <div class="col-7">
            <div class="card">
                {{-- <div class="card-header">
                    <h4>List Data User</h4>
                </div> --}}
                <div class="card-body">
                    @php
                    $totalCart = rand(1,30);
                    @endphp
                    @if( session()->has('PengeluaranSales'))
                    @php
                    $cart = session()->get('PengeluaranSales');
                    @endphp
                    @foreach ($cart as $key => $cart)
                    @if ($cart['id'] == $totalCart)
                    @php
                        $totalCart = rand(1,30);
                    @endphp
                    @endif
                    @endforeach
                    @endif

                    <input type="hidden" name="id_pengeluaran" value="{{ $totalCart }}" id="urut_pengeluaran">

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Pengeluaran</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" name="nama_pengeluaran" id="nama_pengeluaran" required>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga (Rp)</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control" name="harga" id="harga" required>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Harga</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control" name="total_harga" id="total_harga" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-10">
                          <button type="submit" class="btn btn-success btn-sm float-right" id="tambah-cart" data-token-tambah="{{ csrf_token() }}"
                              data-url-tambah="{{ route('addCartPengeluaranSales') }}"><i class="fas fa-plus"></i>
                          Add Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="{{ route('checkoutPengeluaranSales') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- form sales --}}
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama Sales"
                                    aria-label="Nama Sales" aria-describedby="basic-addon2" name="nama_sales"
                                    required value="{{ old('nama_sales') }}" id="nama_sales" disabled>
                                <input type="hidden" id="id_sales" name="id_sales">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal"
                                        data-target="#sales_popup"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Transaksi</label>
                                <input type="text" class="form-control datepicker" name="tanggal_transaksi">
                            </div>

                            <table id="basic-datatables" class="display table table-striped table-hover cart">
                                <thead>
                                    <tr>
                                        <th>Pengeluaran</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Batal</th>
                                    </tr>
                                </thead>
                                <tbody id="list-cart-body">
                                    {{-- @dd(session()->get('Cart')) --}}
                                    @if( session()->has('PengeluaranSales'))
                                @php
                                $cart = session()->get('PengeluaranSales');
                                $totalHarga = 0;
                                @endphp
                                @foreach ($cart as $key => $cart)
                                <tr class="list-cart" id="{{ $cart['id'] }}">
                                    <td>{{ $cart['nama_pengeluaran'] }}
                                        <input type="hidden" name="nama_pengeluaran_{{ $cart['id'] }}"
                                            value="{{ $cart['nama_pengeluaran'] }}">
                                    </td>
                                    <td id="jumlah-barang-cart">{{ $cart['jumlah'] }}
                                        <input type="hidden" name="jumlah_{{ $cart['id'] }}"
                                            value="{{ $cart['jumlah'] }}">
                                    </td>

                                    <td id="harga-cart">{{ $cart['harga'] }}
                                        <input type="hidden" name="harga_{{ $cart['id'] }}"
                                            value="{{ $cart['harga'] }}">
                                        <input type="hidden" name="total_harga_{{ $cart['id'] }}"
                                            value="{{ $cart['total'] }}">
                                    </td>
                                    <td>
                                        <a href="#!" class="btn btn-sm btn-danger hapus-cart"
                                            data-id-hapus-pengeluaran="{{ $cart['id'] }}" data-url-hapus="{{ route('removeCartPengeluaranSales') }}"
                                            data-token-hapus="{{ csrf_token() }}" data-id-cart-pengeluaran="{{ $cart['id'] }}"><i
                                                class="fas fa-times"></i></a>
                                    </td>
                                </tr>
                                @php
                                $totalHarga += $cart['total'];
                                @endphp
                                @endforeach
                                @endif

                                @php
                                $totalHarga = !empty($totalHarga) ? $totalHarga : 0;
                                @endphp
                                </tbody>
                            </table>
                    </div>


                    <table id="table-checkout" class="display table table-striped table-hover mt-5">
                        <tr>
                            <td>Total Harga : </td>
                            <td id="total-harga-belanja">Rp. {{number_format($totalHarga,0,',','.')}}</td>
                        </tr>
                    </table>
                    <input type="hidden" name="total_order" id="total_order_form" value="{{$totalHarga}}">
                    
                    <button type="submit" class="btn btn-success btn-sm float-right" id="tambah-cart" data-token-tambah="{{ csrf_token() }}"
                    data-url-tambah="{{ route('addCartPengeluaranSales') }}"><i
                            class="fas fa-cart-plus"></i>
                        Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('modal')
    
    <!-- Modal add -->
    <div class="modal fade bd-example-modal" id="sales_popup" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tabahdatalabel">Daftar Sales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="pelanggan-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Sales</th>
                                <th>email</th>
                                <th>No Telp</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Sales</th>
                                <th>email</th>
                                <th>No Telp</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                            $nomor = 1;
                            @endphp
                            @foreach($sales as $sales)
                            <tr>
                                <td>{{ $nomor }}</td>
                                <td>{{ $sales->user->nama }}</td>
                                <td>{{ $sales->user->email }}</td>
                                <td>{{ $sales->nomor_telephone }}</td>
                                <td width="100">
                                    <div class="btn-group">
                                        <a href="#!" class="btn btn-success btn-sm pilih-sales float-left"
                                            data-nama-sales="{{ $sales->user->nama }}" data-id-sales="{{ $sales->id }}"><i
                                                class="fas fa-check"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @php
                            $nomor++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Edit -->

    

    @endpush


    @endsection

    @push('script')
    <script>
    
    $('#harga, #jumlah').change(function () {
        var harga = $('#harga').val();
        var jumlah = $('#jumlah').val();
        
        var total = (harga != null && jumlah != null) ? harga * jumlah : 0;

        $('#total_harga').val(total);
    });



    $('#tambah-cart').on('click', function () {
        var id_pengeluaran = $('#urut_pengeluaran').val();
        var nama_pengeluaran = $('#nama_pengeluaran').val();
        var harga = $('#harga').val();
        var jumlah = $('#jumlah').val();
        var total_harga = $('#total_harga').val();
        var token = $(this).data('token-tambah');
        var url = $(this).data('url-tambah');

        console.log(id_pengeluaran);
        // ajax add cart
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                'id': id_pengeluaran,
                'nama_pengeluaran': nama_pengeluaran,
                '_token': token,
                'jumlah': jumlah,
                'harga': harga,
                'total_harga': total_harga,
            },
            success: function (data) {
                // console.log(data.total);

                function convertToRupiah(angka) {
                    var rupiah = '';
                    var angkarev = angka.toString()
                        .split('').reverse().join('');
                    for (var i = 0; i < angkarev
                        .length; i++)
                        if (i % 3 == 0) rupiah +=
                            angkarev.substr(i, 3) + '.';
                    return 'Rp. ' + rupiah.split('',
                            rupiah.length - 1).reverse()
                        .join('');
                }
                var totalHarga = convertToRupiah(data
                    .total);
                console.log(data.idtotal);

                $('#total-harga-belanja').text(
                    totalHarga);
                $('#total_order_form').val(data.total);
                $('.cart').load(document.URL +
                    ' .cart');

                $('.cart').load(document.URL +
                    ' .cart');

                $('#urut_pengeluaran').val(data.idtotal);

                $('#editdata').modal('hide');
                // toastr.success(
                //     'Barang Berhasil di Tambahkan!');
            },
            error: function (data) {
                var res = data.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key,
                        value) {
                        $('#error-stock')
                            .closest(
                                '#error-stock')
                            .addClass(
                                'has-error')
                            .append(
                                '<span class="help-block text-danger">' +
                                value +
                                '</span>');
                    });
                }
            }
        });
    });


    $('.card-body').on('click', '.hapus-cart', function () {
        // console.log("KLIK");
        var id_cart = $(this).data('id-cart-pengeluaran');
        var id_hapus = $(this).data('id-hapus-pengeluaran');
        var url_hapus = $(this).data('url-hapus');
        var token = $(this).data('token-hapus');
        console.log(id_cart);

        $.ajax({
            url: url_hapus,
            method: 'POST',
            data: {
                'id': id_cart,
                '_token': token,
            },
            success: function (data) {
                console.log(data)
                $('tr#' + id_cart).remove();

                function convertToRupiah(angka) {
                    var rupiah = '';
                    var angkarev = angka.toString()
                        .split('').reverse().join('');
                    for (var i = 0; i < angkarev
                        .length; i++)
                        if (i % 3 == 0) rupiah +=
                            angkarev.substr(i, 3) + '.';
                    return 'Rp. ' + rupiah.split('',
                            rupiah.length - 1).reverse()
                        .join('');
                }
                var totalHarga = convertToRupiah(data
                    .total);
                console.log(convertToRupiah(totalHarga));

                $('#total-harga-belanja').text(
                    totalHarga);
                $('#total_order_form').val(data.total);

                // $('#editdata').modal('hide');
                // toastr.success(
                //     'Barang Berhasil di Hapus!');

            },
            error: function (data) {
                var res = data.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key,
                        value) {
                        $('#error-stock')
                            .closest(
                                '#error-stock')
                            .addClass(
                                'has-error')
                            .append(
                                '<span class="help-block text-danger">' +
                                value +
                                '</span>');
                    });
                }
            }
        });

    });

    $('.pilih-sales').on('click',function(){
        var nama_sales = $(this).data('nama-sales');
        var id_sales = $(this).data('id-sales');

        $('#nama_sales').val(nama_sales);
        $('#id_sales').val(id_sales);
        $('#sales_popup').modal('hide');
    });
                                                    
    </script> 
@endpush
