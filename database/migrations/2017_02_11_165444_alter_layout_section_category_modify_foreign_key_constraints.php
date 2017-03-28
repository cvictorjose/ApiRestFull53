<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLayoutSectionCategoryModifyForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layout_section_category', function (Blueprint $table) {
            $table->dropForeign('layout_section_category_layout_category_id_foreign');
            $table->foreign('layout_category_id')->references('id')->on('layout_category')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->dropForeign('layout_section_category_layout_section_id_foreign');
            $table->foreign('layout_section_id')->references('id')->on('layout_section')
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
        Schema::table('layout_section_category', function (Blueprint $table) {
            $table->dropForeign('layout_section_category_layout_category_id_foreign');
            $table->foreign('layout_category_id')->references('id')->on('layout_category');
            $table->dropForeign('layout_section_category_layout_section_id_foreign');
            $table->foreign('layout_section_id')->references('id')->on('layout_section');
        });
    }
}
