<?php
// if(!isset($transaction_code))
//     $transaction_code = $_GET['order_id'];
include "config.php";
//if(!isset( $_POST["merchantOrderId"] )){   header("Location: " . CCW_PAGE_PAYMENT_FAILURE); die()  ; }
$objMoneta = new MonetaWeb(   )  ;
 
//$merchantOrderId = $_POST["merchantOrderId"] ;  // Codici di riferimento interno al prodotto acquistato ;
//$descrizioneProdotto = $_POST["descrizioneProdotto"] ;  // Descrizione del prodotto
//$amount = $_POST["amount"] ;   // prezzo con punto come separatore dei decimali es 12.50  

//error_log("SETEFI SERVER PHP: ".print_r($_SERVER, true));

$objMoneta->prepare( $setefi_sku, $setefi_total, $setefi_name );