<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodeTransactionToOrderElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_element', function (Blueprint $table) {
            $table->string('code_transaction')->nullable()->after('operazione_id');
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
            $table->dropColumn('code_transaction');
        });
    }
}
