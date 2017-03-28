<?php

use Illuminate\Database\Seeder;

class LayoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('layout')->delete();
        DB::statement("ALTER TABLE `layout` AUTO_INCREMENT = 1;");
        for($i = 1; $i < 6; $i++) {
            App\Layout::create([
                'title' => "Template #".$i,
                'ticket_sale_id' => rand(1, 3),
            ]);
        }


        DB::table('layout_section')->delete();
        DB::statement("ALTER TABLE `layout_section` AUTO_INCREMENT = 1;");

        for($i = 1; $i < 10; $i++) {
            App\LayoutSection::create([
                'title' => "Section #".$i,
                'layout_id' => rand(1, 2),
            ]);
        }

        DB::table('layout_item')->delete();
        DB::statement("ALTER TABLE `layout_item` AUTO_INCREMENT = 1;");

        for($i = 1; $i < 10; $i++) {
            App\LayoutItem::create([
                'title' => "Item #".$i,
                'layout_section_id' => rand(1, 2),
            ]);
        }
    }
}
