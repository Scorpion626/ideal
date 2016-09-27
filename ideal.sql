-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 27 2016 г., 09:53
-- Версия сервера: 5.5.50
-- Версия PHP: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ideal`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `id_comments` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_userFrom` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Comments`
--

INSERT INTO `Comments` (`id_comments`, `id_user`, `id_userFrom`, `comment`, `date`) VALUES
(9, 11, 11, 'Оцените меня=(', '2016-09-26 11:09:58'),
(10, 11, 11, 'гады\r\nпожалуйста', '2016-09-26 11:10:14'),
(11, 11, 12, 'да брось) всё круто)', '2016-09-26 11:11:56'),
(12, 11, 12, 'да брось) всё круто)', '2016-09-26 11:12:02'),
(13, 11, 12, 'да брось) всё круто)', '2016-09-26 11:12:08'),
(14, 11, 12, 'да брось) всё круто)', '2016-09-26 11:12:14'),
(15, 11, 12, 'да брось) всё круто)', '2016-09-26 11:12:23'),
(16, 11, 12, 'да брось) всё круто)', '2016-09-26 11:14:41'),
(17, 11, 12, 'да брось) всё круто)', '2016-09-26 11:15:15'),
(18, 11, 12, 'да брось) всё круто)', '2016-09-26 11:15:38'),
(19, 11, 12, 'да брось) всё круто)', '2016-09-26 11:15:49'),
(20, 11, 12, 'да брось) всё круто)', '2016-09-26 11:15:55'),
(21, 11, 12, 'да брось) всё круто)', '2016-09-26 11:17:37'),
(22, 11, 12, 'да брось) всё круто)', '2016-09-26 11:17:47'),
(23, 11, 12, 'да брось) всё круто)', '2016-09-26 11:17:53'),
(24, 11, 12, 'да брось) всё круто)', '2016-09-26 11:18:00'),
(25, 11, 12, 'да брось) всё круто)', '2016-09-26 11:18:06'),
(26, 11, 12, 'да брось) всё круто)', '2016-09-26 11:18:22');

-- --------------------------------------------------------

--
-- Структура таблицы `Karma`
--

CREATE TABLE IF NOT EXISTS `Karma` (
  `id_karma` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `karma` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Karma`
--

INSERT INTO `Karma` (`id_karma`, `id_user`, `karma`) VALUES
(5, 11, 2),
(6, 12, 2),
(7, 13, 0),
(8, 14, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `KarmaStory`
--

CREATE TABLE IF NOT EXISTS `KarmaStory` (
  `id_karmaStory` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_userFrom` int(11) NOT NULL,
  `Karma_change` tinyint(1) NOT NULL COMMENT '0-минус/ 1-плюс',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `KarmaStory`
--

INSERT INTO `KarmaStory` (`id_karmaStory`, `id_user`, `id_userFrom`, `Karma_change`, `date`) VALUES
(270, 11, 12, 1, '2016-09-26 11:18:21'),
(276, 12, 13, 1, '2016-09-26 11:26:10'),
(280, 11, 13, 1, '2016-09-26 11:27:35');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(16) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-парень 1-девушка',
  `foto` varchar(256) DEFAULT NULL,
  `date_birth` date NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `sex`, `foto`, `date_birth`, `password`) VALUES
(11, 'try2421', 1, './foto/try2421/plus.jpg', '2016-09-14', 'b451c8e84ac610e515e6898035b1fa2a'),
(12, 'scri10', 0, './foto/scri10/minus.png', '2016-09-03', 'b451c8e84ac610e515e6898035b1fa2a'),
(13, 'sav626', 0, './foto/sav626/default.jpg', '2016-09-19', 'b451c8e84ac610e515e6898035b1fa2a'),
(14, 'vadim', 1, './foto/vadim/default.jpg', '2016-09-15', 'b451c8e84ac610e515e6898035b1fa2a');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id_comments`);

--
-- Индексы таблицы `Karma`
--
ALTER TABLE `Karma`
  ADD PRIMARY KEY (`id_karma`);

--
-- Индексы таблицы `KarmaStory`
--
ALTER TABLE `KarmaStory`
  ADD PRIMARY KEY (`id_karmaStory`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id_comments` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT для таблицы `Karma`
--
ALTER TABLE `Karma`
  MODIFY `id_karma` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `KarmaStory`
--
ALTER TABLE `KarmaStory`
  MODIFY `id_karmaStory` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=281;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
