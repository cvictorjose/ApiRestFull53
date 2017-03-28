<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLayoutCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_category', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->enum('type', ['service', 'ticket_hidden', 'ticket_visible']);
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
        Schema::drop('layout_category');
    }
}
