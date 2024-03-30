<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_history', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan');
            $table->string('id_user');
            $table->string('id_bonus');
            $table->string('id_sales');
            $table->string('jumlah_bonus');
            $table->string('total_bonus');
            $table->date('tanggal_bonus');
            $table->string('status');
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
        Schema::dropIfExists('bonus_history');
    }
}
