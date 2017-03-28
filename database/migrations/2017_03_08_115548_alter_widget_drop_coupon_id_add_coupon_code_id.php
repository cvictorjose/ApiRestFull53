<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWidgetDropCouponIdAddCouponCodeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            Schema::table('widget', function (Blueprint $table) {
                $table->dropForeign('widget_coupon_id_foreign');
            });
        }catch(\Exception $e){}
        Schema::table('widget', function (Blueprint $table) {
            $table->dropColumn('coupon_id');
        });
        Schema::table('widget', function (Blueprint $table) {
            $table->integer('coupon_code_id')->length(10)->unsigned()->nullable()->after('description');
            $table->foreign('coupon_code_id')->references('id')->on('coupon_code')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widget', function (Blueprint $table) {
            $table->dropForeign('widget_coupon_code_id_foreign');
        });
        Schema::table('widget', function (Blueprint $table) {
            $table->dropColumn('coupon_code_id');
        });
        Schema::table('widget', function (Blueprint $table) {
            $table->integer('coupon_id')->length(10)->unsigned()->after('description');
            $table->foreign('coupon_id')->references('id')->on('coupon')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
