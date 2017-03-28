<?php

use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Create Tickets_category records
        if(App\TicketCategory::count()<2)
            $this->call(TicketCategoryTableSeeder::class);

        DB::table('ticket')->delete();
        DB::statement("ALTER TABLE `ticket` AUTO_INCREMENT = 1;");
        // Create Tickets for each Rate
        foreach(App\Rate::all() as $rate){
            App\Ticket::create([
                'title' => sprintf("%s | %s ", $rate->description, $rate->rid_description),
                'description' => sprintf("Biglietto collegato a rid. %s", $rate->rid_code),
                'rate_id' => $rate->id,
                'ticket_category_id' => 1,
            ]);
        }

    }
}
