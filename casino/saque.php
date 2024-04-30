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

    if ($valor > $_SESSION['saldo']) {
        $erro = "Saldo insuficiente.";
    } else {
        $sql = "UPDATE usuarios SET saldo = saldo - $valor WHERE id = $usuario_id";
        if ($conn->query($sql) === TRUE) {
            $sql = "INSERT INTO transacoes (usuario_id, tipo, valor) VALUES ($usuario_id, 'saque', $valor)";
            $conn->query($sql);
            $_SESSION['saldo'] -= $valor;
        } else {
            $erro = "Erro ao sacar. Tente novamente mais tarde.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saque - Roleta do Pix</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Saque</h1>
        <nav>
            <ul>
                <li><a href="index.php">Voltar</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <form method="post">
            <input type="number" step="0.01" name="valor" placeholder="Valor a sacar" required/>
            <button type="submit">Sacar</button>
            <?php if (isset($erro)) { ?>
                <p class="erro"><?php echo $erro; ?></p>
            <?php } ?>
        </form>
    </div>
</body>
</html>
