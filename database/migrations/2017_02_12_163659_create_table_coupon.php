<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->enum('type', ['layout_switch_by_id', 'layout_switch_by_title', 'discount_fixed', 'discount_percent'])->nullable();

            $table->integer('ticket_sale_id')->length(10)->unsigned()->nullable();
            $table->foreign('ticket_sale_id')->references('id')->on('ticket_sale')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->integer('layout_id')->length(10)->unsigned()->nullable();
            $table->foreign('layout_id')->references('id')->on('layout')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->string('layout_title')->nullable();

            $table->integer('behaviour_id')->length(10)->unsigned()->nullable();
            $table->foreign('behaviour_id')->references('id')->on('behaviour')
                ->onDelete('set null')
                ->onUpdate('set null');

            $table->float('discount_fixed')->nullable();
            $table->float('discount_percent')->nullable();
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
        Schema::drop('coupon');
    }
}
