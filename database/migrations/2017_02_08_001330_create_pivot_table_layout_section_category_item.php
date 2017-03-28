<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableLayoutSectionCategoryItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_section_category_item', function (Blueprint $table){
            $table->increments('id');
            $table->integer('layout_section_category_id')->unsigned();
            $table->foreign('layout_section_category_id')->references('id')->on('layout_section_category');
            $table->integer('layout_item_id')->unsigned();
            $table->foreign('layout_item_id')->references('id')->on('layout_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('layout_section_category_item');
    }
}
