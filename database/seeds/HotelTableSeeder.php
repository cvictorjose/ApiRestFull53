<?php

use Illuminate\Database\Seeder;
use \App\Hotel;

class HotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hotel::create([
            'title'         =>  'Hotel Palace',
            'stars'         =>  4,
            'address'       =>  'Via Campobello, 37, 00071 - Pomezia',
            'map'           =>  'https://goo.gl/maps/w7mxLhG2jqo',
            'distance_km'   =>  15,
            'distance_label'=>  '15 km, 17 minuti dal parco',
            'info'          =>  'Aria condizionata
Possibilità di aggiungere una culla
Balcone / terrazza
Pantofole
Accessori del bagno
Doccia
Complimentary Gym Access
Cassetta di sicurezza digitale
Asciugacapelli professionale
Minibar
Accesso consentito agli animali domestici',
            'pictures'      =>  'http://devel.cinecittaworld.gag.it/wp-content/uploads/2017/02/apertura-2017.jpg
http://lorempixel.com/150/100/city/2/
http://lorempixel.com/150/100/city/3/
http://lorempixel.com/150/100/city/4/
http://lorempixel.com/150/100/city/5/',
            'ticket_id'     =>  17,
        ]);
        Hotel::create([
            'title'         =>  'Hotel Sporting',
            'stars'         =>  4,
            'address'       =>  'Via Pontina km 30, 00071 - Pomezia',
            'map'           =>  'https://goo.gl/maps/w7mxLhG2jqo',
            'distance_km'   =>  10,
            'distance_label'=>  '10 km, 13 minuti dal parco',
            'info'          =>  'ingresso gratuito in piscina, presso Hotel Selene
parcheggio gratuito
ristorante con scelta menu à la carte o menu fisso presso Hotel Selene
utilizzo gratuito delle attrezzature sportive dell’hotel Selene con palestra e piscina
colazione obbligatoria € 2: cappuccino + cornetto
tassa di soggiorno a carico del cliente: 2 euro a persona a notte (0/10 anni esenti)',
            'pictures'      =>  'http://lorempixel.com/400/250/city/1/
http://lorempixel.com/150/100/city/6/
http://lorempixel.com/150/100/city/7/
http://lorempixel.com/150/100/city/8/
http://lorempixel.com/150/100/city/9/',
            'ticket_id'     =>  17,
        ]);
    }
}
