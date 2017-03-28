<?php

use Illuminate\Database\Seeder;

class CartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cart')->delete();
        DB::statement("ALTER TABLE `cart` AUTO_INCREMENT = 1;");

        //for($i = 1; $i < 6; $i++) {
            App\Cart::create([
                'coupon_code_id' => rand(1, 3),
                'identity_id' => rand(1, 2),
                'session_id' => "Update me",
            ]);
        //}


        DB::table('cart_element')->delete();
        DB::statement("ALTER TABLE `cart_element` AUTO_INCREMENT = 1;");
        for($i = 1; $i < 3; $i++) {
            App\CartElement::create([
                'cart_id' => rand(1, 1),
                'product_id' => rand(1, 2),
                'identity_id' => rand(1, 2),
                'title' => "Cart Element #".$i,
                'price' => rand(10, 100),
            ]);
        }
    }
}
