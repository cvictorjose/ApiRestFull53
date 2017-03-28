<?php

use Illuminate\Database\Seeder;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupon')->delete();
        DB::statement("ALTER TABLE `coupon` AUTO_INCREMENT = 1;");

        for($i = 1; $i < 6; $i++) {
            App\Coupon::create([
                'coupon' => "Coupon #".$i,
                "description" => "Description Coupon #".$i,
            ]);
        }
    }
}
