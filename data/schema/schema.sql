CREATE DATABASE `gallery` COLLATE 'utf8_general_ci';

CREATE TABLE `album` (
  `id` int NOT NULL COMMENT 'Id альбома' AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Название альбома',
  `description` varchar(200) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Описание альбома',
  `photographer` varchar(50) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Имя фотографа',
  `email` varchar(100) COLLATE 'utf8_general_ci' NULL COMMENT 'Адрес электронной почты фотографа',
  `phone` varchar(18) COLLATE 'utf8_general_ci' NULL COMMENT 'Телефон фотографа',
  `creation_date` date NOT NULL COMMENT 'Дата создания альбома',
  `change_date` date NOT NULL COMMENT 'Дата изменения информации альбома',
  `last_upload_photo` datetime NULL COMMENT 'Дата и время добавления последней фотогрфии',
  `count_photo` int NULL COMMENT 'Количество фотографий в альбоме'
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

CREATE TABLE `photo` (
  `id` int NOT NULL COMMENT 'Id фотографии' AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(50) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Заголовок фотографии',
  `address` varchar(200) COLLATE 'utf8_general_ci' NULL COMMENT 'Адрес фотосъемки',
  `file` text NOT NULL COMMENT 'Загружаемый файл',
  `upload_date` date NOT NULL COMMENT 'Дата добавления фотографии в альбом',
  `album_id` int(11) NOT NULL COMMENT 'Id альбома',
  FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';

