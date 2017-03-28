<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHotelAvailabilityReal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_availability', function (Blueprint $table){
            $table->increments('id');
            $table->integer('hotel_id')->length(10)->unsigned();
            $table->foreign('hotel_id')->references('id')->on('hotel')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('room_type_id')->length(10)->unsigned()->nullable();
            $table->foreign('room_type_id')->references('id')->on('room_type')
                ->onDelete('set null')
                ->onUpdate('set null');
            $table->date('day');
            $table->integer('rooms'); // rooms quantity
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
        Schema::drop('hotel_availability');
    }
}
