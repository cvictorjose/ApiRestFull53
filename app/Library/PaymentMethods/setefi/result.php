<?php
// Transaction code $transaction_code;  
include "config.php";
session_id($_GET['paymentid']);
session_start();



$objMoneta = new MonetaWeb(   )  ; 


// Salvo Log
if( CCW_LOG_ECOMMERCE != '' && CCW_LOG_ECOMMERCE != null && CCW_LOG_ECOMMERCE != false){
    file_put_contents(  CCW_LOG_ECOMMERCE.  $_GET['paymentid'] ."-AUTH.json"  , json_encode( $_SESSION['payment-result'] )     )   ;
}   
 
// Se approvato eseguo conferma pagamento
if( $_SESSION['payment-result']["result"] == "APPROVED"){

    $params = $_SESSION['payment-result']  ; 
    $result =  $objMoneta->confirm($params) ;
     
    if( $result == "FAILURE" ){       
         header("Location: " . CCW_PAGE_PAYMENT_FAILURE); die()  ;    
    }   else if( $result == "SUCCESS"  ){
         \App\Order::markAsCompleted($_SESSION['payment-result']['merchantOrderId']);
         header("Location: " . CCW_PAGE_PAYMENT_SUCCESS); die()  ;
    }
    else{
         header("Location: " . CCW_PAGE_PAYMENT_FAILURE); die()  ;  
    }

} else{
     header("Location: " . CCW_PAGE_PAYMENT_FAILURE); die()  ;
}


?>
 
