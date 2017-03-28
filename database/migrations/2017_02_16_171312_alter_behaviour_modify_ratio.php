<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBehaviourModifyRatio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('behaviour', function (Blueprint $table) {
            $table->dropColumn('ratio');
        });
        Schema::table('behaviour', function (Blueprint $table) {
            $table->float('ratio', 6, 4)->after('attribute');
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
            $table->dropColumn('ratio');
        });
        Schema::table('behaviour', function (Blueprint $table) {
            $table->float('ratio')->after('attribute');
        });
    }
}
