<?php

use Illuminate\Database\Seeder;

class CouponCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.coupon_id
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupon_code')->delete();
        DB::statement("ALTER TABLE `coupon_code` AUTO_INCREMENT = 1;");

        for($i = 1; $i < 6; $i++) {
            App\CouponCode::create([
                'code' => "CodePromotion #".$i,
                "description" => "Description CodePromotion #".$i,
                'coupon_id' => rand(1, 5),
            ]);
        }
    }
}
