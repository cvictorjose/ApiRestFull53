<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTicketAddLayoutItemId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket', function (Blueprint $table){
            if(!Schema::hasColumn('ticket', 'layout_item_id')){
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
        Schema::table('ticket', function (Blueprint $table){
            $table->dropForeign('ticket_layout_item_id_foreign');
            $table->dropColumn('layout_item_id');
        });
    }
}
