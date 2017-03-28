<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTicketsaleAddLayoutId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_sale', function (Blueprint $table) {
            if(!Schema::hasColumn('ticket_sale', 'layout_id')){
                $table->integer('layout_id')->unsigned()->nullable()->after('description');
                $table->foreign('layout_id')->references('id')->on('layout')
                    ->onDelete('set null')
                    ->onUpdate('set null');
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
        Schema::table('ticket_sale', function (Blueprint $table) {
            $table->dropForeign('ticket_sale_layout_id_foreign');
            $table->dropColumn('layout_id');
        });
    }
}
