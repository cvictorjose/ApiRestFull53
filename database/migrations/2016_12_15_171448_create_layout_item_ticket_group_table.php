<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutItemTicketGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_item_ticket_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_group_id')->length(10)->unsigned()->nullable();
            $table->foreign('ticket_group_id')->references('id')->on('ticket_group')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('layout_item_ticket_group');
    }
}
