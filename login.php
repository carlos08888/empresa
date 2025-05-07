<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['nivel'] === 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
}

function mensagemErro($tipo, $mensagem) {
    return "<div class=\"mensagem $tipo\" role=\"alert\" aria-live=\"assertive\">$mensagem</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InovaSoluction</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <main class="login-container" role="main">
        <?php
        if (isset($_GET['sucesso'])) {
            echo mensagemErro('sucesso', '✅ Conta criada com sucesso! Faça login.');
        }

        if (isset($_GET['erro'])) {
            $erro = htmlspecialchars($_GET['erro']);
            if ($erro === 'senha') {
                echo mensagemErro('erro', '❌ Senha incorreta.');
            } elseif ($erro === 'email') {
                echo mensagemErro('erro', '❌ E-mail não encontrado.');
            }
        }
        ?>

        <h1>Login</h1>

        <form action="process_login.php" method="POST" novalidate>
            <div class="input-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="input-icon">
                <i class="fas fa-lock"></i>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
            </div>

            <button type="submit">Entrar</button>
        </form>

        <p class="registro">Não tem conta? <a href="register.php">Criar conta</a></p>
    </main>
</body>
</html>
