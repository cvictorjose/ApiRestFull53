<?php

use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('invoice')->delete();
        DB::statement("ALTER TABLE `invoice` AUTO_INCREMENT = 1;");

        for($i = 1; $i < 2; $i++) {
            App\Invoice::create([
                'invoice' => "Invoice #".$i,
                'payment_id' => 1
            ]);
        }
    }
}
