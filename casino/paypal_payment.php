<?php
session_start();
include 'paypal_config.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];
$valor = $_POST['valor'];

$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$item = new \PayPal\Api\Item();
$item->setName('Créditos do Casino')
    ->setCurrency('BRL')
    ->setQuantity(1)
    ->setPrice($valor);

$itemList = new \PayPal\Api\ItemList();
$itemList->setItems([$item]);

$amount = new \PayPal\Api\Amount();
$amount->setCurrency('BRL')
    ->setTotal($valor);

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription('Compra de créditos do Casino');

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl(PAYPAL_RETURN_URL)
    ->setCancelUrl(PAYPAL_CANCEL_URL);

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions([$transaction])
    ->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
    header("Location: " . $payment->getApprovalLink());
} catch (Exception $ex) {
    echo $ex;
}
?>
