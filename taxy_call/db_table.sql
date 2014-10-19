-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: Oct 19, 2014 at 02:28 PM
-- Versiune server: 5.1.73
-- Versiune PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Baza de date: `price_compare`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone_nr` varchar(13) DEFAULT NULL,
  `long_lat_start` varchar(255) DEFAULT NULL,
  `long_lat_end` varchar(255) DEFAULT NULL,
  `total_km` varchar(255) DEFAULT NULL,
  `location_start` varchar(255) DEFAULT NULL,
  `location_end` varchar(255) DEFAULT NULL,
  `id_taxi` varchar(255) DEFAULT NULL,
  `id_comp` varchar(255) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `ip_adress` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `in_progress` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=346 ;

--
-- Salvarea datelor din tabel `orders`
--

INSERT INTO `orders` (`Id`, `customer_name`, `customer_phone_nr`, `long_lat_start`, `long_lat_end`, `total_km`, `location_start`, `location_end`, `id_taxi`, `id_comp`, `active`, `date`, `time`, `ip_adress`, `comment`, `in_progress`) VALUES
(342, 'test', '1231231233', '47.0772834,21.9167048', '47.0666579,21.9233770', '1.29', 'Transilvaniei 11 ,Oradea', 'Decebal 11 ,Oradea', '14', '1', 0, '2014-10-19', '14:11:35', '86.106.170.186', 'lkjkhkjhdjksjhsdhjhsdj', 1),
(343, 'mere', '3333333333', '47.0672553,21.9301383', '47.0673860,21.9292430', '0.07', 'Dacia 1 ,Oradea', 'Dacia 6 ,Oradea', '0', '1', 0, '2014-10-19', '14:13:54', '213.233.96.8', '007', 0),
(344, 'test1', '1231231231', '47.0672553,21.9301383', '47.0672553,21.9301383', '0.00', 'Dacia 1 ,Oradea', 'Dacia 1 ,Oradea', '14', '1', 0, '2014-10-19', '14:16:03', '213.233.96.8', '1231231231', 1),
(345, 'Adi Maduta', '0257171295', '47.1072544,21.8261371', '47.0657336,21.9411073', '9.86', 'Comuna Bors 1 ,Oradea', 'Frunzei 18 ,Oradea', '0', '1', 0, '2014-10-19', '14:21:15', '213.233.96.8', '', 0);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `report` char(250) COLLATE utf8_romanian_ci DEFAULT NULL,
  `name_driver` char(250) COLLATE utf8_romanian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Salvarea datelor din tabel `reports`
--

INSERT INTO `reports` (`report`, `name_driver`) VALUES
('test', 'George'),
('Merge', 'Chislachi Viorel'),
('Totul merge bine', 'George');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `street_name`
--

CREATE TABLE IF NOT EXISTS `street_name` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Salvarea datelor din tabel `street_name`
--

INSERT INTO `street_name` (`Id`, `name`, `country`, `active`) VALUES
(1, 'Transilvaniei', 'Bihor', 1),
(2, 'Decebal', 'Bihor', 1),
(3, 'Dacia', 'Bihor', 1),
(4, 'Comuna Bors', 'Bihor', 1),
(5, 'Frunzei', 'Bihor', 1),
(6, 'Gara', 'Bihor', 1),
(7, 'Hanul Pescarilor', 'Bihor', 1);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `taxi_comp`
--

CREATE TABLE IF NOT EXISTS `taxi_comp` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `day_price_km` decimal(10,2) DEFAULT NULL,
  `night_price_km` decimal(10,2) DEFAULT NULL,
  `active` int(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Salvarea datelor din tabel `taxi_comp`
--

INSERT INTO `taxi_comp` (`Id`, `company_name`, `logo`, `day_price_km`, `night_price_km`, `active`) VALUES
(1, 'Hello Taxi', 'hello_taxi.jpg', 1.62, 2.45, 1),
(2, 'Fulger Taxi', 'fulger_taxi.jpg', 1.68, 2.25, 1),
(3, 'Start Taxi', 'start_taxi.gif', 1.69, 2.69, 1),
(4, 'City Taxi', 'city_taxi.jpg', 1.60, 3.00, 1);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `taxi_drivers`
--

CREATE TABLE IF NOT EXISTS `taxi_drivers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_company` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `indicative` varchar(255) DEFAULT NULL,
  `drive` varchar(255) DEFAULT NULL,
  `active` int(1) unsigned DEFAULT NULL,
  `total_km` varchar(255) DEFAULT NULL,
  `total_money` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `work` int(11) unsigned NOT NULL DEFAULT '0',
  `consumer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Salvarea datelor din tabel `taxi_drivers`
--

INSERT INTO `taxi_drivers` (`Id`, `id_company`, `name`, `phone_number`, `indicative`, `drive`, `active`, `total_km`, `total_money`, `username`, `password`, `work`, `consumer`) VALUES
(20, '4', 'Ghita Grigore', '0770852792', '911', 'Audi A5', 0, '0', '0', 'grigorel', 'grigorel', 0, '5'),
(1, '2', 'Corneliu Razvan', '0742888769', '0691', 'Mercedes Benz', 1, '0', '0', 'cornel', 'cornel', 0, '5'),
(3, '0', 'Pop Victor', '0', '0', '0', 0, '0', '0', 'admin', 'admin', 0, '6'),
(9, '1', 'Adi Pavi', '0259411269', '1236', 'Mercedes', 1, '0', '0', 'star626', 'star1//', 0, '4'),
(19, '3', 'George', '0728901890', '091', 'Dacia 3000', 1, '0', '0', 'george', 'george', 0, '5'),
(13, '2', 'Pop Mihai', '0675667556', '334', 'Dacia Solenza', 1, '0', '0', 'mihaip', 'mihaip', 0, '5'),
(14, '1', 'Chislachi Viorel', '0877675565', '233', 'Mercedes Benz', 1, '0', '0', 'viorel', 'viorel', 0, '4'),
(15, '3', 'Victors Serban', '0786656655', '244', 'Audi A5', 1, '0', '0', 'serban22', 'serban22', 0, '6'),
(16, '2', 'Tudorica Sebastian', '1222322343', '666', 'Mercedes Benz', 1, '0', '0', 'sebastian12', 'sebastian12', 0, '6'),
(17, '2', 'Popica Victoras', '0786556445', '223', 'Audi A8', 1, '0', '0', 'victoras22', 'victoras22', 0, '6');
