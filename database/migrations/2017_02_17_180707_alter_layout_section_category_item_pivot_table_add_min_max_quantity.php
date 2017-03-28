<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLayoutSectionCategoryItemPivotTableAddMinMaxQuantity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layout_section_category_item', function (Blueprint $table) {
            $table->integer('min_quantity')->default('0')->after('default_quantity');
        });
        Schema::table('layout_section_category_item', function (Blueprint $table) {
            $table->integer('max_quantity')->default('999')->after('min_quantity');
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
            $table->dropColumn('min_quantity');
        });
        Schema::table('layout_section_category_item', function (Blueprint $table) {
            $table->dropColumn('max_quantity');
        });
    }
}
