<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterServicegroupServicePivotTableAddFieldDefaultQuantity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_service_group', function (Blueprint $table) {
            $table->integer('default_quantity')->default('0')->after('service_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_service_group', function (Blueprint $table) {
            $table->dropColumn('default_quantity');
        });
    }
}
