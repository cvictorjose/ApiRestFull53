<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer')->delete();
        DB::statement("ALTER TABLE `customer` AUTO_INCREMENT = 1;");

        for($i = 1; $i < 6; $i++) {
            App\Customer::create([
                'customer' => "Customer #".$i,
            ]);
        }
    }
}
