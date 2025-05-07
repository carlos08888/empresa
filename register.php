<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - InovaSoluction</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <?php if (isset($_GET['erro'])): ?>
            <div class="mensagem erro">❌ Erro ao criar a conta. Tente novamente.</div>
        <?php endif; ?>

        <h2>Criar Conta</h2>

        <form action="process_register.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Crie uma senha" required>

            <button type="submit">Cadastrar</button>
        </form>

        <p class="registro">Já tem conta? <a href="login.php">Fazer login</a></p>
    </div>
</body>
</html>
