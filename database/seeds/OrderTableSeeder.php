<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order')->delete();
        DB::statement("ALTER TABLE `order` AUTO_INCREMENT = 1;");

        //for($i = 1; $i < 6; $i++) {
            App\Order::create([
                'coupon_code_id' => rand(1, 3),
                'identity_id' => rand(1, 2),
                'session_id' => "Update me",
                'customer_id' => "1",
                'payment_id' => "149450",

            ]);
        //}


        DB::table('order_element')->delete();
        DB::statement("ALTER TABLE `order_element` AUTO_INCREMENT = 1;");

        for($i = 8; $i < 10; $i++) {
            App\OrderElement::create([
                'cart_id' => "1",
                'order_id' => "1",
                'product_id' => "1",
                'identity_id' => "1",
                'title' => "Order Element #".$i,
                'price' => rand(10, 100),
                'quantity' => "1",
                'operazione_id' => "3552".$i,
                'code_transaction' => "pub001io8ab"

            ]);
        }
    }
}
