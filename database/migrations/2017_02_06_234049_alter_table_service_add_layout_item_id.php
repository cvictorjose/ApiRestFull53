<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableServiceAddLayoutItemId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service', function (Blueprint $table) {
            if(!Schema::hasColumn('service', 'layout_item_id')){
                $table->integer('layout_item_id')->unsigned()->nullable()->after('product_id');
                $table->foreign('layout_item_id')->references('id')->on('layout_item')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            }
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
            $table->dropColumn('layout_item_id');
        });
    }
}
