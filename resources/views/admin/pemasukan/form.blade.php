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
        <div class="col-7">
            <div class="card">
                {{-- <div class="card-header">
                    <h4>List Data User</h4>
                </div> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produk</th>
                                    <th>Harga (Rp)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Produk</th>
                                    <th>Harga (Rp)</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($produk as $barang)
                                <tr>
                                    <td>{{ $barang->produk->id }}</td>
                                    <td>{{ $barang->produk->nama_produk }}</td>
                                    <td class="text-right">{{ number_format($barang->harga, 0, '', '.') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if($barang->produk->stock < 1) <i class="text-danger">Stok telah habis.</i>
                                                @else
                                                <a href="#!" class="btn btn-success btn-sm ubah-data float-left"
                                                    data-toggle="modal" data-target="#editdata"
                                                    data-id="{{ $barang->produk->id }}"
                                                    data-nama-barang="{{ $barang->produk->nama_produk }}"
                                                    data-harga-barang="{{ $barang->harga }}"
                                                    data-stok="{{ $barang->produk->stock }}" data-qty="{{ $barang->produk->satuan }}"
                                                    data-status="{{ $barang->produk->status }}" data-token="{{csrf_token()}}"><i
                                                        class="fas fa-plus-circle"></i>
                                                    Tambah
                                                </a>
                                                @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- form pelanggan --}}
                            {{-- <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama Pelanggan"
                                    aria-label="Nama Pelaanggan" aria-describedby="basic-addon2" name="nama_pelanggan"
                                    required value="{{ old('nama_pelanggan') }}" id="nama_pelanggan" disabled>
                                <input type="hidden" id="id_pelanggan" name="id_pelanggan">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal"
                                        data-target="#pelanggan_popup"><i class="fas fa-search"></i> Sudah Ada</button>
                                </div>
                            </div> --}}

                            <div class="form-group">
                                <label>Pelanggan</label>
                                <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="{{ $pelanggan->id }}">
                                <input type="text" class="form-control" name="nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Sales</label>
                                <input type="hidden" id="id_sales" name="id_sales" value="{{ $sales->id }}">
                                <input type="text" class="form-control" name="nama_sales" value="{{ $sales->user->nama }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Transaksi</label>
                                <input type="text" class="form-control datepicker" name="tanggal_transaksi">
                            </div>

                            <table id="basic-datatables" class="display table table-striped table-hover cart">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Batal</th>
                                    </tr>
                                </thead>
                                <tbody id="list-cart-body">
                                    {{-- @dd(session()->get('Cart')) --}}
                                    @if( session()->has('Cart'))
                                    @php
                                    $cart = session()->get('Cart');
                                    $totalHarga = 0;
                                    // dd($cart);
                                    @endphp
                                    @foreach ($cart as $key => $cart)
                                    @if ($cart['id_pelanggan'] == $pelanggan->id)
                                      <tr class="list-cart" id="{{ $cart['id'] }}">
                                          <td>{{ $cart['nama_barang'] }}
                                              <input type="hidden" name="id_barang_{{ $cart['id'] }}"
                                                  value="{{ $cart['id'] }}">
                                          </td>
                                          <td id="jumlah-barang-cart">{{ $cart['jumlah'] }}
                                              <input type="hidden" name="jumlah_{{ $cart['id'] }}"
                                                  value="{{ $cart['jumlah'] }}">
                                              <input type="hidden" name="total_harga_{{ $cart['id'] }}"
                                                  value="{{ $cart['total'] }}">
                                          </td>
                                          <td>
                                              <a href="#!" class="btn btn-sm btn-danger hapus-cart"
                                                  data-id-hapus="{{ $cart['id'] }}"
                                                  data-url-hapus="{{ route('removeCart') }}"
                                                  data-token-hapus="{{ csrf_token() }}"
                                                  data-id-cart="{{ $cart['id'] }}"><i class="fas fa-times"></i></a>
                                          </td>
                                      </tr>
                                    @endif
                                    @php
                                    if ($cart['id_pelanggan'] == $pelanggan->id) {
                                      $totalHarga += $cart['total'];
                                    }
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
                    <div class="payment-methode">
                        <div class="section-title">Pilih Jenis Pembayaran</div>

                        <div class="form-group">
                            {{-- <label class="form-label">Size</label> --}}
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="jenis_pembayaran" value="Cash" class="selectgroup-input" id="cash">
                                    <span class="selectgroup-button">Cash</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="jenis_pembayaran" value="Transfer" class="selectgroup-input"
                                        id="transfer">
                                    <span class="selectgroup-button">Transfer</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="jenis_pembayaran" value="Credit" class="selectgroup-input" id="credit">
                                    <span class="selectgroup-button">Credit</span>
                                </label>
                            </div>
                        </div>

                        <div class="transfer-methode d-none">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Bukti Transfer</label>
                                <input class="form-control" type="file" id="formFile" name="bukti">
                            </div>
                        </div>

                        <div class="credit-methode d-none">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tenor</label>
                                    <div class="selectgroup selectgroup-pills">
                                        <label class="selectgroup-item">
                                            <input type="radio" value="15 Hari" class="selectgroup-input" name="tenor">
                                            <span class="selectgroup-button selectgroup-button-icon">15 Hari</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" value="30 Hari" class="selectgroup-input" name="tenor">
                                            <span class="selectgroup-button selectgroup-button-icon">30 Hari</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" value="3 Bulan" class="selectgroup-input" name="tenor">
                                            <span class="selectgroup-button selectgroup-button-icon">3 Bulan</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" value="6 Bulan" class="selectgroup-input" name="tenor">
                                            <span class="selectgroup-button selectgroup-button-icon">6 Bulan</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" value="12 Bulan" class="selectgroup-input" name="tenor">
                                            <span class="selectgroup-button selectgroup-button-icon">12 Bulan</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Start Credit</label>
                                    <input type="text" class="form-control datepicker" name="tanggal_start">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                          <label for="note">Note</label>
                          <textarea class="form-control" id="note" rows="7" name="note"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm float-right"><i
                                class="fas fa-cart-plus"></i>
                            Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modal')
    <!-- Modal add -->
    <div class="modal fade" id="editdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tabahdatalabel">Form Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- FORM -->
                {{-- <form id="edit-form"  method="post"> --}}
                <div class="modal-body">
                    @method('PUT')
                    @csrf
                    <table class="table">
                        <tr>
                            <td style="width: 25%;">Nama Produk </td>
                            <td id="nama-barang-table"></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">Harga </td>
                            <td id="harga-barang-table">Belanja</td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">Stok </td>
                            <td id="stok-barang-table">Belanja</td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">Jumlah Order</td>
                            <td id="jumlah-order">
                                <input type="number" class="form-control" id="jumlah-order-barang" name="jumlah" min="1"
                                    value="1" required style="height:35px !important;width :100px !important;">
                            </td>
                        </tr>
                    </table>

                    <!-- Nama Barang -->
                    <input type="hidden" class="form-control" id="id-barang" placeholder="Nama Barang" name="id"
                        required value="" readonly>

                    <!-- Nama Barang -->
                    <input type="hidden" class="form-control" id="nama-barang" placeholder="Nama Barang"
                        name="nama_barang" required value="" readonly>

                    <!-- Harga Barang -->
                    <input type="hidden" class="form-control" id="harga-barang" name="harga_barang" required>

                    <!-- Stok -->
                    <input type="hidden" class="form-control" id="stok" name="stok" min="1" required>

                    <!-- qty -->
                    <input type="hidden" class="form-control" id="qty" name="qty" required>
                </div>
                <div class="modal-footer" style="border-top:none;">
                    <button type="submit" class="btn btn-primary" id="tambah-cart"
                        data-token-tambah="{{ csrf_token() }}"
                        data-url-tambah="{{ route('addToCart') }}">Tambah</button>
                </div>
                {{-- </form> --}}
                <!-- /FORM -->
            </div>
        </div>
    </div>
    <!-- End Modal Edit -->


    {{-- <!-- Modal add -->
    <div class="modal fade bd-example-modal" id="pelanggan_popup" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tabahdatalabel">Daftar Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="pelanggan-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Toko</th>
                                <th>No Telp</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Toko</th>
                                <th>No Telp</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                            $nomor = 1;
                            @endphp
                            @foreach($pelanggan as $pelanggan)
                            <tr>
                                <td>{{ $nomor }}</td>
                                <td>{{ $pelanggan->nama_pelanggan }}</td>
                                <td>{{ $pelanggan->toko->nama_toko }}</td>
                                <td>{{ $pelanggan->nomor_telephone }}</td>
                                <td width="100">
                                    <div class="btn-group">
                                        <a href="#!" class="btn btn-success btn-sm pilih-pelanggan float-left"
                                            data-nama-pelanggan="{{ $pelanggan->nama_pelanggan }}" data-id-pelanggan="{{ $pelanggan->id }}"><i
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
<!-- End Modal Edit --> --}}

    @endpush


    @endsection

    @push('script')
    <script>
        $('#transfer').on('click', function () {
            $('.transfer-methode').removeClass('d-none');
            $('.credit-methode').addClass('d-none');
        });
        $('#credit').on('click', function () {
            $('.transfer-methode').addClass('d-none');
            $('.credit-methode').removeClass('d-none');
        });
        $('#cash').on('click', function () {
            $('.transfer-methode').addClass('d-none');
            $('.credit-methode').addClass('d-none');
        });

        // Modal Add Cart
        $('.ubah-data').on('click', function () {
            var id_barang = $(this).data('id');
            var nama_barang = $(this).data('nama-barang');
            var harga_barang = $(this).data('harga-barang');
            var stok = $(this).data('stok');
            var qty = $(this).data('qty');
            var status = $(this).data('status');
            var url = $(this).data('url');
            var token = $(this).data('token');
            var action = $('#editdata #edit-form').attr('action');
            action += '/' + id_barang;
            console.log(token);

            // table
            $('#nama-barang-table').html(nama_barang);
            $('#harga-barang-table').html(" Rp. " + harga_barang);
            $('#stok-barang-table').html(stok + " - " + qty);

            // form
            $('#editdata #edit-form').attr('action', action);
            $('#editdata #nama-barang').val(nama_barang);
            $('#editdata #id-barang').val(id_barang);
            $('#editdata #harga-barang').val(harga_barang);
            $('#editdata #stok').val(stok);
            $('#editdata #qty').val(qty);
            $('#editdata #status').val(status);

        });



        // Add Cart
        $('#tambah-cart').on('click', function () {
        var jumlah = $('#jumlah-order-barang').val();
        var id_barang = $('#id-barang').val();
        var nama_barang = $('#nama-barang').val();
        var harga_barang = $('#harga-barang').val();
        var token = $(this).data('token-tambah');
        var url = $(this).data('url-tambah');

        // console.log(id_barang_get);
        // ajax add cart
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                'id': id_barang,
                'nama_barang': nama_barang,
                '_token': token,
                'jumlah': jumlah,
                'harga': harga_barang,
                'id_pelanggan': {{ $pelanggan->id }},
            },
            success: function (data) {
                console.log(data);

                function convertToRupiah(angka) {
                    var rupiah = '';
                    var angkarev = angka.toString().split('').reverse().join('');
                    for (var i = 0; i < angkarev.length; i++)
                        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
                    return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
                }
                var totalHarga = convertToRupiah(data.total);
                // console.log(convertToRupiah(totalHarga));

                $('#total-harga-belanja').text(totalHarga);
                $('#total_order_form').val(data.total);
                $('.cart').load(document.URL + ' .cart');

                $('#editdata').modal('hide');
                toastr.success('Barang Berhasil di Tambahkan!');
            },
            error: function (data) {
                var res = data.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key, value) {
                        $('#error-stock')
                            .closest('#error-stock')
                            .addClass('has-error')
                            .append('<span class="help-block text-danger">' + value +
                                '</span>');
                    });
                }
            }
        });
    });

    $('.card-body').on('click', '.hapus-cart', function () {
        // console.log("KLIK");
        var id_cart = $(this).data('id-cart');
        var id_hapus = $(this).data('id-hapus');
        var url_hapus = $(this).data('url-hapus');
        var token = $(this).data('token-hapus');
        console.log(id_hapus);

        $.ajax({
            url: url_hapus,
            method: 'POST',
            data: {
                'id': id_hapus,
                'id_pelanggan': {{ $pelanggan->id }},
                '_token': token,
            },
            success: function (data) {
                $('tr#' + id_cart).remove();

                function convertToRupiah(angka) {
                    var rupiah = '';
                    var angkarev = angka.toString().split('').reverse().join('');
                    for (var i = 0; i < angkarev.length; i++)
                        if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
                    return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
                }
                var totalHarga = convertToRupiah(data.total);
                // console.log(convertToRupiah(totalHarga));

                $('#total-harga-belanja').text(totalHarga);
                $('#total_order_form').val(data.total);

                $('#editdata').modal('hide');
                toastr.success('Barang Berhasil di Hapus!');

            },
            error: function (data) {
                var res = data.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function (key, value) {
                        $('#error-stock')
                            .closest('#error-stock')
                            .addClass('has-error')
                            .append('<span class="help-block text-danger">' + value +
                                '</span>');
                    });
                }
            }
        });

    });


    $('.pilih-pelanggan').on('click',function(){
        var nama_pelanggan = $(this).data('nama-pelanggan');
        var id_pelanggan = $(this).data('id-pelanggan');

        $('#nama_pelanggan').val(nama_pelanggan);
        $('#id_pelanggan').val(id_pelanggan);
        $('#pelanggan_popup').modal('hide');
    });
                                                    
</script> 
@endpush
