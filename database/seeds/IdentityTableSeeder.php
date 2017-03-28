<?php

use Illuminate\Database\Seeder;

class IdentityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('identity')->delete();
        DB::statement("ALTER TABLE `identity` AUTO_INCREMENT = 1;");

            App\Identity::create([
                'customer_id' => rand(1, 3),
                'type' => 'person',
                'name' => 'Victor',
                'surname' => 'Colmenares',
                'email' => 'victor@gag.it',
                'phone' => '00393335544784',
                'address' => 'Viale Aventino, 100',
                'postal_code' => '00153',
                'city' => 'Roma',
                'region' => 'Lazio',
                'country' => 'Italia',
                'company' => 'Gag Srl',
                'company_vat' => '1234567890'
            ]);

            App\Identity::create([
                'customer_id' => rand(1, 3),
                'type' => 'company',
                'name' => 'Flavio',
                'surname' => 'Gargiulo',
                'email' => 'flavio@gag.it',
                'phone' => '0039388754145',
                'city' => 'Anacapri',
                'address' => 'Via Roma, 130',
                'postal_code' => '00178',
                'region' => 'Campania',
                'country' => 'Italia',
                'company' => 'Gag Srl',
                'company_vat' => '1234567890'
            ]);

    }
}
