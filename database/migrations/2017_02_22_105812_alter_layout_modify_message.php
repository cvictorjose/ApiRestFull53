<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLayoutModifyMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layout', function (Blueprint $table) {
            $table->dropColumn('message');
        });
        Schema::table('layout', function (Blueprint $table) {
            $table->text('message')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layout', function (Blueprint $table) {
            $table->dropColumn('message');
        });
        Schema::table('layout', function (Blueprint $table) {
            $table->string('message')->nullable()->after('title');
        });
    }
}
