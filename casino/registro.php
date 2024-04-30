<?php
session_start();

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['id'] = $conn->insert_id;
        $_SESSION['nome'] = $nome;
        $_SESSION['saldo'] = 0;
        header("Location: index.php");
        exit();
    } else {
        $erro = "Erro ao registrar. Tente novamente mais tarde.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Roleta do Pix</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <form class="register-form" method="post">
                <input type="text" name="nome" placeholder="Nome" required/>
                <input type="email" name="email" placeholder="Email" required/>
                <input type="password" name="senha" placeholder="Senha" required/>
                <button type="submit">Registrar</button>
                <p class="message">Já está registrado? <a href="login.php">Faça login</a></p>
                <?php if (isset($erro)) { ?>
                    <p class="erro"><?php echo $erro; ?></p>
                <?php } ?>
            </form>
        </div>
    </div>
</body>
</html>
