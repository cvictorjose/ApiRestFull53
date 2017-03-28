<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWidgetAddWidthHeightEmbedCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('widget', function (Blueprint $table){
            $table->string('width')->nullable()->after('document');
        });
        Schema::table('widget', function (Blueprint $table){
            $table->string('height')->nullable()->after('width');
        });
        Schema::table('widget', function (Blueprint $table){
            $table->text('embed_code')->nullable()->after('height');
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
            $table->dropColumn('width');
            $table->dropColumn('height');
            $table->dropColumn('embed_code');
        });
    }
}
