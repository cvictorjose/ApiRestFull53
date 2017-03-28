<?php

define('MERCHANT_DOMAIN', 'http://' . $_SERVER['HTTP_HOST'] . '/payment/mybank');

if($_SERVER['HTTP_HOST'] == 'devel.ws.xxx.gag.it'){ // development
    define('SETEFI_PAYMENT_GATEWAY_DOMAIN', 'https://test.monetaonline.it');
    define('TERMINAL_ID', '99999');
    define('TERMINAL_PASSWORD', 'xxxxx');
}else{ // production
    define('SETEFI_PAYMENT_GATEWAY_DOMAIN', 'https://www.monetaonline.it');   // PROD URL
    define('TERMINAL_ID', '');          // PROD Username
    define('TERMINAL_PASSWORD', '');   // PROD Password
}
define('SETEFI_PAYMENT_GATEWAY_API', SETEFI_PAYMENT_GATEWAY_DOMAIN . '/monetaweb/payment/2/xml');

define('CCW_PAGE_PAYMENT_NOTIFY',  MERCHANT_DOMAIN . '/notify');
define('CCW_PAGE_PAYMENT_RESULT',  MERCHANT_DOMAIN . '/result');
define('CCW_PAGE_PAYMENT_SUCCESS', MERCHANT_DOMAIN . '/success');
define('CCW_PAGE_PAYMENT_FAILURE', MERCHANT_DOMAIN . '/failure');

define('CCW_LOG_ECOMMERCE', '');  // /www/xxx.it/devel/htdocs/mybank/logs/
