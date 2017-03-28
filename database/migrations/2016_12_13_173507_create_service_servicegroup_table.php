<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceServicegroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_service_group', function (Blueprint $table) {
            $table->increments('id');
            //$table->timestamps();

            $table->integer('service_id')->length(10)->unsigned()->nullable();
            $table->foreign('service_id')->references('id')->on('service')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('service_group_id')->length(10)->unsigned()->nullable();
            $table->foreign('service_group_id')->references('id')->on('service_group')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_service_group');
    }
}
