<?php
require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $nome, $email, $senhaHash);

            if ($stmt->execute()) {
                header("Location: login.php?sucesso=1");
                exit;
            } else {
                header("Location: register.php?erro=1");
                exit;
            }
        } else {
            header("Location: register.php?erro=1");
            exit;
        }
    } else {
        header("Location: register.php?erro=1");
        exit;
    }
}
?>
