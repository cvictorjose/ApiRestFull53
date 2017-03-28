<?php

use Illuminate\Database\Seeder;
use App\Library;

class RateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $update_rate = new App\Library\TicketStore();
        $result = $update_rate->updateTickets();
    }
}
