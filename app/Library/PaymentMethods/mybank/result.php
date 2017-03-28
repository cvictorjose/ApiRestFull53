<?php

include __DIR__ . '/config.php';

session_id($_GET['paymentid']);
session_start();


// Salvo Log
if( !empty(CCW_LOG_ECOMMERCE) ){
    file_put_contents( CCW_LOG_ECOMMERCE . $_GET['paymentid'] . '-AUTH.json', json_encode($_SESSION['payment-result']) );
}


switch( $_SESSION['payment-result']['result'] ){

	case 'AUTHORISED':
		\App\Order::markAsCompleted($_SESSION['payment-result']['merchantOrderId']);

		header('Location: ' . CCW_PAGE_PAYMENT_SUCCESS);
		break;

    default:
        header('Location: ' . CCW_PAGE_PAYMENT_FAILURE);
		break;

}


die();
