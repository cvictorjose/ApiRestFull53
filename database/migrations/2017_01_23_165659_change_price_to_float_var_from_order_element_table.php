<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceToFloatVarFromOrderElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        Schema::table('order_element', function (Blueprint $table) {
            try{
                $table->dropColumn('price');
            }catch(Exception $e){}
        });

        Schema::table('order_element', function (Blueprint $table) {
            $table->float('price')->default('0')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_element', function (Blueprint $table) {
            $table->integer('price')->default('0')->after('title');
        });
    }
}





