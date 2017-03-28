<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableLayoutSectionCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_section_category', function (Blueprint $table){
            $table->increments('id');
            $table->integer('layout_section_id')->unsigned();
            $table->foreign('layout_section_id')->references('id')->on('layout_section');
            $table->integer('layout_category_id')->unsigned();
            $table->foreign('layout_category_id')->references('id')->on('layout_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('layout_section_category');
    }
}
