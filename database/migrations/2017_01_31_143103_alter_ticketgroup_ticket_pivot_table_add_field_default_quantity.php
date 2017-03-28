<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketgroupTicketPivotTableAddFieldDefaultQuantity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_ticket_group', function (Blueprint $table) {
            $table->integer('default_quantity')->default('0')->after('ticket_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_ticket_group', function (Blueprint $table) {
            $table->dropColumn('default_quantity');
        });
    }
}
