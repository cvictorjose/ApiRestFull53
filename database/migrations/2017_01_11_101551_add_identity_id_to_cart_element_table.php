<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdentityIdToCartElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_element', function (Blueprint $table) {
            $table->integer('identity_id')->length(10)->unsigned()->nullable()->after('id');
            $table->foreign('identity_id')->references('id')->on('identity')
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
        Schema::table('cart_element', function (Blueprint $table) {
            $table->dropColumn('identity_id');
        });
    }
}
