<?php

use Illuminate\Database\Seeder;
use App\Link;

class LinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Link::create([
            'title'  => 'Parco + Hotel',
            'price'  => 39,
            'url'    => 'http://www.gag.it',
        ]);
        Link::create([
            'title'  => 'Gruppi',
            'price'  => 19,
            'url'    => 'http://www.gag.it',
        ]);
        Link::create([
            'title'  => 'Scuole',
            'price'  => 12,
            'url'    => 'http://www.gag.it',
        ]);
    }
}
