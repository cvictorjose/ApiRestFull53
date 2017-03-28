<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('turno_id');
            $table->string('description');
            $table->string('turno')->default("Libero");
            $table->integer('rid_id');
            $table->string('rid_code');
            $table->string('rid_description');
            $table->string('rid_riservataCoupon')->default(0)->nullable();
            $table->integer('prezzo')->default(0);
            $table->integer('prevendita')->default(0);
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
        Schema::drop('rate');
    }
}
