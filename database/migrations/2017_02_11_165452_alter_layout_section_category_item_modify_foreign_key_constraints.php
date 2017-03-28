<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLayoutSectionCategoryItemModifyForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layout_section_category_item', function (Blueprint $table) {
            $table->dropForeign('layout_section_category_item_layout_item_id_foreign');
            $table->foreign('layout_item_id')->references('id')->on('layout_item')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->dropForeign('layout_section_category_item_layout_section_category_id_foreign');
            $table->foreign('layout_section_category_id')->references('id')->on('layout_section_category')
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
        Schema::table('layout_section_category_item', function (Blueprint $table) {
            $table->dropForeign('layout_section_category_item_layout_item_id_foreign');
            $table->foreign('layout_item_id')->references('id')->on('layout_item');
            $table->dropForeign('layout_section_category_layout_section_id_foreign');
            $table->foreign('layout_section_category_id')->references('id')->on('layout_section_category');
        });
    }
}
