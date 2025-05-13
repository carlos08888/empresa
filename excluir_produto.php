<?php
require 'config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID do produto não informado.";
    exit;
}

// Remove o produto
$stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin.php");
exit;
?>