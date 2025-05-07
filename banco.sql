-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS login_tutorial;
USE login_tutorial;

-- Criação da tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nivel ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    descricao TEXT,
    preco DECIMAL(10,2),
    imagem VARCHAR(255)
);

INSERT INTO produtos (nome, descricao, preco, imagem) VALUES
('Tênis Esportivo', 'Confortável e resistente para o dia a dia.', 199.99, 'imagens/tenis.jpg'),
('Blusa Casual', 'Blusa de algodão para todas as estações.', 89.90, 'imagens/blusa.jpg'),
('Boné Estiloso', 'Boné com aba curva, estilo urbano.', 49.50, 'imagens/bone.jpg');
