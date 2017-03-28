<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsPersonCompanyToIdentityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('identity', function (Blueprint $table) {
            $table->string('name')->nullable()->after('type');
            $table->string('surname')->nullable()->after('name');;
            $table->string('email')->nullable()->after('surname');;
            $table->bigInteger('phone')->nullable()->after('email');;
            $table->string('address')->nullable()->after('phone');;
            $table->string('postal_code')->nullable()->after('address');;
            $table->string('city')->nullable()->after('postal_code');;
            $table->string('region')->nullable()->after('city');;
            $table->string('country')->nullable()->after('region');;
            $table->string('company')->nullable()->after('country');;
            $table->string('company_vat')->nullable()->after('company');;
            $table->string('picture')->nullable()->after('company_vat');;
            $table->dropColumn('identity');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('identity', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('surname');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('postal_code');
            $table->dropColumn('city');
            $table->dropColumn('region');
            $table->dropColumn('country');
            $table->dropColumn('company');
            $table->dropColumn('company_vat');
            $table->dropColumn('picture');
            $table->string('identity');
        });
    }
}
