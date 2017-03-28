<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterServiceLayoutItemIdConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service', function (Blueprint $table) {
            $table->dropForeign('service_layout_item_id_foreign');
        });
        Schema::table('service', function (Blueprint $table) {
            $table->foreign('layout_item_id')->references('id')->on('layout_item')
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service', function (Blueprint $table) {
            $table->dropForeign('service_layout_item_id_foreign');
        });
        Schema::table('service', function (Blueprint $table) {
            $table->foreign('layout_item_id')->references('id')->on('layout_item')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }
}
