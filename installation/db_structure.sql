-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 16 dec 2020 kl 11:56
-- Serverversion: 10.4.14-MariaDB
-- PHP-version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `periodiadb`
--
CREATE DATABASE IF NOT EXISTS `periodiadb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `periodiadb`;

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_absence`
--

CREATE TABLE `tbl_absence` (
  `ab_ID` int(11) NOT NULL,
  `ab_userID` int(11) NOT NULL COMMENT 'användare',
  `ab_startdate` date DEFAULT NULL COMMENT 'startdatum',
  `ab_enddate` date DEFAULT NULL COMMENT 'slutdatum',
  `ab_hours` varchar(2) DEFAULT NULL COMMENT 'timmar/dag',
  `ab_percent` varchar(3) DEFAULT NULL COMMENT 'procent/dag',
  `ab_notes` varchar(300) DEFAULT NULL COMMENT 'noteringar',
  `ab_type` int(11) NOT NULL COMMENT 'frånvarotyp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_absencetype`
--

CREATE TABLE `tbl_absencetype` (
  `abt_ID` int(11) NOT NULL,
  `abt_name` varchar(30) NOT NULL COMMENT 'frånvarotyp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumpning av Data i tabell `tbl_absencetype`
--

INSERT INTO `tbl_absencetype` (`abt_ID`, `abt_name`) VALUES
(1, 'Föräldraledighet'),
(2, 'Sjuk'),
(3, 'Tjänstledig'),
(4, 'Övrig frånvaro'),
(5, 'Semester');

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_activity`
--

CREATE TABLE `tbl_activity` (
  `ac_ID` int(11) NOT NULL,
  `ac_name` varchar(30) NOT NULL COMMENT 'aktivitet'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_company`
--

CREATE TABLE `tbl_company` (
  `co_ID` int(11) NOT NULL,
  `co_name` varchar(50) NOT NULL COMMENT 'företagsnamn',
  `co_orgnbr` varchar(11) DEFAULT NULL COMMENT 'organisationsnummer',
  `co_description` varchar(300) DEFAULT NULL COMMENT 'beskrivning',
  `co_startdate` date DEFAULT NULL COMMENT 'startdatum',
  `co_enddate` date DEFAULT NULL COMMENT 'slutdatum',
  `co_isactive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'företag aktiverat'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tbl_company`
--

INSERT INTO `tbl_company` (`co_ID`, `co_name`, `co_orgnbr`, `co_description`, `co_startdate`, `co_enddate`, `co_isactive`) VALUES
(1, 'Företaget AB', '202015-1234', 'Adress:\r\nFöretagsgatan 15\r\n123 45 Storstaden', '2020-07-30', NULL, 1),
(2, 'Snålis AB', NULL, NULL, '2020-08-03', NULL, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `cu_ID` int(11) NOT NULL,
  `cu_contractID` varchar(30) DEFAULT NULL COMMENT 'eget avtalsnummer',
  `cu_name` varchar(30) NOT NULL COMMENT 'kundnamn',
  `cu_description` varchar(300) DEFAULT NULL COMMENT 'beskrivning',
  `cu_isactive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'kunden aktiv'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_employees`
--

CREATE TABLE `tbl_employees` (
  `em_companyID` int(11) NOT NULL COMMENT 'företag',
  `em_userID` int(11) NOT NULL COMMENT 'användare'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tbl_employees`
--

INSERT INTO `tbl_employees` (`em_companyID`, `em_userID`) VALUES
(1, 2),
(1, 3),
(2, 16);

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_image`
--

CREATE TABLE `tbl_image` (
  `im_ID` int(11) NOT NULL,
  `im_date` date NOT NULL COMMENT 'uppladdningsdatum',
  `im_filename` varchar(30) NOT NULL COMMENT 'filnamn',
  `im_fileextension` varchar(5) NOT NULL COMMENT 'filändelse',
  `im_filepath` varchar(300) NOT NULL COMMENT 'bildens sökväg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_machine`
--

CREATE TABLE `tbl_machine` (
  `ma_ID` int(11) NOT NULL,
  `ma_name` varchar(30) NOT NULL,
  `ma_regnr` varchar(10) DEFAULT NULL COMMENT 'Registreringsnummer',
  `ma_description` varchar(300) DEFAULT NULL,
  `ma_mileage` varchar(10) DEFAULT NULL,
  `ma_hours` varchar(10) DEFAULT NULL,
  `ma_status` varchar(20) NOT NULL,
  `ma_owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tbl_machine`
--

INSERT INTO `tbl_machine` (`ma_ID`, `ma_name`, `ma_regnr`, `ma_description`, `ma_mileage`, `ma_hours`, `ma_status`, `ma_owner`) VALUES
(1, 'Doosan 140LC', 'LBH 450', NULL, '6522', '4235', '1', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_milestone`
--

CREATE TABLE `tbl_milestone` (
  `mi_ID` int(11) NOT NULL,
  `mi_name` varchar(30) NOT NULL,
  `mi_description` varchar(300) DEFAULT NULL,
  `mi_startdate` date NOT NULL,
  `mi_enddate` date DEFAULT NULL,
  `mi_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_notes`
--

CREATE TABLE `tbl_notes` (
  `no_ID` int(11) NOT NULL,
  `no_created` date NOT NULL COMMENT 'Skapad',
  `no_content` varchar(50) NOT NULL COMMENT 'Innehåll',
  `no_userID` int(11) NOT NULL COMMENT 'Skriven av'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_project`
--

CREATE TABLE `tbl_project` (
  `pr_ID` int(11) NOT NULL,
  `pr_internID` varchar(20) DEFAULT NULL COMMENT 'eget ID',
  `pr_name` varchar(30) NOT NULL COMMENT 'projektnamn',
  `pr_description` varchar(300) DEFAULT NULL COMMENT 'beskrivning',
  `pr_startdate` date NOT NULL COMMENT 'startdatum',
  `pr_enddate` date DEFAULT NULL COMMENT 'slutdatum',
  `pr_status` int(11) NOT NULL DEFAULT 1 COMMENT 'projektstatus',
  `pr_billed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'faktuerad',
  `pr_billdate` date DEFAULT NULL COMMENT 'fakturadatum',
  `pr_companyID` int(11) NOT NULL COMMENT 'tillhör företag'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tbl_project`
--

INSERT INTO `tbl_project` (`pr_ID`, `pr_internID`, `pr_name`, `pr_description`, `pr_startdate`, `pr_enddate`, `pr_status`, `pr_billed`, `pr_billdate`, `pr_companyID`) VALUES
(1, '', 'Kabelgrävning, Gällivare', '', '2020-10-05', '2020-10-22', 5, 0, '0000-00-00', 2),
(2, NULL, 'väg, lillström 146', NULL, '2020-08-13', NULL, 2, 0, NULL, 1),
(3, '1122', 'markarbete, kovland', NULL, '2020-09-02', '2020-09-08', 3, 0, NULL, 1),
(4, '', 'Dränering, Granlo', '', '2020-08-11', '2020-08-14', 5, 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_role`
--

CREATE TABLE `tbl_role` (
  `ro_ID` int(11) NOT NULL,
  `ro_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tbl_role`
--

INSERT INTO `tbl_role` (`ro_ID`, `ro_name`) VALUES
(1, 'superuser'),
(2, 'admin'),
(3, 'user');

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_status`
--

CREATE TABLE `tbl_status` (
  `st_ID` int(11) NOT NULL,
  `st_name` varchar(30) NOT NULL,
  `st_hex` varchar(6) NOT NULL COMMENT 'Färg för status'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tbl_status`
--

INSERT INTO `tbl_status` (`st_ID`, `st_name`, `st_hex`) VALUES
(1, 'Nytt', '63B3D3'),
(2, 'Pågående', 'FB8334'),
(3, 'Klart', '4BA33B'),
(4, 'Avvikelse', 'DB5383'),
(5, 'Arkiverad', '9F9F9F');

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_user`
--

CREATE TABLE `tbl_user` (
  `us_ID` int(11) NOT NULL,
  `us_username` varchar(20) NOT NULL COMMENT 'användarnamn',
  `us_password` varchar(255) NOT NULL COMMENT 'lösenord',
  `us_fname` varchar(30) DEFAULT NULL COMMENT 'förnamn',
  `us_lname` varchar(30) DEFAULT NULL COMMENT 'efternamn',
  `us_email` varchar(30) DEFAULT NULL COMMENT 'epost',
  `us_phone1` varchar(20) DEFAULT NULL COMMENT 'telefon1',
  `us_phone2` varchar(20) DEFAULT NULL COMMENT 'telefon2',
  `us_roleID` int(11) NOT NULL COMMENT 'begränsning',
  `us_isactive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'användare aktiv',
  `us_created` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tbl_user`
--

INSERT INTO `tbl_user` (`us_ID`, `us_username`, `us_password`, `us_fname`, `us_lname`, `us_email`, `us_phone1`, `us_phone2`, `us_roleID`, `us_isactive`, `us_created`) VALUES
(1, 'plana_admin', '1234', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL),
(2, 'test1', 'test1', 'Kalle', 'Andersson', '', '040-123456', '', 2, 1, NULL),
(3, 'test2', 'test2', '', '', '', '', '', 3, 1, NULL),
(16, 'test3', 'test3', '', '', '', '', '', 3, 1, NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur `tbl_workinghours`
--

CREATE TABLE `tbl_workinghours` (
  `wo_ID` int(11) NOT NULL,
  `wo_userID` int(11) NOT NULL COMMENT 'användar id',
  `wo_date` date NOT NULL,
  `wo_starttime` varchar(5) NOT NULL COMMENT 'starttid',
  `wo_endtime` varchar(5) NOT NULL COMMENT 'sluttid',
  `wo_rest` varchar(5) NOT NULL COMMENT 'paus',
  `wo_total` varchar(5) NOT NULL,
  `wo_notes` varchar(250) DEFAULT NULL,
  `wo_projectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `tbl_workinghours`
--

INSERT INTO `tbl_workinghours` (`wo_ID`, `wo_userID`, `wo_date`, `wo_starttime`, `wo_endtime`, `wo_rest`, `wo_total`, `wo_notes`, `wo_projectID`) VALUES
(24, 2, '2020-09-28', '07:00', '16:00', '01:00', '08:00', '', 1),
(31, 2, '2020-10-20', '07:00', '16:00', '01:00', '08:00', '', 2),
(45, 2, '2020-10-19', '07:30', '16:00', '01:00', '07:30', '', 4),
(46, 2, '2020-10-21', '07:20', '16:00', '01:00', '07:40', '', 4);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `tbl_absence`
--
ALTER TABLE `tbl_absence`
  ADD PRIMARY KEY (`ab_ID`),
  ADD KEY `tbl_ab_ab_ID tbl_abt_abt_ID` (`ab_type`),
  ADD KEY `tbl_absence_ab_ID tbl_user_us_ID` (`ab_userID`);

--
-- Index för tabell `tbl_absencetype`
--
ALTER TABLE `tbl_absencetype`
  ADD PRIMARY KEY (`abt_ID`);

--
-- Index för tabell `tbl_activity`
--
ALTER TABLE `tbl_activity`
  ADD PRIMARY KEY (`ac_ID`);

--
-- Index för tabell `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`co_ID`);

--
-- Index för tabell `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`cu_ID`);

--
-- Index för tabell `tbl_employees`
--
ALTER TABLE `tbl_employees`
  ADD PRIMARY KEY (`em_companyID`,`em_userID`),
  ADD KEY `tbl_employees_em_userID tbl_user_us_ID` (`em_userID`);

--
-- Index för tabell `tbl_image`
--
ALTER TABLE `tbl_image`
  ADD PRIMARY KEY (`im_ID`);

--
-- Index för tabell `tbl_machine`
--
ALTER TABLE `tbl_machine`
  ADD PRIMARY KEY (`ma_ID`),
  ADD KEY `tbl_machines_ma_owner tbl_company_co_ID` (`ma_owner`);

--
-- Index för tabell `tbl_milestone`
--
ALTER TABLE `tbl_milestone`
  ADD PRIMARY KEY (`mi_ID`);

--
-- Index för tabell `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD PRIMARY KEY (`no_ID`);

--
-- Index för tabell `tbl_project`
--
ALTER TABLE `tbl_project`
  ADD PRIMARY KEY (`pr_ID`),
  ADD KEY `tbl_project_pr_status tbl_status_st_ID` (`pr_status`),
  ADD KEY `tbl_project_pr_companyID tbl_company_co_ID` (`pr_companyID`);

--
-- Index för tabell `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`ro_ID`);

--
-- Index för tabell `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`st_ID`);

--
-- Index för tabell `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`us_ID`);

--
-- Index för tabell `tbl_workinghours`
--
ALTER TABLE `tbl_workinghours`
  ADD PRIMARY KEY (`wo_ID`),
  ADD KEY `tbl_workinghours_wo_ID tbl_project_pr_ID` (`wo_projectID`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `tbl_absence`
--
ALTER TABLE `tbl_absence`
  MODIFY `ab_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `tbl_absencetype`
--
ALTER TABLE `tbl_absencetype`
  MODIFY `abt_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `tbl_activity`
--
ALTER TABLE `tbl_activity`
  MODIFY `ac_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `co_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `cu_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `tbl_image`
--
ALTER TABLE `tbl_image`
  MODIFY `im_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `tbl_machine`
--
ALTER TABLE `tbl_machine`
  MODIFY `ma_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `tbl_milestone`
--
ALTER TABLE `tbl_milestone`
  MODIFY `mi_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `tbl_notes`
--
ALTER TABLE `tbl_notes`
  MODIFY `no_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `tbl_project`
--
ALTER TABLE `tbl_project`
  MODIFY `pr_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT för tabell `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `ro_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `st_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `us_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT för tabell `tbl_workinghours`
--
ALTER TABLE `tbl_workinghours`
  MODIFY `wo_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `tbl_absence`
--
ALTER TABLE `tbl_absence`
  ADD CONSTRAINT `tbl_ab_ab_ID tbl_abt_abt_ID` FOREIGN KEY (`ab_type`) REFERENCES `tbl_absencetype` (`abt_ID`),
  ADD CONSTRAINT `tbl_absence_ab_ID tbl_user_us_ID` FOREIGN KEY (`ab_userID`) REFERENCES `tbl_user` (`us_ID`);

--
-- Restriktioner för tabell `tbl_employees`
--
ALTER TABLE `tbl_employees`
  ADD CONSTRAINT `tbl_employees_em_companyID tbl_company_co_ID` FOREIGN KEY (`em_companyID`) REFERENCES `tbl_company` (`co_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_employees_em_userID tbl_user_us_ID` FOREIGN KEY (`em_userID`) REFERENCES `tbl_user` (`us_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `tbl_machine`
--
ALTER TABLE `tbl_machine`
  ADD CONSTRAINT `tbl_machines_ma_owner tbl_company_co_ID` FOREIGN KEY (`ma_owner`) REFERENCES `tbl_company` (`co_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `tbl_project`
--
ALTER TABLE `tbl_project`
  ADD CONSTRAINT `tbl_project_pr_companyID tbl_company_co_ID` FOREIGN KEY (`pr_companyID`) REFERENCES `tbl_company` (`co_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_project_pr_status tbl_status_st_ID` FOREIGN KEY (`pr_status`) REFERENCES `tbl_status` (`st_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriktioner för tabell `tbl_workinghours`
--
ALTER TABLE `tbl_workinghours`
  ADD CONSTRAINT `tbl_workinghours_wo_ID tbl_project_pr_ID` FOREIGN KEY (`wo_projectID`) REFERENCES `tbl_project` (`pr_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
