-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03-Jul-2023 às 10:57
-- Versão do servidor: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toldo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `food_beverage`
--

CREATE TABLE `food_beverage` (
  `id_fb` int(11) NOT NULL,
  `id_reserva` int(11) NOT NULL,
  `food` varchar(255) DEFAULT NULL,
  `beverage` varchar(255) DEFAULT NULL,
  `toldo_id` varchar(11) NOT NULL,
  `user_c` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `id_reserva` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_c` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `toldo_id` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `hora` time NOT NULL,
  `horasaida` time NOT NULL,
  `reservation_type` enum('hotel','passante') NOT NULL,
  `hotel_number` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_c` varchar(255) NOT NULL,
  `antigo` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `toldos`
--

CREATE TABLE `toldos` (
  `id` int(11) NOT NULL,
  `row` int(11) NOT NULL,
  `num_seat` varchar(11) NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `toldos`
--

INSERT INTO `toldos` (`id`, `row`, `num_seat`, `status`) VALUES
(1, 1, '1', 'disponivel'),
(2, 1, '2', 'disponivel'),
(3, 1, '3', 'disponivel'),
(4, 1, '4', 'disponivel'),
(5, 1, '5', 'disponivel'),
(6, 1, '6', 'disponivel'),
(7, 1, '7', 'disponivel'),
(8, 1, '8', 'disponivel'),
(9, 1, '9', 'disponivel'),
(10, 1, '10', 'disponivel'),
(11, 1, '11', 'disponivel'),
(12, 1, '12', 'disponivel'),
(13, 1, '13', 'disponivel'),
(14, 1, '14', 'disponivel'),
(15, 1, '15', 'disponivel'),
(16, 1, '16', 'disponivel'),
(17, 1, '17', 'disponivel'),
(18, 1, '18', 'disponivel'),
(19, 2, '19', 'disponivel'),
(20, 2, '20', 'disponivel'),
(21, 2, '21', 'disponivel'),
(22, 2, '22', 'disponivel'),
(23, 2, '23', 'disponivel'),
(24, 2, '24', 'disponivel'),
(25, 2, '25', 'disponivel'),
(26, 2, '26', 'disponivel'),
(27, 2, '27', 'disponivel'),
(28, 2, '28', 'disponivel'),
(29, 2, '29', 'disponivel'),
(30, 2, '30', 'disponivel'),
(31, 2, '31', 'disponivel'),
(32, 2, '32', 'disponivel'),
(33, 2, '33', 'disponivel'),
(34, 2, '34', 'disponivel'),
(35, 2, '35', 'disponivel'),
(36, 3, '36', 'disponivel'),
(37, 3, '37', 'disponivel'),
(38, 3, '38', 'disponivel'),
(39, 3, '39', 'disponivel'),
(40, 3, '40', 'disponivel'),
(41, 3, '41', 'disponivel'),
(42, 3, '42', 'disponivel'),
(43, 3, '43', 'disponivel'),
(44, 3, '44', 'disponivel'),
(45, 3, '45', 'disponivel'),
(46, 3, '46', 'disponivel'),
(47, 3, '47', 'disponivel'),
(48, 3, '48', 'disponivel'),
(49, 3, '49', 'disponivel'),
(50, 4, '50', 'disponivel'),
(51, 4, '51', 'disponivel'),
(52, 4, '52', 'disponivel'),
(53, 4, '53', 'disponivel'),
(54, 4, '54', 'disponivel'),
(55, 4, '55', 'disponivel'),
(56, 4, '56', 'disponivel'),
(57, 4, '57', 'disponivel'),
(58, 4, '58', 'disponivel'),
(59, 4, '59', 'disponivel'),
(60, 4, '60', 'disponivel'),
(61, 4, '61', 'disponivel'),
(62, 4, '62', 'disponivel'),
(63, 4, '63', 'disponivel'),
(64, 5, '64', 'disponivel'),
(65, 5, '65', 'disponivel'),
(66, 5, '66', 'disponivel'),
(67, 5, '67', 'disponivel'),
(68, 5, '68', 'disponivel'),
(69, 5, '69', 'disponivel'),
(70, 5, '70', 'disponivel'),
(71, 5, '71', 'disponivel'),
(72, 5, '72', 'disponivel'),
(73, 5, '73', 'disponivel'),
(74, 5, '74', 'disponivel'),
(75, 5, '75', 'disponivel'),
(76, 5, '76', 'disponivel'),
(77, 5, '77', 'disponivel'),
(78, 6, 'B1', 'disponivel'),
(79, 6, 'B2', 'disponivel');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `admin`) VALUES
(1, 'jjwadmin', 'jjwadmin', 1),
(2, 'jjwstaff', 'jjwstaff', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food_beverage`
--
ALTER TABLE `food_beverage`
  ADD PRIMARY KEY (`id_fb`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`);

--
-- Indexes for table `toldos`
--
ALTER TABLE `toldos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food_beverage`
--
ALTER TABLE `food_beverage`
  MODIFY `id_fb` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `toldos`
--
ALTER TABLE `toldos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
