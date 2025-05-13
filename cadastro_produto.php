<?php
require 'config/db.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $descricao = $_POST['descricao'] ?? '';

    // Verifica se a imagem foi carregada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem_nome = $_FILES['imagem']['name'];
        $imagem_extensao = strtolower(pathinfo($imagem_nome, PATHINFO_EXTENSION));

        // Define os tipos permitidos de imagem
        $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Verifica se a extensão da imagem é permitida
        if (in_array($imagem_extensao, $tipos_permitidos)) {
            $imagem_nova = uniqid('img_', true) . '.' . $imagem_extensao;
            $imagem_caminho = 'img/' . $imagem_nova;

            // Cria a pasta 'img/' caso não exista
            if (!is_dir('img')) {
                mkdir('img', 0755, true);
            }

            // Move a imagem para a pasta 'img/'
            if (move_uploaded_file($imagem_temp, $imagem_caminho)) {
                // Inserção do produto no banco de dados
                $stmt = $conn->prepare("INSERT INTO produtos (nome, preco, descricao, imagem) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sdss", $nome, $preco, $descricao, $imagem_caminho);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Erro ao mover o arquivo de imagem.";
            }
        } else {
            echo "Erro: A imagem deve ser um dos seguintes tipos: jpg, jpeg, png, gif, webp.";
        }
    } else {
        echo "Erro: Nenhuma imagem foi enviada ou ocorreu um erro no upload.";
    }
}

// Redireciona para a página admin.php após o processo
header("Location: admin.php");
exit();
?>