<?php
session_start();

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['saldo'] = $row['saldo'];
        header("Location: index.php");
        exit();
    } else {
        $erro = "Email ou senha incorretos";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Roleta do Pix</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form class="login-form" method="post">
                <input type="email" name="email" placeholder="Email" required/>
                <input type="password" name="senha" placeholder="Senha" required/>
                <button type="submit">Entrar</button>
                <p class="message">Não está registrado? <a href="registro.php">Crie uma conta</a></p>
                <?php if (isset($erro)) { ?>
                    <p class="erro"><?php echo $erro; ?></p>
                <?php } ?>
            </form>
        </div>
    </div>
</body>
</html>
