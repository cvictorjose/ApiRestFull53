<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableServiceMakeFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service', function (Blueprint $table) {
            try{
                $table->dropColumn('image');
            }catch(Exception $e){}
        });
        Schema::table('service', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
        });
        Schema::table('service', function (Blueprint $table) {
            try{
                $table->dropColumn('subtitle');
            }catch(Exception $e){}
        });
        Schema::table('service', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title');
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
            $table->dropColumn('image');
        });
        Schema::table('service', function (Blueprint $table) {
            $table->string('image')->after('description');
        });
        Schema::table('service', function (Blueprint $table) {
            $table->dropColumn('subtitle');
        });
        Schema::table('service', function (Blueprint $table) {
            $table->string('subtitle')->after('title');
        });
    }
}
