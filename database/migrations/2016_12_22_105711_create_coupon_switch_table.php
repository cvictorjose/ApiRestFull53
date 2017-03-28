<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponSwitchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_switch', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_sale_id')->length(10)->unsigned()->nullable();
            $table->foreign('ticket_sale_id')->references('id')->on('ticket_sale')
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
        Schema::drop('coupon_switch');
    }
}

