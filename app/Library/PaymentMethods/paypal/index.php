<?php
// Transaction code $transaction_code;
global $transaction_code;
if(!isset($transaction_code))
    $transaction_code = $_GET['order_id'];
if(!isset($paypal_name))
    $paypal_name = $_GET['paypal_name'];
if(!isset($paypal_sku))
    $paypal_sku = $_GET['paypal_sku'];
if(!isset($paypal_total))
    $paypal_total = $_GET['paypal_total'];

include __DIR__."/config.php"; 
 
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    include __DIR__ ."/paypal/ExecutePayment.php"    ; 
    
}
else if (isset($_GET['success']) && $_GET['success'] == 'fail') {
    header('Location: ' . CCW_PAGE_PAYMENT_FAILURE ) ; 
   
}
else{

    //$paypal_sku = $_POST["merchantOrderId"] ;  // Codici di riferimento interno al prodotto acquistato ;
    //$paypal_name = $_POST["descrizioneProdotto"] ;  // Descrizione del prodotto
    //$paypal_total = $_POST["amount"] ;   // prezzo con punto come separatore dei decimali es 12.50
    //header("Location: http://www.google.com");  
    include  __DIR__ ."/paypal/index.php";     

} 
