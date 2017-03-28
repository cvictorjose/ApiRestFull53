<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWidgetAddImageDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('widget', function (Blueprint $table) {
            $table->string('image')->nullable()->after('coupon_id');
        });
        Schema::table('widget', function (Blueprint $table) {
            $table->string('document')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widget', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('document');
        });
    }
}
