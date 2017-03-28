<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLayoutSectionCategoryItemPivotTableAddDefaultQuantity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layout_section_category_item', function (Blueprint $table) {
            $table->integer('default_quantity')->default('0')->after('layout_item_id');
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
            $table->dropColumn('default_quantity');
        });
    }
}
