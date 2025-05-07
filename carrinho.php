<?php
session_start();
require 'config/db.php';

// Garante que o carrinho esteja definido
if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$carrinho_vazio = empty($_SESSION['carrinho']);

// Carrega os produtos do banco de dados
$ids = array_keys($_SESSION['carrinho']);
$produtos = [];

if (!$carrinho_vazio && count($ids) > 0) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("SELECT id, nome, preco, imagem FROM produtos WHERE id IN ($placeholders)");

    $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($produto = $result->fetch_assoc()) {
        $produtos[$produto['id']] = $produto;
    }
}

// Calcula o total
$total = 0;
foreach ($_SESSION['carrinho'] as $id => $quantidade) {
    if (isset($produtos[$id])) {
        $total += $produtos[$id]['preco'] * $quantidade;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho - INOVA SOLUTION</title>
    <link rel="stylesheet" href="carrinho.css?v=1.2">
</head>
<body>
    <header>
        <div class="logo">INOVA SOLUTION</div>
        <div class="usuario">
            Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario'] ?? 'Visitante'); ?>!
            <a href="logout.php" class="btn-sair">Sair</a>
        </div>
        <div class="carrinho">
            <a href="dashboard.php">🛒 Voltar à Loja</a>
        </div>
    </header>

    <main>
        <h2>Carrinho de Compras</h2>

        <?php if ($carrinho_vazio): ?>
            <p>Seu carrinho está vazio.</p>
        <?php else: ?>
            <div class="itens-carrinho">
                <?php foreach ($_SESSION['carrinho'] as $id => $quantidade): ?>
                    <?php if (isset($produtos[$id])): ?>
                        <div class="item">
                            <img src="<?php echo $produtos[$id]['imagem']; ?>" alt="<?php echo $produtos[$id]['nome']; ?>">
                            <div class="detalhes">
                                <h3><?php echo $produtos[$id]['nome']; ?></h3>
                                <p>R$<?php echo number_format($produtos[$id]['preco'], 2, ',', '.'); ?></p>
                                <p>Quantidade: <?php echo $quantidade; ?></p>
                            </div>
                            <div class="subtotal">
                                <p>Subtotal: R$<?php echo number_format($produtos[$id]['preco'] * $quantidade, 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="total">
                <h3>Total: R$<?php echo number_format($total, 2, ',', '.'); ?></h3>
                <a href="finalizar.php" class="btn-finalizar">Finalizar Compra</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
