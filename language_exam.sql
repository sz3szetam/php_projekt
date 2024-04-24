-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Ápr 24. 09:22
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `language_exam`
--
CREATE DATABASE IF NOT EXISTS `language_exam` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `language_exam`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `user_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `appointments`
--

INSERT INTO `appointments` (`id`, `email`, `name`, `date`, `user_name`) VALUES
(1, 'teszt1@example.com', 'Teszt Elek', '2024-05-01 10:00:00', NULL),
(2, 'teszt2@example.com', 'Teszt Mária', '2024-05-02 11:30:00', NULL),
(3, 'teszt3@example.com', 'Teszt János', '2024-05-03 13:00:00', NULL),
(4, 'tomiszecsi13@gmail.com', 'Tamás Szécsi', '2024-04-04 00:48:00', NULL),
(5, 'tomiszecsi13@gmail.com', 'Tamás Szécsi', '2024-04-24 00:48:00', NULL),
(6, 'tomiszecsi13@gmail.com', 'Tamás Szécsi', '2024-04-24 00:54:00', NULL),
(7, 'tomiszecsi13@gmail.com', 'Tamás Szécsi', '2024-04-24 00:55:00', NULL),
(12, '', '', '2024-04-24 01:05:00', ''),
(13, '', '', '2024-04-24 01:05:00', ''),
(14, '', '', '2024-05-01 09:00:00', ''),
(15, '', '', '2024-05-01 09:00:00', 'Zsofi'),
(16, '', '', '2024-05-01 09:00:00', 'Zsofi'),
(17, '', '', '2024-05-01 09:00:00', 'Zsofi'),
(18, '', '', '2024-05-02 11:00:00', 'Zsofi'),
(19, '', '', '2024-05-01 09:00:00', 'Zsofi');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `available_appointments`
--

CREATE TABLE `available_appointments` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `available_appointments`
--

INSERT INTO `available_appointments` (`id`, `date`) VALUES
(2, '2024-05-01 10:00:00'),
(3, '2024-05-01 11:00:00'),
(4, '2024-05-02 09:00:00'),
(5, '2024-05-02 10:00:00'),
(6, '2024-05-02 11:00:00'),
(7, '2024-05-03 09:00:00'),
(8, '2024-05-03 10:00:00'),
(9, '2024-05-03 11:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `booked_appointments`
--

CREATE TABLE `booked_appointments` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `booked_appointments`
--

INSERT INTO `booked_appointments` (`id`, `date`, `user_name`) VALUES
(2, '2024-05-01 10:00:00', 'Zsofi');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'tomcsaa', '$2y$10$h7jEof8O7xr.aUM59tnVI.DmvXVoNKsajk6cmsxuZ3KbzBuoXDNAe'),
(2, 'tomcsaa', '$2y$10$SHdrYScLsR3P5tzd/7BRcOMYQb2BOoSJLQMsm9x20hxOdrVGLJrdK'),
(3, 'tomcsaa', '$2y$10$fAJ3q5mklUMM5dCQQ0j4E.ii/EDp0KRqlstyePOwVVafIrlUsveWS'),
(4, 'tomcsaa', '$2y$10$anV1Ihlnvyewr6yaGmsGWO7sQQQR6fG2m8pj/BVCZsL4Gy9tkVWO.'),
(5, 'tomcsaa', '$2y$10$LShcKuK9Ppj0Ly7aeNPMv.YmlQLu4uijTjhu1iQ03ssjtLT5Fpmim'),
(6, 'tomcsaa', '$2y$10$LBc4ZsRDnowHzxYlEszvq.jPZm0DZr3TNkilK0qsmqblcHbp51o/m'),
(7, 'tomcsaaa', '$2y$10$E39rbqtKu9L/y.dRFNwYMeoiKioycVckBshqC0XSq3ui8VFXc.4GK'),
(8, 'Reka', '$2y$10$33vuE03/XBE9i.s8OUxBBuO5t2lqC4NebO2QA8oh21wZpxKs3U.3W'),
(9, 'Zsofi', '$2y$10$yk2ZSUI/qhD7ZFMGo66j6e.gAH1aLgfhpemZCWq14HFlkjSAJy7LC'),
(10, 'Kovi', '$2y$10$jLlECyemctl2Xj7JUnRhQeIcCDLdsOnR/EHXvJMMZ90RdImBUoCOa');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `available_appointments`
--
ALTER TABLE `available_appointments`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `booked_appointments`
--
ALTER TABLE `booked_appointments`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `available_appointments`
--
ALTER TABLE `available_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `booked_appointments`
--
ALTER TABLE `booked_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
