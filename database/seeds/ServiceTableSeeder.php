<?php

use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service')->delete();
        DB::statement("ALTER TABLE `service` AUTO_INCREMENT = 1;");
        

        $service_category_1_id  =   App\ServiceCategory::where('title', 'Menu')->first()->id;
        $service_category_2_id  =   App\ServiceCategory::where('title', 'Arrivo al Parco')->first()->id;
        $service_category_3_id  =   App\ServiceCategory::where('title', 'Servizi')->first()->id;
        App\Service::create([
            'title'                 => "Cestino",
            'description'           => "1 sandwich, 1 mela, 1 acqua 50cl",
            'price'                 => 5,
            'vat_rate'              => 4,
            'service_category_id'   => $service_category_1_id,
        ]);
        App\Service::create([
            'title'                 => "Cowboy",
            'description'           => "1 hot dog, patatine fritte medie, 1 bibita a scelta",
            'price'                 => 10,
            'vat_rate'              => 4,
            'service_category_id'   => $service_category_1_id,
        ]);
        App\Service::create([
            'title'                 => "Completo",
            'description'           => "1 hamburger, patatine fritte grandi, 1 gelato, 1 bibita a scelta",
            'price'                 => 10,
            'vat_rate'              => 4,
            'service_category_id'   => $service_category_1_id,
        ]);
        App\Service::create([
            'title'                 => "Parcheggio Auto",
            'description'           => "Valido fino a 30 minuti dopo l'orario di chiusura del parco",
            'price'                 => 5,
            'vat_rate'              => 22,
            'service_category_id'   => $service_category_2_id,
        ]);
        App\Service::create([
            'title'                 => "Navetta",
            'subtitle'              => "A/R da Roma Termini",
            'description'           => "Partenza da Roma Termini ore 9.45, ritorno ore 18.00",
            'price'                 => 10,
            'vat_rate'              => 22,
            'service_category_id'   => $service_category_2_id,
        ]);
        App\Service::create([
            'title'                 => "Saltacoda",
            'subtitle'              => "Accesso Star",
            'description'           => "Ingresso prioritario",
            'price'                 => 10,
            'vat_rate'              => 22,
            'service_category_id'   => $service_category_3_id,
        ]);
    }
}
