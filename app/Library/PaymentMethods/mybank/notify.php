<?php

include __DIR__ . '/config.php';


$paymentId                      = $_POST['paymentid'];
$result                         = array();
$result['result']               = $_POST['result'];
$result['authorizationCode']    = $_POST['authorizationcode'];
//$result['rrn']                  = $_POST['rrn'];
$result['merchantOrderId']      = $_POST['merchantorderid'];
$result['mybankid']             = $_POST['mybankid'];
//$result['threeDSecure']         = $_POST["threedsecure"];
//$result['maskedPan']            = $_POST["maskedpan"];
//$result['cardCountry']          = $_POST["cardcountry"];
$result['customField']          = $_POST["customfield"];
$result['securityToken']        = $_POST["securitytoken"];
$result['info']                 = $_POST;

session_id($paymentId);
session_start();

$_SESSION['payment-result']     = $result;

$resultPageUrl                  = CCW_PAGE_PAYMENT_RESULT . '?paymentid=' . $paymentId;


echo $resultPageUrl;
