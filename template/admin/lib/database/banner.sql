-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 18 2015 г., 13:49
-- Версия сервера: 5.6.21
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `banner`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
`banner_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `width` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `display` varchar(255) NOT NULL,
  `banner_body` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `banners`
--

INSERT INTO `banners` (`banner_id`, `name`, `width`, `height`, `display`, `banner_body`) VALUES
(1, 'magento', '560', '130', 'none', '<a title="magento" href="http://templatemonster.me.uk">\r\n<img title="magento-banner" src="http://www.templatemonster.me.uk/images/promo/magento_banner.jpg"></a>'),
(2, 'opencart', '600', '225', 'block', '<a title="opencart" href="http://blog.tmimgcdn.com"><img title="OpenCart" src="http://blog.tmimgcdn.com/wp-content/uploads/2012/03/OpenCart-Presentation-Banner.jpg?e5af13"></a>'),
(3, 'charity', '635', '235', 'block', '<a title="charity" href="http://blog.tmimgcdn.com">\r\n<img title="Charity" src="http://blog.tmimgcdn.com/wp-content/uploads/2012/03/Banner1.jpg?9d7bd4"></a>'),
(4, 'facebook', '600', '220', 'none', '<a title="facebook" href="http://blog.templatemonster.com">\r\n<img title="fb_templates" src="http://blog.templatemonster.com/wp-content/uploads/2011/06/facebook-templates-discount-banner.jpg"></a>'),
(5, 'valentine', '620', '350', 'none', '<a title="valentine" href="http://cdn.designrshub.com">\r\n<img title="designrshub" src="http://cdn.designrshub.com/wp-content/uploads/2013/02/valentine-giveaway-620x350.jpg"></a>'),
(6, 'template', '550', '180', 'block', '<a title="template" href="http://templatemonster.com">\r\n<img title="TM-logo" src="http://www.microsoft.com/web/locale/en-us/media/webmatrix/partners/Templatemonster.png"></a>');

-- --------------------------------------------------------

--
-- Структура таблицы `banner_author`
--

CREATE TABLE IF NOT EXISTS `banner_author` (
  `id_ban` int(255) NOT NULL,
  `id_author` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `banner_author`
--

INSERT INTO `banner_author` (`id_ban`, `id_author`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 1),
(5, 1),
(6, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `banner_url`
--

CREATE TABLE IF NOT EXISTS `banner_url` (
  `id_url` int(255) NOT NULL,
  `id_banner` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `banner_url`
--

INSERT INTO `banner_url` (`id_url`, `id_banner`) VALUES
(1, 2),
(1, 3),
(3, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `urls`
--

CREATE TABLE IF NOT EXISTS `urls` (
`url_id` int(255) NOT NULL,
  `page_address` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `urls`
--

INSERT INTO `urls` (`url_id`, `page_address`) VALUES
(1, 'index'),
(2, 'about'),
(3, 'templates'),
(4, 'category'),
(5, 'contact'),
(6, 'none');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`) VALUES
(1, 'Denis', '0000'),
(2, 'Paul', '1111');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `banners`
--
ALTER TABLE `banners`
 ADD PRIMARY KEY (`banner_id`), ADD UNIQUE KEY `banner_id_2` (`banner_id`), ADD KEY `banner_id` (`banner_id`);

--
-- Индексы таблицы `banner_author`
--
ALTER TABLE `banner_author`
 ADD KEY `id_ban` (`id_ban`,`id_author`), ADD KEY `id_author` (`id_author`);

--
-- Индексы таблицы `banner_url`
--
ALTER TABLE `banner_url`
 ADD KEY `id_url` (`id_url`,`id_banner`), ADD KEY `id_banner` (`id_banner`), ADD KEY `id_url_2` (`id_url`,`id_banner`);

--
-- Индексы таблицы `urls`
--
ALTER TABLE `urls`
 ADD PRIMARY KEY (`url_id`), ADD KEY `url_id` (`url_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `banners`
--
ALTER TABLE `banners`
MODIFY `banner_id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `urls`
--
ALTER TABLE `urls`
MODIFY `url_id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
