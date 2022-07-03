<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id')->unique();
            $table->foreign('order_id')->references('id')->on('orders')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('postman_id')->unique();
            $table->foreign('postman_id')->references('postman_id')->on('postmans')
                ->onUpdate('cascade');

            $table->set("status", ['ASSIGNED', "VENDOR_AT", "PICKED", "DELIVERED"]);
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
        Schema::dropIfExists('trips');
    }
}
