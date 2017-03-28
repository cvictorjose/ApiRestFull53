<?php

use Illuminate\Database\Seeder;
use App\ServiceCategory;

class ServiceCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_category')->delete();
        DB::statement("ALTER TABLE `service_category` AUTO_INCREMENT = 1;");

        ServiceCategory::create([
            "title" => "Menu",
            "description" => "Prezzo speciale solo online",
        ]);

        ServiceCategory::create([
            "title" => "Arrivo al Parco",
            "description" => " ",
        ]);
        ServiceCategory::create([
            "title" => "Servizi",
            "description" => " ",
        ]);
    }
}
