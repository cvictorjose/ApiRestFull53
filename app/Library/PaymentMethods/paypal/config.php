<?php
global $transaction_code;

define('MERCHANT_DOMAIN' , 'http://'.$_SERVER['HTTP_HOST'].'/payment/paypal' ) ;  // Folder in cui si trovano i codici di paypal
if($_SERVER['HTTP_HOST'] == 'devel.ws.cinecittaworld.gag.it'){ //development
    define('CLIENT_ID' , 'AZ'); // TEST GAG
    define('CLIENT_SECRET' , 'ECh'); // TEST GAG
}else{ // production
    define('CLIENT_ID', ''); // PROD
    define('CLIENT_SECRET', ''); // PROD
}

define('CCW_PAGE_PAYMENT_SUCCESS' , 'http://'.$_SERVER['HTTP_HOST'].'/payment/paypal/success?transaction_code='.$transaction_code);   
define('CCW_PAGE_PAYMENT_FAILURE' , 'http://'.$_SERVER['HTTP_HOST'].'/payment/paypal/failure?transaction_code='.$transaction_code) ; 
define('CCW_LOG_ECOMMERCE' , '') ;   
