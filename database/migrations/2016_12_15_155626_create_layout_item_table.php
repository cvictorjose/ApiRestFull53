<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('layout_section_id')->length(10)->unsigned()->nullable();
            $table->foreign('layout_section_id')->references('id')->on('layout_section')
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
        Schema::drop('layout_item');
    }
}
