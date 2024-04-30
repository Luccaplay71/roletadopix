<?php
session_start();
include 'paypal_config.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];
$valor = $_POST['valor'];

$paymentId = $_GET['paymentId'];
$token = $_GET['token'];
$payerId = $_GET['PayerID'];

$payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
$execution = new \PayPal\Api\PaymentExecution();
$execution->setPayerId($payerId);

try {
    $result = $payment->execute($execution, $apiContext);
    if ($result->getState() === 'approved') {
        include 'conexao.php';
        $sql = "UPDATE usuarios SET saldo = saldo + $valor WHERE id = $usuario_id";
        $conn->query($sql);
        $sql = "INSERT INTO transacoes (usuario_id, tipo, valor) VALUES ($usuario_id, 'deposito', $valor)";
        $conn->query($sql);
        $_SESSION['saldo'] += $valor;
        header("Location: index.php");
    } else {
        echo "Pagamento não aprovado!";
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
