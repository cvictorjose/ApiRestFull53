<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('stars')->nullable();
            $table->string('address')->nullable();
            $table->string('map')->nullable();
            $table->float('distance_km')->nullable();
            $table->string('distance_label')->nullable();
            $table->text('info')->nullable();
            $table->text('pictures')->nullable();
            $table->integer('ticket_id')->length(10)->unsigned()->nullable();
            $table->foreign('ticket_id')->references('id')->on('ticket')
                ->onDelete('set null')
                ->onUpdate('set null');
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
        Schema::drop('hotel');
    }
}
