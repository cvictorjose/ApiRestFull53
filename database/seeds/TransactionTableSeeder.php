<?php

use Illuminate\Database\Seeder;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('transaction')->delete();
        DB::statement("ALTER TABLE `transaction` AUTO_INCREMENT = 1;");

        for($i = 1; $i < 2; $i++) {
            App\Transaction::create([
                'transaction' => "Transaction #".$i,
                'payment_id' => $i
            ]);
        }
    }
}
