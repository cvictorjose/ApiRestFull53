<?php
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: content-type, laravel_session");

use Illuminate\Http\Request;

use App\OauthClient;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index');

//LOGIN
Route::post('login', array('uses' => 'Auth\LoginController@doLogin'));
Route::get('login', 'Auth\LoginController@loginStatus');
Route::get('logout', array('uses' => 'Auth\LoginController@logout'));

//REGULUS
Route::get('regulus', 'RegulusController@turniliberi');
Route::get('regulus/{id}', 'RegulusController@turnolibero');
Route::get('/regulus/coupon_check/{idTurnoLibero}/{couponCode}', 'RegulusController@couponCheck');
Route::get('/regulus/coupon_check/{idTurnoLibero}/{couponCode}/{ridCode}', 'RegulusController@couponCheckRate');
Route::post('/regulus/update_rates', 'RegulusController@updateRates');
Route::get('scaricaPdf/{id}/{subscription}', 'RegulusController@scaricaPdf');
Route::get('confermaPagamento/{id}', 'RegulusController@getPay');


//RATES
Route::resource('rates', 'RateController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

//TICKETS
Route::resource('tickets', 'TicketController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

Route::get('/tickets/rate/{id}', 'TicketRateController@index');
Route::get('/ticket/{id}/rate', 'TicketRateController@rateTicket');


//MULTI_TICKETS
Route::resource('multiTickets', 'TicketMultipleController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);



//TICKETSGROUPS
Route::resource('ticketgroups', 'TicketGroupController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

Route::get('/ticketgroups/{id}/tickets', 'TicketGroupController@getTickets');
Route::get('/ticketgroups/{id}/tickets/{ticket_id}', 'TicketGroupController@getTicket');
Route::post('/ticketgroups/{id}/tickets/{ticket_id}', 'TicketGroupController@addTicket');
Route::delete('/ticketgroups/{id}/tickets/{ticket_id}', 'TicketGroupController@deleteTicket');


//TICKETSALES
Route::resource('ticketsales', 'TicketSaleController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('/ticketsales/{id}/ticketgroups', 'TicketSaleController@getTicketGroups');
Route::get('/ticketsales/{id}/ticketgroup/{ticketgroup_id}', 'TicketSaleController@getTicketGroup');
Route::get('/ticketsales/{id}/tickets', 'TicketSaleController@getTickets'); // based on the currently active TicketGroup
Route::get('/ticketsales/{id}/services', 'TicketSaleController@getServices'); // based on the currently active ServiceGroup
Route::get('/ticketsales/{id}/layout', 'TicketSaleController@getLayout'); // based on the currently active Layout
Route::get('/ticketsales/{id}/behaviours', 'TicketSaleController@getBehaviours');


//SERVICES
Route::resource('services', 'ServiceController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);


//SERVICES_GROUPS
Route::resource('servicegroups', 'ServiceGroupController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

Route::get('/servicegroups/{id}/services', 'ServiceGroupController@getServices');
Route::get('/servicegroups/{id}/services/{service_id}', 'ServiceGroupController@getService');
Route::post('/servicegroups/{id}/services/{service_id}', 'ServiceGroupController@addService');
Route::delete('/servicegroups/{id}/services/{service_id}', 'ServiceGroupController@deleteService');

//SERVICES_CATEGORY
Route::resource('servicecategories', 'ServiceCategoryController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('/category/{id}/services', 'ServiceCategoryController@getServices');

//TICKET_CATEGORY
Route::resource('ticketcategories', 'TicketCategoryController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('/category/{id}/tickets', 'TicketCategoryController@getTickets');


//COUPON_CODE
Route::resource('coupons', 'CouponController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('/coupon/{id}/couponscodes', 'CouponController@getCouponCodes');

//COUPON_CODE
Route::resource('coupon_codes', 'CouponCodeController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

// Links
Route::resource('links', 'LinkController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

//CouponCodeGeneral
Route::resource('couponcodegeneral', 'CouponCodeGeneralController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

//CouponCodeSingle
Route::resource('couponcodesingle', 'CouponCodeSingleController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

//CART
Route::resource('carts', 'CartController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('cart', 'CartController@showCurrent');
Route::post('cart', 'CartController@updateCurrent');
Route::post('cart/bind_identities', 'CartController@bindIdentities');
Route::post('cart/bind_coupon_code', 'CartController@bindCouponCode');
Route::post('cart/remove_bound_coupon_code', 'CartController@removeBoundCouponCode');

//LAYOUT
Route::get('/layout_items', 'LayoutItemController@index');

Route::resource('layouts', 'LayoutController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('/layouts/{id}/layout_sections', 'LayoutController@getLayoutSections');
Route::get('/layouts/{id}/layout_categories', 'LayoutController@getLayoutCategories');
Route::get('/layouts/{id}/layout_section_categories', 'LayoutController@getLayoutSectionCategories');
Route::post('/layouts/{id}/duplicate', 'LayoutController@duplicate');

Route::resource('layout_sections', 'LayoutSectionController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('/layout_sections/{id}/layout_categories', 'LayoutSectionController@getLayoutCategories');
Route::post('/layout_sections/{id}/layout_categories/{layout_category_id}', 'LayoutSectionController@addLayoutCategory');
Route::delete('/layout_sections/{id}/layout_categories/{layout_category_id}', 'LayoutSectionController@deleteLayoutCategory');

Route::resource('layout_categories', 'LayoutCategoryController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

Route::get('/layout_section_categories', 'LayoutSectionCategoryController@index');
Route::get('/layout_section_categories/{id}/layout_items', 'LayoutSectionCategoryController@getLayoutItems');
Route::post('/layout_section_categories/{id}/layout_items/{layout_item_id}', 'LayoutSectionCategoryController@addLayoutItem');
Route::delete('/layout_section_categories/{id}/layout_items/{layout_item_id}', 'LayoutSectionCategoryController@deleteLayoutItem');

// Route::get('/ticketsale/{id}/layouts', 'LayoutController@getLayout');
// Route::get('/ticketsale/{id}/layouts/{layout_id}/sections', 'LayoutController@getSections');
// Route::get('/ticketsale/{id}/layouts/{layout_id}/sections/{section_id}/items', 'LayoutController@getItems');
// Route::get('/ticketsale/{id}/layouts/{layout_id}/sections/{section_id}/items/{item_id}', 'LayoutController@getItemsValue');

//WIDGET
Route::resource('widgets', 'WidgetController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
//Route::get('widget/{title}', 'WidgetController@showByTitle');
Route::get('widget/{code}', 'WidgetController@showByCode');

//HOTEL
Route::resource('hotels', 'HotelController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('hotels_with_availability', 'HotelAvailabilityController@availableHotels');

//ROOMTYPES
Route::resource('room_types', 'RoomTypeController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

//HOTELAVAILABILITY
Route::get('hotel/{hotel_id}/availability/{year}', 'HotelAvailabilityController@index_By_Year_Hotel');
Route::get('hotel/{hotel_id}/availability/{year}/room_type/{room_type_id}', 'HotelAvailabilityController@index_By_Year_Hotel');
Route::get('hotel/{hotel_id}/availability/{year}/daykeyed', 'HotelAvailabilityController@index_By_Year_Hotel_DayKeyed');
Route::post('hotel/{hotel_id}/availability/{year}/room_type/{room_type_id}', 'HotelAvailabilityController@store_By_Year_Hotel_RoomType');
Route::post('hotel/{hotel_id}/availability', 'HotelAvailabilityController@store_By_Hotel_DateRange');
Route::get('hotel/{hotel_id}/sold_rooms/{year}', 'HotelAvailabilityController@index_SoldRooms_By_Year_Hotel');
Route::get('hotel/{hotel_id}/sold_rooms/{year}/room_type/{room_type_id}', 'HotelAvailabilityController@index_SoldRooms_By_Year_Hotel');

//ORDER
Route::resource('orders', 'OrderController',
    ['only' => ['index', 'show']]);
Route::get('/orders/{id}/transactions', 'OrderController@getTransactions');
Route::get('/orders/{id}/transactions/{transaction_id}', 'OrderController@getTransaction');

Route::get('/orders/{id}/invoices', 'OrderController@getInvoices');
Route::get('/orders/{id}/invoices/{invoice_id}', 'OrderController@getInvoice');
Route::get('/orders/idOperazione/{orderid}', 'OrderController@getIdOperazione');

// Order logics
Route::post('/order/place', 'OrderController@place');
Route::post('/order/pay', 'OrderController@payCurrent');
Route::post('/orders/{id}/pay', 'OrderController@pay');
//Route::get('/payment/{method}/{outcome}', 'OrderController@paymentOutcome');
Route::get('/payment/{method}/{outcome}/{order_id?}', 'OrderController@paymentOutcome');
Route::get('/payment2/{method}/{outcome}/{order_id?}', 'OrderController@paymentOutcome');
Route::post('/payment/{method}/{outcome}', 'OrderController@paymentOutcome');
Route::get('/payment/paypal', function(){ include('../app/Library/PaymentMethods/paypal/index.php'); });



//CUSTOMER
Route::resource('customers', 'CustomerController',
    ['only' => ['index', 'show']]);


//BEHAVIOUR
Route::resource('behaviours', 'BehaviourController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::resource('behaviour_layout_items', 'BehaviourLayoutItemController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

//IDENTITY
Route::resource('identities', 'IdentityController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

//INVOICE
Route::get('invoices', 'InvoiceController@index');

//PAYMENT
Route::get('payments', 'PaymentController@index');

//TRANSACTION
Route::get('transactions', 'TransactionController@index');

//PRODUCT
Route::resource('products', 'ProductController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

//SESSION
Route::resource('sessions', 'SessionController',
    ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::get('schema', 'SchemaController@describeAll');

//SCHEMA
Route::get('schema/{entity}', 'SchemaController@describeEntity');
Route::get('schema', 'SchemaController@describeAll');


//REGISTER + TOKEN PASSPORT
Route::post('/register', function (Request $request) {

    $name     = $request->input('name');
    $email    = $request->input('email');
    $password = $request->input('password');

    // save new user
    $user = \App\User::create([
        'name'     => $name,
        'email'    => $email,
        'password' => bcrypt($password),
        'api_token' => str_random(60),
    ]);

    // create token  client
    $token = $user->createToken('CCW')->accessToken;


    /*// create oauth client
    $oauth_client = \App\OauthClient::create([
        'user_id'                => $user->id,
        'id'                     => $email,
        'name'                   => $name,
        'secret'                 => base64_encode(hash_hmac('sha256',$password, 'secret', true)),
        'password_client'        => 1,
        'personal_access_client' => 0,
        'redirect'               => '',
        'revoked'                => 0,
    ]);*/


    return [
        'message' => 'user successfully created','token' =>$token
    ];
});

//PDF
Route::get('getOrderElementPdf/{order_element_id}', 'PdfController@getOrderElementPdf');
Route::get('order/{order_id}/tickets',  'PdfController@getOrderPdf');
Route::get('order/{order_id}/invoice',  'PdfController@getInvoicePdf');
Route::get('order/{order_id}/summary',  'PdfController@getSummaryPdf');
Route::get('order/{order_id}/all',      'PdfController@getAllPdf');
Route::get('order/{order_id}/services', 'PdfController@getServicePdf');
Route::get('/download/order/{id}', 'OrderController@getDownload');
Route::get('/download/order_barcode/{barcode}', 'OrderController@getDownloadByBarcode');


// Artisan commands
Route::get('/clear-cache', function(){
    $exitCode = Artisan::call('cache:clear');
    dd(Artisan::output());
    return $exitCode;
});
Route::get('/run-migrations', function(){
    $exitCode = Artisan::call('migrate');
    dd(Artisan::output());
    return $exitCode;
});
Route::post('/reseed', function(){
    //Artisan::call('db:seed', ['--class'   => 'TicketTableSeeder']);
    //dd(Artisan::output());

    //Artisan::call('db:seed', ['--class'   => 'ServiceCategoryTableSeeder']);
    //dd(Artisan::output());

    //Artisan::call('db:seed', ['--class'   => 'ServiceTableSeeder']);
    //dd(Artisan::output());

});

Route::post('/seed_all', function(){
    $exitCode =  Artisan::call('db:seed');
    dd(Artisan::output());
});

Route::post('/seed_layout', function(){

    Artisan::call('db:seed', ['--class'   => 'LinkTableSeeder']);
    dd(Artisan::output());

    Artisan::call('db:seed', ['--class'   => 'LayoutCategoryTableSeeder']);
    dd(Artisan::output());

});

Route::post('/clean_orphaned_layout_items', function(){
    foreach(\App\LayoutItem::all() as $layout_item){
        if(
            \App\Ticket::where('layout_item_id', $layout_item->id)->count() == 0 &&
            \App\Service::where('layout_item_id', $layout_item->id)->count() == 0 &&
            \App\Link::where('layout_item_id', $layout_item->id)->count() == 0 ){
                $layout_item->delete();
        }
    }
    return json_encode(array('data'=>'Cleaned', 'code'=>200));
});

Route::post('/seed_missing_layout_items', function(){
    foreach(\App\Ticket::all() as $e){
        if(!(\App\LayoutItem::find($e->layout_item_id))){
            $l = \App\LayoutItem::create(['type'=>'ticket']);
            $e->layout_item_id = $l->id;
            $e->save();
        }
    }
    foreach(\App\Service::all() as $e){
        if(!(\App\LayoutItem::find($e->layout_item_id))){
            $l = \App\LayoutItem::create(['type'=>'service']);
            $e->layout_item_id = $l->id;
            $e->save();
        }
    }
    foreach(\App\Link::all() as $e){
        if(!(\App\LayoutItem::find($e->layout_item_id))){
            $l = \App\LayoutItem::create(['type'=>'link']);
            $e->layout_item_id = $l->id;
            $e->save();
        }
    }
    return json_encode(array('data'=>'Seeded', 'code'=>200));
});

//Test Version
Route::group(['prefix' => 'v1'], function () {
    route::get('upper/{word}', function ($word){
        return ['testv1'=> $word, 'upper'=> strtoupper($word)];
    });
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/user/{id}', function (Request $request,$id) {
    $user = App\User::find($id);
    $token = $user->createToken('Token Name')->accessToken;
    return $token;
})->middleware('auth:api');

//Test BarCode generation
Route::get('barcode/{id}', 'BarCodeController@index');

//Test send confirm purchase email
Route::get('send/{id}', 'OrderController@send');


// Test order confirmation email
Route::get('/test_email_order/{order_id}', function($order_id){
    $order = \App\Order::find(intval($order_id));
    $identity = \App\Identity::find($order->identity_id);
    $carrello = \App\OrderElement::where('order_id',$order_id)->get();
    $order_elements = json_decode($carrello, true);
    $ticket=0; $service=0;
    foreach ($order_elements as $key => $value) {
        if (empty($value['operazione_id'])){ $service=1;}else{$ticket=1;}
    }
    return view('emails.order_confirmation', ['identity' => $identity, 'order' => $order, 'service'=>$service,
        'ticket'=>$ticket, 'carrello'=>$order_elements, 'barcode'=>$order->barcode, 'abbonamento'=>0]);
});
