-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 05 Μάη 2021 στις 01:19:46
-- Έκδοση διακομιστή: 10.4.18-MariaDB
-- Έκδοση PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `application`
--
CREATE DATABASE IF NOT EXISTS `application` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `application`;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `applications`
--

CREATE TABLE `applications` (
  `application_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `reason` varchar(120) NOT NULL,
  `email_handler` varchar(40) DEFAULT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `applications`
--

INSERT INTO `applications` (`application_id`, `user_email`, `status`, `date_from`, `date_to`, `reason`, `email_handler`, `date_submitted`) VALUES
(0000000042, 'lefteris@gmail.com', 'Accepted', '2021-05-01', '2021-05-02', 'I want to visit my family ', '0cb2ded982e82dca9b47d30bb7c35757', '2021-05-03 23:34:57'),
(0000000043, 'lefteris@gmail.com', 'Pending', '2021-05-22', '2021-05-30', 'Healthcare', 'f1a214474ccc199e19f2e89ffc6eddb3', '2021-05-03 23:35:17'),
(0000000044, 'lefteris@gmail.com', 'Rejected', '2021-05-16', '2021-05-30', 'Trip to France with my wife ', '7b46d40add2aa706cfc467fdef150ffb', '2021-05-03 23:38:37'),
(0000000045, 'lefteris@gmail.com', 'Rejected', '2021-05-02', '2021-05-30', 'I want to go on a holiday trip to Mikonos', '745515ac2b0a662d142d7da58c4c0137', '2021-05-03 23:39:04'),
(0000000046, 'lefteris@gmail.com', 'Accepted', '2021-05-23', '2021-05-30', 'I want to go home', 'f134ee3b5dbf1051f65f4a60d832bca6', '2021-05-04 03:05:39'),
(0000000047, 'lefteris@gmail.com', 'Pending', '2021-05-23', '2021-06-06', 'I want to go to holidays', '5ffafca9a1f9501bf9788d3e0285f758', '2021-05-04 14:43:18');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `user_type`) VALUES
(23, 'Kostas', 'Stergioulas', 'dimister@gmail.com', '$2y$10$7Wvf29IvcCQEMWy6OqlI4ObsopbwtVJfWuhxFsu0Pr01HJS84VKUi', 'Supervisor'),
(17, 'Kostas', 'Katsouranis', 'katsour@gmail.com', '$2y$10$yRxzD9DmegHO9aYBXaZnzOxveFpXme62y.ZkPkL3AylLNmaNkie8e', 'Supervisor'),
(20, 'Giannis', 'Kipriadis', 'kipris@gmail.com', '$2y$10$Vc0bp3dLeoqH8QtgUmuSueLRT6wHJtbGFh8zD555UC/69HTLaRNoK', 'Employee'),
(18, 'Lefteris', 'Pantos', 'lefteris@gmail.com', '$2y$10$MbBLsPu9pg34awhVndzs0eEpm6ba0Ys2BaupT53SF1nsFHPXA4UHu', 'Employee'),
(21, 'Maria', 'Chardaloupa', 'marichar@gmail.com', '$2y$10$Qd.MFYnB5BJs0SqRczMDQOczER1FzXtUYC1Lrbvu594HeFydS3nP6', 'Employee'),
(22, 'Kostas', 'Nikolaou', 'nikolaou@gmail.com', '$2y$10$Lev0a4gkA4JiFhRpzAo82usPde/MWGbwd4AEeZR5R2Nr3G3ozkLWG', 'Supervisor'),
(27, 'Maria', 'Paparnaki', 'paparnak96@gmail.com', '$2y$10$WuNBDe/.P0jAgFv0cJXIYuC3.U7uYI/lMSACNZIg0wwtu1hSkcjRu', 'Employee'),
(24, 'Alexis', 'Skentos', 'skentos@gmail.com', '$2y$10$Pvmy5UJ1LdvZrJR.lP/8Feb9SIcYR.Aov9/0HSgKZKoazyyDMjmfS', 'Supervisor'),
(19, 'Thanos', 'Kipriadis', 't.kipriadis@gmail.com', '$2y$10$Cv7JCT4Cq29ST0MfYIznJOq9TNyy0irptcXg/Um79VktxYD.nOIgi', 'Supervisor');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `user_email` (`user_email`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
