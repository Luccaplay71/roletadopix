<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$nome = $_SESSION['nome'];
$saldo = $_SESSION['saldo'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roleta do Pix</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .roleta {
            width: 600px;
            height: 600px;
            border: 2px solid black;
            border-radius: 50%;
            position: relative;
            margin: 50px auto;
        }
        .setor {
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 300px 150px 0;
            transform-origin: 50% 300px;
        }
        .setor:nth-child(1) { /* 0x */
            transform: rotate(0deg);
            border-color: #ff6347;
        }
        .setor:nth-child(2) { /* 0x */
            transform: rotate(36deg);
            border-color: #ff6347;
        }
        .setor:nth-child(3) { /* 0x */
            transform: rotate(72deg);
            border-color: #ff6347;
        }
        .setor:nth-child(4) { /* 0x */
            transform: rotate(108deg);
            border-color: #ff6347;
        }
        .setor:nth-child(5) { /* 0x */
            transform: rotate(144deg);
            border-color: #ff6347;
        }
        .setor:nth-child(6) { /* 2x */
            transform: rotate(180deg);
            border-color: #6495ed;
        }
        .setor:nth-child(7) { /* 1.5x */
            transform: rotate(216deg);
            border-color: #32cd32;
        }
        .setor:nth-child(8) { /* 1.5x */
            transform: rotate(252deg);
            border-color: #32cd32;
        }
        .setor:nth-child(9) { /* 5x */
            transform: rotate(288deg);
            border-color: #8a2be2;
        }
        .setor:nth-child(10) { /* 10x */
            transform: rotate(324deg);
            border-color: #dc143c;
        }
    </style>
</head>
<body>
    <header>
        <h1>Roleta do Pix</h1>
        <nav>
            <ul>
                <li>Bem-vindo, <?php echo $nome; ?> (Saldo: R$ <?php echo $saldo; ?>)</li>
                <li><a href="logout.php">Sair</a></li>
                <li><a href="deposito.php">Depositar</a></li>
                <li><a href="saque.php">Sacar</a></li>
            </ul>
        </nav>
    </header>

    <div class="roleta">
        <?php for ($i = 0; $i < 10; $i++) { ?>
            <div class="setor"></div>
        <?php } ?>
    </div>

    <div class="content">
        <form action="paypal_payment.php" method="post">
            <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['id']; ?>">
            <input type="hidden" name="valor" id="valor" value="">
            <button type="submit" id="btnJogar" disabled>Jogar</button>
        </form>
    </div>

    <script>
        var multiplicadores = [0, 0, 0, 0, 0, 2, 1.5, 1.5, 5, 10];
        var valor = 0;

        function girarRoleta() {
            var setor = Math.floor(Math.random() * 10);
            valor = multiplicadores[setor];
            document.getElementById('valor').value = valor.toFixed(2);
            document.getElementById('btnJogar').disabled = false;
        }

        girarRoleta();
    </script>
</body>
</html>
