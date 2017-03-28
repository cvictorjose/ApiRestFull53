<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePaymentMethodToOrderAsNullTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            try{
                $table->dropColumn('payment_method');
            }catch(Exception $e){}
        });
        Schema::table('order', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('payment_id');
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
            $table->string('payment_method')->after('payment_id');
        });
    }
}
