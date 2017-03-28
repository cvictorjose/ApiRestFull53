<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_section', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('layout_id')->length(10)->unsigned()->nullable();
            $table->foreign('layout_id')->references('id')->on('layout')
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
        Schema::drop('layout_section');
    }
}
