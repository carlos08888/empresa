<?php
require 'config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Verifica se o email existe
    $stmt = $conn->prepare("SELECT id, nome, senha, nivel FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verifica se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            // Armazena informações na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['nivel'] = $usuario['nivel']; // admin ou comum

            // Redireciona com base no nível
            if ($usuario['nivel'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            // Senha incorreta
            header("Location: login.php?erro=senha");
            exit;
        }
    } else {
        // Email não encontrado
        header("Location: login.php?erro=email");
        exit;
    }
}
?>