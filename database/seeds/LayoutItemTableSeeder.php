<?php

use Illuminate\Database\Seeder;
use \App\LayoutItem;
use \App\Ticket;
use \App\Service;

class LayoutItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('product')->count()==0){
            $this->call(ProductTableSeeder::class);
        }
        foreach (DB::table('product')->get() as $p){
            if(!LayoutItem::find($p->id)){
                DB::table('layout_item')->insert([
                    'id'    => $p->id,
                    'type'  => $p->type,
                ]);
            }
        }
        foreach(Ticket::all() as $t){
            $t->layout_item_id = $t->product_id;
            $t->save();
        }
        foreach(Service::all() as $s){
            $s->layout_item_id = $s->product_id;
            $s->save();
        }
    }
}
