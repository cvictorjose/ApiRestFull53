<?php

use Illuminate\Database\Seeder;
use App\LayoutCategory;

class LayoutCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LayoutCategory::create([
            'title'         =>  'Visibili',
            'description'   =>  'Biglietti visibili',
            'type'          =>  'ticket_visible',
        ]);
        LayoutCategory::create([
            'title'         =>  'Nascosti',
            'description'   =>  'Biglietti nascosti',
            'type'          =>  'ticket_hidden',
        ]);
        LayoutCategory::create([
            "title" => "Menu",
            "description" => "Prezzo speciale solo online",
            "icon"  => "http://devel.cinecittaworld.gag.it/wp-content/themes/cinecitta/core/images/biglietti/icon-b-menu.png",
            "type"  =>  "service",
        ]);

        LayoutCategory::create([
            "title" => "Arrivo al Parco",
            "description" => " ",
            "icon"  =>  "http://devel.cinecittaworld.gag.it/wp-content/themes/cinecitta/core/images/biglietti/icon-b-parcheggio.png",
            "type"  =>  "service",
        ]);
        LayoutCategory::create([
            "title" => "Servizi",
            "description" => " ",
            "icon"      =>  "http://devel.cinecittaworld.gag.it/wp-content/themes/cinecitta/core/images/biglietti/icon-b-servizi.png",
            "type"  =>  "service",
        ]);
    }
}
