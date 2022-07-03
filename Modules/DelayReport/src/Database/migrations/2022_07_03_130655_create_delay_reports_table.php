<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelayReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delay_reports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('agent_id');
            $table->foreign('agent_id')->references('id')->on('agents');

            $table->set("status", ['DELAY', "REVIEW", "PICKED", "PURSUED"])->default("DELAY");

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
        Schema::dropIfExists('delay_reports');
    }
}
