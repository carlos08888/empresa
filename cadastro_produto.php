<?php
require 'config/db.php';

$nome = $_POST['nome'];
$preco = $_POST['preco'];
$descricao = $_POST['descricao'];

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $imagem_nome = uniqid() . "_" . basename($_FILES["imagem"]["name"]);
    $imagem_caminho = "img/" . $imagem_nome;
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem_caminho);
} else {
    $imagem_caminho = "img/.png"; // Imagem padrão
}

$stmt = $conn->prepare("INSERT INTO produtos (nome, preco, descricao, imagem) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sdss", $nome, $preco, $descricao, $imagem_caminho);
$stmt->execute();
$stmt->close();

header("Location: admin.php");
exit();
