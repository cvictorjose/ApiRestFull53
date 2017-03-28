<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTicketSaleAddServiceGroupId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_sale', function (Blueprint $table) {
            $table->integer('service_group_id')->unsigned()->nullable()->after('ticket_group_id');
            $table->foreign('service_group_id')->references('id')->on('service_group')
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
        Schema::table('ticket_sale', function (Blueprint $table) {
            try{
                $table->dropForeign('ticket_sale_service_group_id_foreign');
            }catch(Exception $e){}
            $table->dropColumn('service_group_id');
        });
    }
}
