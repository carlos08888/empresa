<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$nomeUsuario = $_SESSION['nome'] ?? 'Usuário';
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo - INOVA SOLUTION</title>
    <link rel="stylesheet" href="admin.css?v=2.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

<header>
    <div class="header-left">
        <div class="logo">INOVA SOLUTION</div>
    </div>
    <div class="header-right">
        <div class="username"><?php echo htmlspecialchars($nomeUsuario); ?></div>
        <a class="logout" href="logout.php">Sair</a>
    </div>
</header>

<div class="menu-container">
    <select class="menu-select" onchange="if(this.value) window.location.href=this.value;">
        <option selected disabled>🔽 Menu de Ações</option>
        <option value="dashboard.php">📊 Dashboard</option>
        <option value="listar_produtos.php">📦 Ver/Editar Produtos</option>
    </select>
</div>

<main class="container">
    <h1>Gestão Administrativa</h1>

    <section class="form-section">
        <h2>Cadastrar Novo Produto</h2>
        <form action="cadastro_produto.php" method="POST" enctype="multipart/form-data">
            <label for="nome">Nome do Produto:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="preco">Preço:</label>
            <input type="number" name="preco" id="preco" step="0.01" min="0" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="4" required></textarea>

            <label for="imagem">Imagem do Produto:</label>
            <input type="file" name="imagem" id="imagem" accept="image/*" required>

            <button type="submit">Cadastrar Produto</button>
        </form>
    </section>
</main>

</body>
</html>