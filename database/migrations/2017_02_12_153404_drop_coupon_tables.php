<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCouponTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropForeign('cart_coupon_code_id_foreign');
        });
        Schema::table('order', function (Blueprint $table) {
            $table->dropForeign('order_coupon_code_id_foreign');
        });
        Schema::drop('coupon_code_general');
        Schema::drop('coupon_code_single');
        Schema::drop('coupon_subtract');
        Schema::drop('coupon_switch');
        Schema::table('coupon_code', function (Blueprint $table) {
            $table->dropForeign('coupon_code_coupon_id_foreign');
        });
        Schema::drop('coupon_code');
        Schema::drop('coupon');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('coupon_code', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_id')->length(10)->unsigned()->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupon')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('coupon_switch', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_sale_id')->length(10)->unsigned()->nullable();
            $table->foreign('ticket_sale_id')->references('id')->on('ticket_sale')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('coupon_subtract', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->length(10)->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('order')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('coupon_code_single', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_code_id')->length(10)->unsigned()->nullable();
            $table->foreign('coupon_code_id')->references('id')->on('coupon_code')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('coupon_code_general', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_code_id')->length(10)->unsigned()->nullable();
            $table->foreign('coupon_code_id')->references('id')->on('coupon_code')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::table('cart', function (Blueprint $table) {
            $table->foreign('coupon_code_id')->references('id')->on('coupon_code')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        Schema::table('order', function (Blueprint $table) {
            $table->foreign('coupon_code_id')->references('id')->on('coupon_code')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }
}
