<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLayoutCategoryModifyTypeEnumValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE layout_category MODIFY COLUMN type ENUM('service','ticket','ticket_visible','ticket_hidden')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE layout_category MODIFY COLUMN type ENUM('service','ticket_visible','ticket_hidden')");
    }

}
