<?php
 
require   __DIR__.'/bootstrap.php';    
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

// ### Payer
// A resource representing a Payer that funds a payment
// For paypal account payments, set payment method
// to 'paypal'.


      
$payer = new Payer();
$payer->setPaymentMethod("paypal");
$prezzoMerce = 0; 
$prezzoSpedizione = 0;
 
 
$arrayItemsObj = array(); 
$item = new Item();

$item->setName(    $paypal_name    )
    ->setCurrency(   "EUR" )
    ->setQuantity( 1 )
    ->setSku(  $paypal_sku ) // Similar to `item_number` in Classic API
    ->setPrice( $paypal_total ); 

$arrayItemsObj[] = $item; 
 

 
$itemList = new ItemList();
$itemList->setItems(  $arrayItemsObj   );



 
      
                           
// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$objamount = new Amount();
$objamount->setCurrency("EUR")->setTotal( $paypal_total );

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($objamount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());     

// ### Redirect urls
// Set the urls that the buyer must be redirected to after 
// payment approval/ cancellation.
$baseUrl = getBaseUrl();
 
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl( CCW_PAGE_PAYMENT_SUCCESS )
    ->setCancelUrl( CCW_PAGE_PAYMENT_FAILURE );

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));


// For Sample Purposes Only.
$request = clone $payment;

// ### Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state and the
// url to which the buyer must be redirected to
// for payment approval
try {
    $payment->create($apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
    exit(1);
}

// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getApprovalLink()
// method
$approvalUrl = $payment->getApprovalLink();

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
//print("Prova");
//ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);
  
 

  
 if(  $payment->getState() == "created" && $payment->getID() != ''  && $approvalUrl != ''   ) {
                 
  global $payment_url;                           
  $payment_url = $approvalUrl;
  //header('Location: ' . $approvalUrl ) ; 
  
 }
 


                
