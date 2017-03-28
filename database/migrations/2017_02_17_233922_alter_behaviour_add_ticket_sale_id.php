<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBehaviourAddTicketSaleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('behaviour', function (Blueprint $table) {
            $table->integer('ticket_sale_id')->unsigned()->nullable()->after('title');
        });
        Schema::table('behaviour', function (Blueprint $table) {
            $table->foreign('ticket_sale_id')->references('id')->on('ticket_sale')
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
        Schema::table('behaviour', function (Blueprint $table) {
            $table->dropForeign('behaviour_ticket_sale_id_foreign');
        });
        Schema::table('behaviour', function (Blueprint $table) {
            $table->dropColumn('ticket_sale_id');
        });
    }
}
