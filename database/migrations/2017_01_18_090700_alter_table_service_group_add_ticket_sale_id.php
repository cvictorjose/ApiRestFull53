<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableServiceGroupAddTicketSaleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_group', function (Blueprint $table) {
            $table->integer('ticket_sale_id')->unsigned()->nullable()->after('description');
                $table->foreign('ticket_sale_id')->references('id')->on('ticket_sale')
                    ->onDelete('set null')
                    ->onUpdate('set null');
            try{
                $table->dropForeign('service_group_service_id_foreign');
            }catch(Exception $e){}
            try{
                $table->dropColumn('service_id');
            }catch(Exception $e){}
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_group', function (Blueprint $table) {
            try{
                $table->dropForeign('service_group_ticket_sale_id_foreign');
            }catch(Exception $e){}
            $table->dropColumn('ticket_sale_id');
            $table->integer('service_id')->unsigned()->nullable()->after('description');
                $table->foreign('service_id')->references('id')->on('service')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }
}
