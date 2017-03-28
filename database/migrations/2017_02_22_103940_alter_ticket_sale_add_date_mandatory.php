<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketSaleAddDateMandatory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_sale', function (Blueprint $table) {
            $table->boolean('date_mandatory')->default(0)->after('layout_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_sale', function (Blueprint $table) {
            $table->dropColumn('date_mandatory');
        });
    }
}
