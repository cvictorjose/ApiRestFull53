<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableLayoutItemDropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layout_item', function (Blueprint $table) {
            $table->dropForeign('layout_item_layout_section_id_foreign');
            $table->dropColumn('layout_section_id');
            $table->dropColumn('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layout_item', function (Blueprint $table){
            $table->string('title')->after('type');
            $table->integer('layout_section_id')->length(10)->unsigned()->nullable()->after('title');
            $table->foreign('layout_section_id')->references('id')->on('layout_section');
        });
    }
}
