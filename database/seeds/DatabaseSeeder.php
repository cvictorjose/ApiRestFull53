<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


//        Model::unguard();
//        factory('App\Product', 5)->create();
//        Model::reguard();


        Eloquent::unguard();
        $this->call(ProductTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(RateTableSeeder::class);
        $this->call(TicketTableSeeder::class);
        $this->call(ServiceCategoryTableSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(TicketSaleTableSeeder::class);
        $this->call(CouponTableSeeder::class);
        $this->call(CouponCodeTableSeeder::class);
        $this->call(LayoutTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(IdentityTableSeeder::class);
        $this->call(CartTableSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(PaymentTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
        $this->call(InvoiceTableSeeder::class);


    }
}
