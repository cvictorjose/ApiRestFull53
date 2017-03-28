<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTicketgroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_ticket_group', function (Blueprint $table) {
            $table->increments('id');
            //$table->timestamps();

            $table->integer('ticketgroup_id')->length(10)->unsigned()->nullable();
            $table->foreign('ticketgroup_id')->references('id')->on('ticket_group')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('ticket_id')->length(10)->unsigned()->nullable();
            $table->foreign('ticket_id')->references('id')->on('ticket')
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
        Schema::drop('ticket_ticket_group');
    }
}
