<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->timestamps();

            $table->integer('rate_id')->length(10)->unsigned()->nullable();
            $table->foreign('rate_id')->references('id')->on('rate')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('ticket_category_id')->length(10)->unsigned()->nullable();
            $table->foreign('ticket_category_id')->references('id')->on('ticket_category')
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
        Schema::drop('ticket');
    }
}
