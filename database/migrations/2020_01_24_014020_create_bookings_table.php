<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('meja_id')->index('meja_id_foreign');
            $table->integer('tarif_id')->index('tarif_id_foreign');
            $table->integer('user_id')->index('user_id_foreign');
            $table->date('tanggal_booking');
            $table->enum('status', array('done','cancel','waiting'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
