<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPivotTableTicketTicketGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_ticket_group', function(Blueprint $table){
            $table->renameColumn('ticketgroup_id', 'ticket_group_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_ticket_group', function(Blueprint $table){
            $table->renameColumn('ticket_group_id', 'ticketgroup_id');

        });
    }
}
