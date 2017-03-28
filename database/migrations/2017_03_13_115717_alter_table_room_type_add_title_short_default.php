<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRoomTypeAddTitleShortDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_type', function (Blueprint $table){
            $table->string('title_short')->nullable();
            $table->integer('rooms_search_default')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_type', function (Blueprint $table){
            $table->dropColumn('title_short');
            $table->dropColumn('rooms_search_default');
        });
    }
}
