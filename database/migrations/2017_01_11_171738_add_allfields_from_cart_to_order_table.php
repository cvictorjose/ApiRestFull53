<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllfieldsFromCartToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {

            $table->integer('identity_id')->length(10)->unsigned()->nullable()->after('id');
            $table->foreign('identity_id')->references('id')->on('identity')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('session_id')->after('identity_id');

            $table->integer('coupon_code_id')->length(10)->unsigned()->nullable()->after('session_id');
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
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('identity_id');
            $table->dropColumn('session_id');
            $table->dropColumn('coupon_code_id');
        });
    }
}
