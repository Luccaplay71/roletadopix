<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor = $_POST['valor'];
    $usuario_id = $_SESSION['id'];

    $sql = "UPDATE usuarios SET saldo = saldo + $valor WHERE id = $usuario_id";
    if ($conn->query($sql) === TRUE) {
        $sql = "INSERT INTO transacoes (usuario_id, tipo, valor) VALUES ($usuario_id, 'deposito', $valor)";
        $conn->query($sql);
        $_SESSION['saldo'] += $valor;
    } else {
        $erro = "Erro ao depositar. Tente novamente mais tarde.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depósito - Roleta do Pix</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Depósito</h1>
        <nav>
            <ul>
                <li><a href="index.php">Voltar</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <form method="post">
            <input type="number" step="0.01" name="valor" placeholder="Valor a depositar" required/>
            <button type="submit">Depositar</button>
            <?php if (isset($erro)) { ?>
                <p class="erro"><?php echo $erro; ?></p>
            <?php } ?>
        </form>
    </div>
</body>
</html>
