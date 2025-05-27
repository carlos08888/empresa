<?php
require 'config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID do produto não informado.";
    exit;
}

// Busca os dados do produto
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produto = $result->fetch_assoc();

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $imagem = $produto['imagem']; // valor atual

    // Atualiza a imagem se uma nova for enviada
    if (!empty($_FILES['imagem']['name'])) {
        $arquivo_tmp = $_FILES['imagem']['tmp_name'];
        $nome_arquivo = uniqid() . '_' . $_FILES['imagem']['name'];
        $caminho_destino = 'img/' . $nome_arquivo;

        if (move_uploaded_file($arquivo_tmp, $caminho_destino)) {
            $imagem = $caminho_destino;
        }
    }

    // Atualiza no banco
    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, preco = ?, imagem = ? WHERE id = ?");
    $stmt->bind_param("sdsi", $nome, $preco, $imagem, $id);
    $stmt->execute();

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="editar_produto.css">
</head>
<body>
    <h2>Editar Produto</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required><br>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required><br>

        <label>Imagem Atual:</label><br>
        <img src="<?= $produto['imagem'] ?>" width="120"><br><br>

        <label>Nova Imagem (opcional):</label>
        <input type="file" name="imagem"><br>

        <button type="submit">Salvar Alterações</button>
        <a href="admin.php">Cancelar</a>
    </form>
</body>
</html>