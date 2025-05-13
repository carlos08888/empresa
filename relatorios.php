<?php
session_start();
include('config/db.php');

// Exemplo de dados fictícios para relatórios
$relatorios = [
    ['produto' => 'Projetor Epson', 'quantidade' => 12, 'data' => '2025-04-10'],
    ['produto' => 'Caixa de Som JBL', 'quantidade' => 7, 'data' => '2025-04-11'],
    ['produto' => 'Microfone Sony', 'quantidade' => 5, 'data' => '2025-04-12'],
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatórios - Admin</title>
    <link rel="stylesheet" href="relatorios.css">
</head>
<body>

<a href="admin.php" class="voltar-btn">Voltar</a>

<div class="relatorio-container">
    <h1>📊 Relatórios de Agendamentos</h1>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade Agendada</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($relatorios as $linha): ?>
                <tr>
                    <td><?= htmlspecialchars($linha['produto']) ?></td>
                    <td><?= htmlspecialchars($linha['quantidade']) ?></td>
                    <td><?= htmlspecialchars($linha['data']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>