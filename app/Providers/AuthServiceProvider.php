<?php

namespace App\Providers;

use App\TicketCategory;
use Laravel\Passport\Passport;
use App\Behaviour;
use App\BehaviourLayoutItem;
use App\Cart;
use App\Coupon;
use App\CouponCode;
use App\Customer;
use App\Hotel;
use App\HotelAvailability;
use App\Identity;
use App\Invoice;
use App\Layout;
use App\LayoutCategory;
use App\LayoutItem;
use App\LayoutSection;
use App\Link;
use App\Order;
use App\Payment;
use App\Product;
use App\RoomType;
use App\Session;
use App\Ticket;
use App\Rate;
use App\TicketSale;
use App\Service;
use App\ServiceCategory;
use App\Transaction;
use App\Widget;

use App\Policies\TicketPolicy;
use App\Policies\RatePolicy;
use App\Policies\TicketSalePolicy;
use App\Policies\ServicePolicy;
use App\Policies\ServiceCategoryPolicy;
use App\Policies\CouponPolicy;
use App\Policies\CouponCodePolicy;
use App\Policies\CartPolicy;
use App\Policies\OrderPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\HotelPolicy;
use App\Policies\HotelAvailabilityPolicy;
use App\Policies\LayoutPolicy;
use App\Policies\LayoutCategoryPolicy;
use App\Policies\LayoutItemPolicy;
use App\Policies\LayoutSectionPolicy;
use App\Policies\LinkPolicy;
use App\Policies\BehaviourPolicy;
use App\Policies\BehaviourLayoutItemPolicy;
use App\Policies\IdentityPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\TransactionPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RoomTypePolicy;
use App\Policies\SessionPolicy;
use App\Policies\RegulusPolicy;
use App\Policies\TicketCategoryPolicy;
use App\Policies\WidgetPolicy;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       // 'App\Model' => 'App\Policies\ModelPolicy',
        Ticket::class => TicketPolicy::class,
        Rate::class => RatePolicy::class,
        TicketSale::class => TicketSalePolicy::class,
        Service::class => ServicePolicy::class,
        ServiceCategory::class => ServiceCategoryPolicy::class,
        Coupon::class => CouponPolicy::class,
        CouponCode::class => CouponCodePolicy::class,
        Cart::class => CartPolicy::class,
        Order::class => OrderPolicy::class,
        Customer::class => CustomerPolicy::class,
        Hotel::class => HotelPolicy::class,
        HotelAvailability::class => HotelAvailabilityPolicy::class,
        Layout::class => LayoutPolicy::class,
        LayoutCategory::class => LayoutCategoryPolicy::class,
        LayoutItem::class => LayoutItemPolicy::class,
        LayoutSection::class => LayoutSectionPolicy::class,
        Link::class => LinkPolicy::class,
        Behaviour::class => BehaviourPolicy::class,
        BehaviourLayoutItem::class => BehaviourLayoutItemPolicy::class,
        Identity::class => IdentityPolicy::class,
        Invoice::class => InvoicePolicy::class,
        Transaction::class => TransactionPolicy::class,
        Payment::class => PaymentPolicy::class,
        Product::class => ProductPolicy::class,
        RoomType::class => RoomTypePolicy::class,
        Session::class => SessionPolicy::class,
        Rate::class => RegulusPolicy::class,
        TicketCategory::class => TicketCategoryPolicy::class,
        Widget::class => WidgetPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(15));

        /*$gate->before(function ($user) {
            if ($user->role === 'admin') {
                return true;
            }
        });*/
    }
}
