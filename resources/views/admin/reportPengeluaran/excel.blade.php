<table>
    <thead>
        <tr class="font-weight-bold">
            <th>No</th>
            <th>Tanggal Transaksi</th>
            <th>Nama Pengeluaran</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Total Pengeluaran</th>
            <th>Admin</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        @php
        $nomor = 1;
        @endphp
        @foreach($data as $data)
        @php
          $count = $data->countDetailPengeluaran();
        @endphp
        <tr>
          <td rowspan="{{ $count }}" style="vertical-align: middle;">{{ $nomor }}</td>
          <td rowspan="{{ $count }}" style="vertical-align: middle;">{{ date('d-m-Y', strtotime($data->tanggal_transaksi))}}</td>
          @foreach ($data->dataDetailPengeluaran() as $item)
              @if ( $loop->iteration == 1)
              <td>{{ $item->nama_pengeluaran }}</td>
              <td style="text-align: right;" data-format="#,##0_-">{{ $item->harga }}</td>
              <td>{{ $item->jumlah }}</td>
              <td style="text-align: right;" data-format="#,##0_-">{{ $item->total_harga }}</td>
              @endif
          @endforeach
          <td style="text-align: right;vertical-align: middle;" data-format="#,##0_-" rowspan="{{ $count }}">{{ $data->total_transaksi }}</td>
          <td rowspan="{{ $count }}" style="vertical-align: middle;">{{ $data->user->nama }}</td>
          <td rowspan="{{ $count }}" style="vertical-align: middle;">{{ $data->note }}</td>
        </tr>
        
        @foreach ($data->dataDetailPengeluaran() as $item)
          @if ( $loop->iteration > 1)
          <tr>
              <td>{{ $item->nama_pengeluaran}}</td>
              <td style="text-align: right;" data-format="#,##0_-">{{ $item->harga }}</td>
              <td>{{ $item->jumlah }}</td>
              <td style="text-align: right;" data-format="#,##0_-">{{ $item->total_harga }}</td>
          </tr>
          @endif
        @endforeach

        
        @php
        $nomor++;
        @endphp
        @endforeach
    </tbody>
</table>
