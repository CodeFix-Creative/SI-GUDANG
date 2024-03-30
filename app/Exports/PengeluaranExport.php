<?php

namespace App\Exports;
use App\Models\TransaksiPengeluaran;
use App\Models\DetailPengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengeluaranExport implements FromView , withTitle , ShouldAutoSize , WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $tanggal_awal;
    protected $tanggal_akhir;

    function __construct($tanggal_awal , $tanggal_akhir) {
      $this->tanggal_awal = $tanggal_awal;
      $this->tanggal_akhir = $tanggal_akhir;
    }

    public function view(): View
    {
         $data = TransaksiPengeluaran::whereBetween('tanggal_transaksi', [$this->tanggal_awal, $this->tanggal_akhir])->get();
         return view('admin.reportPengeluaran.excel', compact('data'));
    }

    public function title(): string
    {
        return 'Pengeluaran ';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
    }
}
