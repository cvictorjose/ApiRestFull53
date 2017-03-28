<?php

use Illuminate\Database\Seeder;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment')->delete();
        DB::statement("ALTER TABLE `payment` AUTO_INCREMENT = 1;");

        for($i = 1; $i < 2; $i++) {
            App\Payment::create([
                'payment' => "Payment #".$i,
                'order_id' => $i
            ]);
        }
    }
}
