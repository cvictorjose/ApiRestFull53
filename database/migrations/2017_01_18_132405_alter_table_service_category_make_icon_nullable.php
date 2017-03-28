<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableServiceCategoryMakeIconNullable extends Migration
{
    public function up()
    {
        Schema::table('service_category', function (Blueprint $table) {
            try{
                $table->dropColumn('icon');
            }catch(Exception $e){}
        });
        Schema::table('service_category', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_category', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
        Schema::table('service_category', function (Blueprint $table) {
            $table->string('icon')->after('description');
        });
    }
}
