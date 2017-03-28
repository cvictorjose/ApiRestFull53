<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHotelAvailabilityAddUniqueConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_availability', function (Blueprint $table){
            $table->unique(['hotel_id', 'room_type_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_availability', function (Blueprint $table){
            try{
                $table->dropUnique('hotel_availability_hotel_id_room_type_id_day_unique');
            }catch(\Exception $e){}
        });
    }
}
