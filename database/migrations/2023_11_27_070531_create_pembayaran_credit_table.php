<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranCreditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_credit', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan');
            $table->string('id_credit');
            $table->string('id_user');
            $table->string('total_bayar');
            $table->date('tanggal_bayar')->nullable();
            $table->date('tanggal_jatuh_tempo');
            $table->string('status');
            $table->string('bukti')->nullable();
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
        Schema::dropIfExists('pembayaran_credit');
    }
}
