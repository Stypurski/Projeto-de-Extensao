-- phpMyAdmin SQL Dump
-- Banco de dados: `loja_estetica`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `loja_estetica` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `loja_estetica`;

-- --------------------------------------------------------
-- Estrutura da tabela `administrador` (NOVA)
-- --------------------------------------------------------

CREATE TABLE `administrador` (
  `id_adm` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `administrador` (`id_adm`, `nome`, `email`, `senha`) VALUES
(1, 'Luciana Ferreira', 'admin@cosmobeleza.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- --------------------------------------------------------
-- Estrutura da tabela `cliente`
-- --------------------------------------------------------

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nome_completo` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estrutura da tabela `produtos`
-- --------------------------------------------------------

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `produtos` (`id_produto`, `nome`, `valor`, `imagem`) VALUES
(4, 'Creme Facial', 49.90, 'https://images.unsplash.com/photo-1629732047847-50219e9c5aef'),
(5, 'Sérum Vitamina C', 79.90, 'https://images.unsplash.com/photo-1768235146507-20d280903e13'),
(6, 'Protetor Solar', 59.90, 'https://images.unsplash.com/photo-1551446339-1e5c6f164ec2'),
(7, 'Tônico', 39.90, 'https://images.pexels.com/photos/6847843/pexels-photo-6847843.jpeg'),
(8, 'Sérum Rejuvenecedor', 29.90, 'https://images.pexels.com/photos/7005936/pexels-photo-7005936.jpeg'),
(9, 'Gel Limpeza', 42.90, 'https://images.pexels.com/photos/30804152/pexels-photo-30804152.jpeg');

-- --------------------------------------------------------
-- Estrutura da tabela `pedido`
-- --------------------------------------------------------

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `cupom_usado` varchar(20) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estrutura da tabela `pedido_produto`
-- --------------------------------------------------------

CREATE TABLE `pedido_produto` (
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `valor_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estrutura da tabela `pagamento`
-- --------------------------------------------------------

CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `forma_pagamento` varchar(20) NOT NULL DEFAULT 'PIX',
  `nome_cartao` varchar(50) DEFAULT NULL,
  `numero_cartao` varchar(20) DEFAULT NULL,
  `validade` varchar(5) DEFAULT NULL,
  `cvv` varchar(3) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Índices e Chaves Primárias
-- --------------------------------------------------------

ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_adm`),
  ADD UNIQUE KEY `uk_adm_email` (`email`);

ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `uk_cliente_email` (`email`);

ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_cliente` (`id_cliente`);

ALTER TABLE `pedido_produto`
  ADD PRIMARY KEY (`id_pedido`,`id_produto`),
  ADD KEY `fk_pp_produto` (`id_produto`);

ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `fk_pagamento_pedido` (`id_pedido`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `administrador`
  MODIFY `id_adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
-- Chaves Estrangeiras (Restrições)
-- --------------------------------------------------------

ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

ALTER TABLE `pedido_produto`
  ADD CONSTRAINT `fk_pp_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `fk_pp_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`);

ALTER TABLE `pagamento`
  ADD CONSTRAINT `fk_pagamento_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;ONNECTION=@OLD_COLLATION_CONNECTION */;
