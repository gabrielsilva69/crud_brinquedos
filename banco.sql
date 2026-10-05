CREATE DATABASE IF NOT EXISTS brinquedos_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE brinquedos_db;

CREATE TABLE IF NOT EXISTS brinquedos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(60) NOT NULL,
    faixa_etaria VARCHAR(40) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL
);

INSERT INTO brinquedos (nome, categoria, faixa_etaria, preco, quantidade) VALUES
('Carrinho de Controle Remoto', 'Veículos', '8 anos ou mais', 89.90, 10),
('Boneca', 'Bonecas', '5 anos ou mais', 59.90, 15),
('Quebra-Cabeça', 'Jogos', '6 anos ou mais', 34.90, 20);
