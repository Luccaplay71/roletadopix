<?php
require 'vendor/autoload.php';

define('PAYPAL_CLIENT_ID', 'SEU_CLIENT_ID');
define('PAYPAL_CLIENT_SECRET', 'SEU_CLIENT_SECRET');
define('PAYPAL_RETURN_URL', 'http://localhost/casino/paypal_execute_payment.php');
define('PAYPAL_CANCEL_URL', 'http://localhost/casino/index.php');

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        PAYPAL_CLIENT_ID,     // ClientID
        PAYPAL_CLIENT_SECRET  // ClientSecret
    )
);
?>
