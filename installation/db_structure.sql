-- --------------------------------------------------------
-- Värd:                         127.0.0.1
-- Serverversion:                5.7.33 - MySQL Community Server (GPL)
-- Server-OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumpar databasstruktur för db_periodia
CREATE DATABASE IF NOT EXISTS `db_periodia` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_periodia`;

-- Dumpar data för tabell db_periodia.tbl_absence: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_absence` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_absence` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_absencetype: ~5 rows (ungefär)
/*!40000 ALTER TABLE `tbl_absencetype` DISABLE KEYS */;
INSERT INTO `tbl_absencetype` (`abt_ID`, `abt_name`) VALUES
	(1, 'Föräldraledighet'),
	(2, 'Sjuk'),
	(3, 'Tjänstledig'),
	(4, 'Övrig frånvaro'),
	(5, 'Semester');
/*!40000 ALTER TABLE `tbl_absencetype` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_activity: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_activity` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_checkin: 0 rows
/*!40000 ALTER TABLE `tbl_checkin` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_checkin` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_company: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_company` DISABLE KEYS */;
INSERT INTO `tbl_company` (`co_ID`, `co_name`, `co_orgnbr`, `co_description`, `co_startdate`, `co_enddate`, `co_isactive`) VALUES
	(1, 'Företaget AA', NULL, NULL, '2022-02-23', '2022-02-23', 1),
	(2, 'Företaget BB', NULL, NULL, '2022-02-23', '2022-02-23', 1);
/*!40000 ALTER TABLE `tbl_company` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_customer: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_employees: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_employees` DISABLE KEYS */;
INSERT INTO `tbl_employees` (`em_companyID`, `em_userID`) VALUES
	(1, 1),
	(1, 2),
	(2, 3);
/*!40000 ALTER TABLE `tbl_employees` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_fuel: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_fuel` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_fuel` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_image: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_image` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_machine: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_machine` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_machine` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_materials: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_materials` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_materials` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_milestone: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_milestone` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_milestone` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_notes: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_notes` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_project: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_project` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_role: ~3 rows (ungefär)
/*!40000 ALTER TABLE `tbl_role` DISABLE KEYS */;
INSERT INTO `tbl_role` (`ro_ID`, `ro_name`) VALUES
	(1, 'superuser'),
	(2, 'admin'),
	(3, 'user');
/*!40000 ALTER TABLE `tbl_role` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_status: ~5 rows (ungefär)
/*!40000 ALTER TABLE `tbl_status` DISABLE KEYS */;
INSERT INTO `tbl_status` (`st_ID`, `st_name`, `st_hex`) VALUES
	(1, 'Nytt', '63B3D3'),
	(2, 'Pågående', 'FB8334'),
	(3, 'Klart', '4BA33B'),
	(4, 'Avvikelse', 'DB5383'),
	(5, 'Arkiverad', '9F9F9F');
/*!40000 ALTER TABLE `tbl_status` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_tools: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_tools` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_tools` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_user: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` (`us_ID`, `us_employeenr`, `us_pnr`, `us_username`, `us_password`, `us_fname`, `us_lname`, `us_infotext`, `us_address1`, `us_address2`, `us_zip`, `us_city`, `us_email`, `us_phone1`, `us_phone2`, `us_clearingnr`, `us_accountnr`, `us_roleID`, `us_isactive`, `us_created`) VALUES
	(1, NULL, NULL, 'test1', 'test1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, NULL),
	(2, NULL, NULL, 'test2', 'test2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL),
	(3, NULL, NULL, 'test3', 'test3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, NULL);
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_vehicle: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_vehicle` ENABLE KEYS */;

-- Dumpar data för tabell db_periodia.tbl_workinghours: ~0 rows (ungefär)
/*!40000 ALTER TABLE `tbl_workinghours` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_workinghours` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
