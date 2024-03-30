<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPemasukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pemasukan', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi');
            $table->string('id_produk');
            $table->string('jumlah');
            $table->date('tanggal_transaksi');
            $table->string('harga_produk');
            $table->string('total_harga');
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
        Schema::dropIfExists('detail_pemasukan');
    }
}
