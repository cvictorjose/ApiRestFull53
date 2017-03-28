<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOperazioneIdToOrderElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_element', function (Blueprint $table) {
            $table->integer('operazione_id')->length(10)->unsigned()->nullable()->after('identity_id');
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
            $table->dropColumn('operazione_id');
        });
    }
}
