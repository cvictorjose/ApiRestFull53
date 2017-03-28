<?php

// Includi classi
include 'classes/monetaweb.class.php' ;
//global $transaction_code;
//$transaction_code = ($transaction_code) ?: '';

define('MERCHANT_DOMAIN', 'http://'.$_SERVER['HTTP_HOST'].'/payment/setefi');
define('SETEFI_PAYMENT_GATEWAY_API', '/monetaweb/payment/2/xml');     // Versione API setefi
if($_SERVER['HTTP_HOST'] == 'devel.ws.cinecittaworld.gag.it'){ // development
    define('SETEFI_PAYMENT_GATEWAY_DOMAIN', 'https://test.monetaonline.it');   // TEST URL
    define('TERMINAL_ID', '11111');          // TEST Username
    define('TERMINAL_PASSWORD', 'xxxx');   // TEST Password
}else{ // production
    define('SETEFI_PAYMENT_GATEWAY_DOMAIN', 'https://www.monetaonline.it');   // PROD URL
    define('TERMINAL_ID', '');          // PROD Username
    define('TERMINAL_PASSWORD', '');   // PROD Password
}
//if(!defined('CCW_PAGE_PAYMENT_SUCCESS'))
define('CCW_PAGE_PAYMENT_SUCCESS', 'http://'.$_SERVER['HTTP_HOST'].'/payment/setefi/success'); 
//if(!defined('CCW_PAGE_PAYMENT_FAILURE'))
define('CCW_PAGE_PAYMENT_FAILURE', 'http://'.$_SERVER['HTTP_HOST'].'/payment/setefi/failure'); 
define('CCW_LOG_ECOMMERCE', '');
