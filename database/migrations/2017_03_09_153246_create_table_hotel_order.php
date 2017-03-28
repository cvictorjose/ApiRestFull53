<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHotelOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->length(10)->unsigned();
            $table->foreign('order_id')->references('id')->on('order')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('hotel_id')->length(10)->unsigned();
            $table->foreign('hotel_id')->references('id')->on('hotel')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('room_type_id')->length(10)->unsigned()->nullable();
            $table->foreign('room_type_id')->references('id')->on('room_type')
                ->onDelete('set null')
                ->onUpdate('set null');
            $table->integer('rooms'); // rooms quantity
            $table->integer('persons');
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
        Schema::drop('hotel_order');
    }
}
