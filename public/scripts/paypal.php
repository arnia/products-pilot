<?php

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;


require (APPLICATION_PATH . "/../library/My/paypal_bootstrap.php");
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

$payer = new Payer();
$payer->setPaymentMethod("paypal");

$auth = Zend_Auth::getInstance();
if($auth->hasIdentity()) $user_id = $auth->getIdentity()->id;
else return;

$userMapper = new Application_Model_UserMapper();
$results = $userMapper->getShoppingCart($user_id);
$items = array();
$subTotal = 0;
foreach($results as $i => $result) {
    $item = new Item();
    $item->setName($result->name)
        ->setCurrency('USD')
        ->setQuantity($result->quantity)
        ->setSku($i + 1) // Similar to `item_number` in Classic API
        ->setPrice($result->price);
    $items[] = $item;
    $subTotal += $result->quantity * (float)number_format($result->price,2);
}

$itemList = new ItemList();
$itemList->setItems($items);

$shippingTax = 1; //

$details = new Details();
$details->setShipping($shippingTax)
    ->setTax(0)
    ->setSubtotal($subTotal);
$total = $shippingTax + $subTotal;

$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal($total)
    ->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());

$baseUrl = getBaseUrl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl($baseUrl . '/users/exepaypal/?success=true');
$redirectUrls->setCancelUrl($baseUrl .'/users/exepaypal/?cancel=true');

$payment = new Payment();
$payment->setIntent("sale");
$payment->setPayer($payer);
$payment->setRedirectUrls($redirectUrls);
$payment->setTransactions(array($transaction));

$result = $payment->create($apiContext);

echo $payment->getApprovalLink();
