<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitlePriceToCartElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_element', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->integer('price')->default('0')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_element', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('price');
        });
    }
}
