<?php
session_start();

// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho'])) {
    header("Location: dashboard.php");
    exit();
}

// Lista de produtos (poderia vir de um banco de dados)
$produtos = [
    1 => ["nome" => "Tênis Basquete", "preco" => 2.99, "imagem" => "img/tenis.jpg"],
    2 => ["nome" => "Blusa Basquete", "preco" => 1.50, "imagem" => "img/blusa.jpg"],
    3 => ["nome" => "Manguito Basquete", "preco" => 100.99, "imagem" => "img/manguito.jpg"],
    4 => ["nome" => "Short", "preco" => 4.99, "imagem" => "img/short.jpg"]
];

// Calcula o total do carrinho
$total = 0;
foreach ($_SESSION['carrinho'] as $id => $quantidade) {
    if (isset($produtos[$id])) {
        $total += $produtos[$id]['preco'] * $quantidade;
    }
}

$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Visitante';

// Se o formulário foi enviado, processa a compra (isso pode ser expandido para integrar com um sistema de pagamento real)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simula o processamento da compra
    // Aqui, você pode adicionar lógica de pagamento e salvar os dados no banco de dados
    // Após o pagamento, limpar o carrinho
    $_SESSION['carrinho'] = [];
    $compra_concluida = true;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra - INOVA SOLUTION</title>
    <link rel="stylesheet" href="finalizar.css?v=1.1">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("form").addEventListener("submit", function(event) {
                const endereco = document.getElementById("endereco").value;
                const pagamento = document.getElementById("pagamento").value;

                if (endereco.trim() === "") {
                    alert("Por favor, preencha o endereço de entrega.");
                    event.preventDefault();
                } else if (pagamento === "") {
                    alert("Por favor, selecione uma forma de pagamento.");
                    event.preventDefault();
                }
            });
        });
    </script>
</head>
<body>
    <header>
        <div class="logo">INOVA SOLUTION</div>
        <div class="usuario">
            Bem-vindo, <?php echo htmlspecialchars($usuario); ?>!
            <a href="logout.php" class="btn-sair">Sair</a>
        </div>
    </header>

<main>
    <h2>Finalizar Compra</h2>

    <?php if (isset($compra_concluida) && $compra_concluida): ?>
        <p class="sucesso">Compra realizada com sucesso! Em breve, você receberá um e-mail de confirmação.</p>
        <a href="dashboard.php" class="btn-voltar">Voltar à Loja</a>
    <?php else: ?>
        <div class="detalhes-carrinho">
            <h3>Itens no Carrinho</h3>
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
            </div>

            <h3>Informações de Pagamento</h3>
            <form method="POST" action="finalizar.php">
                <label for="endereco">Endereço de Entrega:</label>
                <input type="text" id="endereco" name="endereco" required placeholder="Digite seu endereço">

                <label for="pagamento">Forma de Pagamento:</label>
                <select id="pagamento" name="pagamento" required>
                    <option value="cartao">Cartão de Crédito</option>
                    <option value="boleto">Boleto Bancário</option>
                    <option value="pix">PIX</option>
                    <option value="fiado">Fiado</option>
                </select>

                <button type="submit" class="btn-confirmar">Confirmar Compra</button>
            </form>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
