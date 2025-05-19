<?php
require 'config/db.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$id_produto = $_GET['id'] ?? null;

if ($id_produto) {
    // Buscar o produto pelo ID
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $produto = $stmt->get_result()->fetch_assoc();

    if (!$produto) {
        echo "Produto não encontrado!";
        exit;
    }

    // Atualizar a descrição do produto
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nova_descricao = trim($_POST['descricao']);
        if (!empty($nova_descricao)) {
            $update_stmt = $conn->prepare("UPDATE produtos SET descricao = ? WHERE id = ?");
            $update_stmt->bind_param("si", $nova_descricao, $id_produto);
            $update_stmt->execute();
            header("Location: listar_produtos.php");
            exit;
        } else {
            $erro = "Descrição não pode estar vazia.";
        }
    }
} else {
    echo "ID do produto não fornecido.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Descrição do Produto</title>
    <link rel="stylesheet" href="editar_descricao.css?v=2.0">
</head>
<body>
<header>
    <div class="logo">INOVA SOLUTION</div>
    <div class="header-right">
        <a class="logout" href="listar_produtos.php">⬅ Voltar</a>
    </div>
</header>

<main class="container">
    <h1>Editar Descrição do Produto</h1>

    <?php if (isset($erro)): ?>
        <div class="erro"><?php echo $erro; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" id="nome" value="<?php echo $produto['nome']; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="5" required><?php echo $produto['descricao']; ?></textarea>
        </div>

        <button type="submit" class="btn">Salvar Alterações</button>
    </form>
</main>

</body>
</html>
