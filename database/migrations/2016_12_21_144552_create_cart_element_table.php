<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_element', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cart_id')->length(10)->unsigned()->nullable();
            $table->foreign('cart_id')->references('id')->on('cart')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('product_id')->length(10)->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('product')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::drop('cart_element');
    }
}
