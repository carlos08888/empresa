<?php
session_start();
require 'config/db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redireciona para o login caso não esteja logado
    exit();
}

// Pega o nome do usuário da sessão
$nomeUsuario = $_SESSION['usuario_nome']; // Nome armazenado na sessão

// Busca produtos do banco
$produtos = [];
$result = $conn->query("SELECT * FROM produtos");

while ($row = $result->fetch_assoc()) {
    $produtos[$row['id']] = [
        'nome' => $row['nome'],
        'preco' => $row['preco'],
        'imagem' => $row['imagem'] ?? 'img/default.jpg',
        'descricao' => $row['descricao']
    ];
}

$conn->close();

// Carrinho
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    if (isset($produtos[$id])) {
        if (!isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id] = 1;
        } else {
            $_SESSION['carrinho'][$id]++;
        }
    }
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - INOVA SOLUTION</title>
    <link rel="stylesheet" href="dashboard.css?v=2.0">
</head>
<body>
<header>
    <div class="logo">Bem-vindo, <strong><?php echo htmlspecialchars($nomeUsuario); ?></strong>!</div>
    <div class="usuario">
        <a href="logout.php" class="btn-sair">Sair</a>
    </div>
    <div class="carrinho">
        <a href="carrinho.php">🛒 Carrinho (<?php echo array_sum($_SESSION['carrinho'] ?? []); ?>)</a>
    </div>
</header>

<main>
    <h2>Produtos para Compra</h2>
    <div class="produtos">
        <?php foreach ($produtos as $id => $produto): ?>
            <div class="produto">
                <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
                <h3><?php echo $produto['nome']; ?></h3>
                <p class="descricao"><?php echo nl2br($produto['descricao']); ?></p>
                <p>R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                <a href="?add=<?php echo $id; ?>" class="btn-comprar">Adicionar ao Carrinho</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
