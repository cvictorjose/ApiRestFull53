<?php

use Illuminate\Database\Seeder;
use App\RoomType;

class RoomTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::create([
            'title'     =>  'Camere singole',
            'persons'   =>  1
        ]);
        RoomType::create([
            'title'     =>  'Camere doppie',
            'persons'   =>  2
        ]);
        RoomType::create([
            'title'     =>  'Camere triple',
            'persons'   =>  3
        ]);
        RoomType::create([
            'title'     =>  'Camere quadruple',
            'persons'   =>  4
        ]);
    }
}
