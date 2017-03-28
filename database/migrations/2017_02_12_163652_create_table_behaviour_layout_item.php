<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBehaviourLayoutItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behaviour_layout_item', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('behaviour_id')->length(10)->unsigned();
            $table->foreign('behaviour_id')->references('id')->on('behaviour')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('layout_item_id')->length(10)->unsigned();
            $table->foreign('layout_item_id')->references('id')->on('layout_item')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->enum('use', ['origin', 'destination']);

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
        Schema::drop('behaviour_layout_item');
    }
}
