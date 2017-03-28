<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCouponCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_code', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('description')->nullable();

            $table->integer('coupon_id')->length(10)->unsigned();
            $table->foreign('coupon_id')->references('id')->on('coupon')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('code');

            $table->dateTime('expiration_datetime');
            $table->integer('remaining_collections')->default(1);
            $table->timestamps();
        });
        Schema::table('cart', function (Blueprint $table) {
            $table->foreign('coupon_code_id')->references('id')->on('coupon_code')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
        DB::statement('SET SESSION sql_mode=\'ALLOW_INVALID_DATES\';');
        DB::statement('ALTER TABLE `order` MODIFY `visit_date` DATE NULL;');
        Schema::table('order', function (Blueprint $table) {
            $table->foreign('coupon_code_id')->references('id')->on('coupon_code')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropForeign('cart_coupon_code_id_foreign');
        });
        DB::statement('ALTER TABLE `order` MODIFY `visit_date` DATE NOT NULL;');
        Schema::table('order', function (Blueprint $table) {
            $table->dropForeign('order_coupon_code_id_foreign');
        });
        Schema::drop('coupon_code');
    }
}
