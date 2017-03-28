<?php

use Illuminate\Database\Seeder;
use App\TicketSale;
class TicketSaleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_sale')->delete();
        DB::statement("ALTER TABLE `ticket_sale` AUTO_INCREMENT = 1;");

        TicketSale::create([
            "title" => "Biglietteria Standard",
            "description" => "Description Biglietteria Standard",
        ]);

        TicketSale::create([
            'title' => 'Biglietteria Scuole',
            "description" => "Description Biglietteria Scuole",
        ]);
        TicketSale::create([
            'title' => 'Biglietteria Gruppi',
            "description" => "Description Biglietteria Gruppi",
        ]);
        TicketSale::create([
            'title' => 'Biglietteria Parco+Hotel',
            "description" => "Description Biglietteria Parco+Hotel",
        ]);
    }
}
