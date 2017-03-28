<?php

include __DIR__ . '/config.php';

$parameters = [
	'id' => TERMINAL_ID,
	'password' => TERMINAL_PASSWORD,
	'operationType' => 'initializemybank',
	'amount' => $mybank_total,
	'currencyCode' => '978',
	'language' => 'ITA',
	'responseToMerchantUrl' => CCW_PAGE_PAYMENT_NOTIFY,
	'merchantOrderId' => $transaction_code
];


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SETEFI_PAYMENT_GATEWAY_API);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
//curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');

$xmlResponse = curl_exec($ch);

curl_close($ch);

$response = new SimpleXMLElement($xmlResponse);
$paymentId = $response->paymentid;
$redirectUrl = $response->hostedpageurl;

$securityToken = $response->securitytoken; // attualmente non viene usato

$payment_url = "$redirectUrl?PaymentID=$paymentId";
