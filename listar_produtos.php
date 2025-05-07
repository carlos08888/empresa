<?php
require 'config/db.php';
$result = $conn->query("SELECT * FROM produtos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Produtos</title>
    <link rel="stylesheet" href="admin.css?v=2.0">
</head>
<body>
<header>
    <div class="logo">INOVA SOLUTION</div>
    <div class="header-right">
        <a class="logout" href="admin.php">⬅ Voltar</a>
    </div>
</header>

<main class="container">
    <h1>Lista de Produtos</h1>
    <table>
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($produto = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo $produto['imagem']; ?>" width="60"></td>
                    <td><?php echo $produto['nome']; ?></td>
                    <td>R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $produto['descricao']; ?></td>
                    <td>
                        <a href="editar_produto.php?id=<?php echo $produto['id']; ?>">✏️ Editar</a> |
                        <a href="excluir_produto.php?id=<?php echo $produto['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">🗑️ Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
</body>
</html>
