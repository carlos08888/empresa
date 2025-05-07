<?php
session_start();
require 'config/db.php';

// Protege a página: apenas usuários logados
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Consulta os produtos no banco
$sql = "SELECT * FROM produtos ORDER BY id DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos Cadastrados</title>
    <link rel="stylesheet" href="produtos.css">
</head>
<body>

<a href="dashboard.php" class="voltar-btn">Voltar</a>

<div class="container">
    <h1>Lista de Produtos</h1>

    <?php if ($resultado->num_rows > 0): ?>
        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço (R$)</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($produto = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= $produto['id'] ?></td>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td><?= htmlspecialchars($produto['descricao']) ?></td>
                            <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td><?= $produto['quantidade'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="mensagem">Nenhum produto cadastrado.</p>
    <?php endif; ?>
</div>

</body>
</html>
