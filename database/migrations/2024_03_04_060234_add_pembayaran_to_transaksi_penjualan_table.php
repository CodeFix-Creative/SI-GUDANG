<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPembayaranToTransaksiPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_pemasukan', function (Blueprint $table) {
            $table->string("pembayaran");
            $table->string("bukti")->nullable();
            $table->string("tenor")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_pemasukan', function (Blueprint $table) {
            $table->dropColumn('pembayaran');
            $table->dropColumn('bukti');
            $table->dropColumn('tenor');
        });
    }
}
