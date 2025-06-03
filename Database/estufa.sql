-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/05/2025 às 16:25
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estufa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `controlemanual`
--

CREATE TABLE `controlemanual` (
  `id` int(11) NOT NULL,
  `controle` varchar(100) NOT NULL,
  `atividade` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `controlemanual`
--

INSERT INTO `controlemanual` (`id`, `controle`, `atividade`) VALUES
(1, 'ventilacao', 0),
(2, 'tanque d\' agua', 1),
(3, 'Ligar lampada', 1),
(4, 'servomotor', 1),
(5, 'ventilacao', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sensors`
--

CREATE TABLE `sensors` (
  `id` int(10) NOT NULL,
  `tipo_sensor` varchar(50) NOT NULL,
  `valor` int(50) NOT NULL,
  `data_atualizada` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `sensors`
--

INSERT INTO `sensors` (`id`, `tipo_sensor`, `valor`, `data_atualizada`) VALUES
(1, 'Temperatura interna', 55, '2025-03-06'),
(2, 'Temperatura externa', 22, '2025-03-17'),
(3, 'Umidade do solo', 33, '2025-05-01'),
(4, 'Luminosidade', 60, '2025-02-10'),
(5, 'tanque d agua', 63, '2025-04-20');

--
-- Acionadores `sensors`
--
DELIMITER $$
CREATE TRIGGER `before_update_sensors` BEFORE UPDATE ON `sensors` FOR EACH ROW BEGIN
    INSERT INTO sensors_log (
        sensor_id, tipo_sensor, valor, data_atualizada, operacao
    )
    VALUES (
        OLD.id, OLD.tipo_sensor, OLD.valor, OLD.data_atualizada, 'UPDATE'
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sensors_log`
--

CREATE TABLE `sensors_log` (
  `log_id` int(11) NOT NULL,
  `sensor_id` int(11) DEFAULT NULL,
  `tipo_sensor` varchar(50) DEFAULT NULL,
  `valor` int(11) DEFAULT NULL,
  `data_atualizada` date DEFAULT NULL,
  `data_log` timestamp NOT NULL DEFAULT current_timestamp(),
  `operacao` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `controlemanual`
--
ALTER TABLE `controlemanual`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sensors_log`
--
ALTER TABLE `sensors_log`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `controlemanual`
--
ALTER TABLE `controlemanual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `sensors`
--
ALTER TABLE `sensors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `sensors_log`
--
ALTER TABLE `sensors_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
