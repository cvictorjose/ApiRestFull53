<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTicketSaleAddTicketGroupIdAfterDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_sale', function (Blueprint $table){
            $table->integer('ticket_group_id')->nullable()->unsigned()->after('description');
            $table->foreign('ticket_group_id')->references('id')->on('ticket_group')
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
        Schema::table('ticket_sale', function (Blueprint $table){
            $table->dropColumn('ticket_group_id');
        });
    }
}
