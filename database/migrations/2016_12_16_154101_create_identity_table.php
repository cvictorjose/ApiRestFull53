<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->length(10)->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customer')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('identity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('identity');
    }
}
