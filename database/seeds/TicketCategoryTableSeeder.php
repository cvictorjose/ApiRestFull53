<?php

use Illuminate\Database\Seeder;

class TicketCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_category')->delete();
        DB::statement("ALTER TABLE `ticket_category` AUTO_INCREMENT = 1;"); 
        App\TicketCategory::create([
            'title'         =>  'Visibili',
            'description'   =>  'Biglietti visibili'
        ]);
        App\TicketCategory::create([
            'title'         =>  'Nascosti',
            'description'   =>  'Biglietti nascosti'
        ]);
    }

}
