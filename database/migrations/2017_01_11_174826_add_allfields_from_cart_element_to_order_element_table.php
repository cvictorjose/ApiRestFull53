<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllfieldsFromCartElementToOrderElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_element', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->integer('price')->default('0')->after('title');

            $table->integer('identity_id')->length(10)->unsigned()->nullable()->after('price');
            $table->foreign('identity_id')->references('id')->on('identity')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('cart_id')->length(10)->unsigned()->nullable()->after('identity_id');
            $table->foreign('cart_id')->references('id')->on('cart')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('quantity')->default(1)->after('product_id');
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
            $table->dropColumn('title');
            $table->dropColumn('price');
            $table->dropColumn('identity_id');
            $table->dropColumn('quantity');
        });
    }
}
