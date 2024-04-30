<?php
$servername = "localhost";
$username = "adm1";
$password = "Lukinha72!";
$dbname = "roletapix";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
