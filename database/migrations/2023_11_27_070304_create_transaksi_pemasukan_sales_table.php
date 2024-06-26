<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPemasukanSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pemasukan_sales', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan');
            $table->string('id_user');
            $table->string('id_sales');
            $table->string('total_transaksi');
            $table->date('tanggal_transaksi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_pemasukan_sales');
    }
}
