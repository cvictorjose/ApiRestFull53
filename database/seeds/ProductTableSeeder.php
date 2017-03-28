<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->delete();
        DB::statement("ALTER TABLE `product` AUTO_INCREMENT = 1;");

        App\Product::create([
            'type' => 'ticket'

        ]);

        App\Product::create([
            'type' => 'service'
        ]);
    }
}
