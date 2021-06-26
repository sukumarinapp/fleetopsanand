-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2021 at 02:10 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fleetops`
--

-- --------------------------------------------------------

--
-- Table structure for table `can`
--

CREATE TABLE `can` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `can`
--

INSERT INTO `can` (`id`) VALUES
(1001),
(1002),
(1003),
(1004),
(1005);

-- --------------------------------------------------------

--
-- Table structure for table `current_location`
--

CREATE TABLE `current_location` (
  `id` int(11) NOT NULL,
  `terminal_id` varchar(20) DEFAULT NULL,
  `capture_date` date DEFAULT NULL,
  `capture_time` decimal(10,3) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `ground_speed` decimal(10,2) DEFAULT NULL,
  `odometer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `current_location`
--

INSERT INTO `current_location` (`id`, `terminal_id`, `capture_date`, `capture_time`, `latitude`, `longitude`, `ground_speed`, `odometer`) VALUES
(1, '12345', '2021-06-26', '134829.486', '1126.6639S', '11133.3299W', '50.22', 50000),
(2, '12346', '2021-06-26', '134829.486', '1126.6639S', '11133.3299W', '50.22', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `DNO` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DNM` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DSN` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DCN` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DLD` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VCC` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VBM` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VPF` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VPD` date DEFAULT NULL,
  `VAM` decimal(10,2) DEFAULT NULL,
  `LEX` date DEFAULT NULL,
  `CEX` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `DNO`, `DNM`, `DSN`, `DCN`, `DLD`, `VCC`, `VBM`, `VPF`, `VPD`, `VAM`, `LEX`, `CEX`, `created_at`, `updated_at`) VALUES
(3, '3432432', 'Santhosh', 'Henry', '321211312', '', '', 'Ride Hailing', 'Monthly', NULL, NULL, '2021-06-19', '2021-06-30', '2021-06-01 05:03:53', '2021-06-05 19:32:18'),
(6, '2323221', 'Sathish', 'Thomas', '23232132132', '', '', 'Rental/Hire Purchase', 'Monthly', NULL, NULL, NULL, NULL, '2021-06-05 19:32:44', '2021-06-05 19:32:59'),
(7, '1', '1', '1', '1', '', '', 'Rental/Hire Purchase', 'Monthly', NULL, NULL, '2021-06-15', '2021-06-30', '2021-06-06 20:39:39', '2021-06-06 20:41:51'),
(8, '2', '2', '2', '2', '', '', 'Rental/Hire Purchase', 'Monthly', NULL, NULL, '2021-06-30', '2021-06-30', '2021-06-06 20:42:28', '2021-06-06 20:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `driver_platform`
--

CREATE TABLE `driver_platform` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `PLF` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver_platform`
--

INSERT INTO `driver_platform` (`id`, `driver_id`, `PLF`) VALUES
(1, 1, '8'),
(3, 2, '8'),
(6, 5, '8'),
(9, 3, '12'),
(11, 6, '8'),
(13, 7, '8'),
(14, 8, '8');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `sms_id` varchar(10) DEFAULT NULL,
  `sms_text` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES
(1, 'SMSA01', 'Hi #{DNM}#, the early bird catches the worm. We encourage you to declare your sales early so that you can have enough time and room to work freely.\r\nPlease log into www.driver-sales.fleetopsgh.com and remember to input the vehicle number in the correct format (i.e., without signs and symbols, or punctuation marks) and use the phone\r\nnumber that has your active mobile money account for cash payment. Counting on your cooperation. Thanks.'),
(2, 'SMSA02', 'Hi #{DNM}#, your work is much appreciated by your car owner and sales declaration form an important part of this function. Please declare your sales.\r\nPlease log into www.driver-sales.fleetopsgh.com and remember to input the vehicle number in the correct format (i.e., without signs and symbols, or punctuation marks) and use the phone\r\nnumber that has your active mobile money account for cash payment. Counting on your cooperation. Thanks.'),
(3, 'SMSA03', 'Hi #{DNM}#, we have sent two reminders so far, but have still not received a reaction from you. To avoid any inconveniences please declare your sales now!.\r\nPlease log into www.driver-sales.fleetopsgh.com and remember to input the vehicle number in the correct format (i.e., without signs and symbols, or punctuation marks) and use the phone\r\nnumber that has your active mobile money account for cash payment. Counting on your cooperation. Thanks.'),
(4, 'SMSA04', '#{DNM}#, per agreement with your car owner we have been compelled to take the necessary actions to ensure you declare sales and submit cash collected to date. Your car owner has been\r\nnotified and has been advised to take the necessary actions with you. Declare your sales immediately to continue working.\r\nPlease log into www.driver-sales.fleetopsgh.com and remember to input the vehicle number in the correct format (i.e., without signs and symbols, or punctuation marks) and use the phone\r\nnumber that has your active mobile money account for cash payment. Counting on your cooperation. Thanks.'),
(5, 'SMSA05', 'Hi #{CZN}#, we wish to bring to your attention that your driver #{DNM}# using vehicle number #{VNO}#’ has failed to declare sales for work done as stated in your agreement with him/her. We have\r\nactivated our enforcement mechanisms to compel your driver to declare sales and submit cash collected. We advice that you contact him/her to comply else please take the necessary\r\nactions to safeguard your vehicle from abuse and inappropriate use. Thank you.'),
(6, 'SMSB06', 'Message Sent by Cash collection service provider.'),
(7, 'SMSB07', 'Hi, an amount of #{RMT}# has been received by FleetOps & Vantage. Your car owner will be notified accordingly. Thank you.'),
(8, 'SMSC08', 'Hi #{CZN}#, upon our investigation, we wish to bring to your attention that your driver #{DNM}# using vehicle number #{VNO}# has failed to fully declare sales for work done as per your agreement\r\nwith him/her. If this persists, we shall activate our enforcement mechanisms to compel your driver to render sales fully. We however entreat you to contact your driver to comply else\r\nplease take the necessary actions to safeguard your vehicle from abuse and inappropriate use. Thank you.'),
(9, 'SMSD09', 'Hi, please be informed that upon declaration of sales, your driver #{DNM}# using vehicle number #{VNO}# has consumed #{FTP}# amount of fuel and has incurred #{CWI}# of waste; this amount is\r\npotential revenue lost due to the use of your car for whatever reason other than generate revenue.'),
(10, 'SMSD10', 'Hi, please be informed that upon declaration of sales, you have consumed #{FTP}# amount of fuel and have incurred #{CWI}# of waste; this amount is potential revenue lost due to the use of the\r\ncar for whatever reason other than generate revenue. We entreat you to minimize losses by using the car for revenue generation purposes only as agreed with the car owner.'),
(11, 'SMSE11', 'Hi, please be informed that your driver #{DNM}# using vehicle number #{VNO}# has stated that he is unable to retrieve sales data from his phone. Accordingly, we have taken steps to investigate\r\nthe issue and have managed to derive the amount of #{CWI}# due for payment. Also, the driver consumed #{FTP}# amount of fuel. Thank you.');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@example.com', '$2y$10$.C8zR9BW4Ajrjg/TbfmVBepwQbVVV1AtbvdE3AWde65uZj8gC/.tW', '2021-05-22 05:29:45'),
('sukumar.inapp@gmaul.com', '$2y$10$bc4IowrQEaqFDZ6GvHTnIe4hT5J8eqpxCuaPpVqvhDY599LN4DFPy', '2021-05-22 05:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl136`
--

CREATE TABLE `tbl136` (
  `id` int(11) NOT NULL,
  `DDT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `DES` varchar(20) DEFAULT NULL,
  `DECL` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl136`
--

INSERT INTO `tbl136` (`id`, `DDT`, `CAN`, `VNO`, `DES`, `DECL`) VALUES
(1, '2021-06-10', 'C1001', 'TN75AC5778', 'A1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl137`
--

CREATE TABLE `tbl137` (
  `id` int(11) NOT NULL,
  `SDT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `CHR` decimal(10,2) DEFAULT NULL,
  `CML` decimal(10,2) DEFAULT NULL,
  `RCN` varchar(20) DEFAULT NULL,
  `RHN` int(11) DEFAULT NULL,
  `SPF` decimal(10,2) DEFAULT NULL,
  `CPF` decimal(10,2) DEFAULT NULL,
  `TPF` int(11) DEFAULT NULL,
  `SSR` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl137`
--

INSERT INTO `tbl137` (`id`, `SDT`, `CAN`, `VNO`, `CHR`, `CML`, `RCN`, `RHN`, `SPF`, `CPF`, `TPF`, `SSR`) VALUES
(5, '2021-06-07', 'C1001', 'TN75AC5778', '2.00', '100.00', '3432432', 12, '5000.00', '8000.00', 11, 'Sales Declaration'),
(6, '2021-06-08', 'C1001', 'TN75AC5778', '2.00', '100.00', '90477363245', 0, '0.00', '8000.00', 0, 'Help'),
(7, '2021-06-08', 'C1001', 'TN75AC5778', '2.00', '100.00', '90477363245', 0, '0.00', '8000.00', 0, 'Help'),
(8, '2021-06-08', 'C1001', 'TN75AC5778', '2.00', '100.00', '90477363245', 12, '5000.00', '5000.00', 10, 'Driver'),
(9, '2021-06-24', 'C1001', 'TN75AC5778', '2.00', '100.00', '3432', 12, '100.00', '100.00', 20, 'Driver');

-- --------------------------------------------------------

--
-- Table structure for table `tbl138`
--

CREATE TABLE `tbl138` (
  `id` int(11) NOT NULL,
  `RDT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `RCN` varchar(20) DEFAULT NULL,
  `RMT` decimal(10,2) DEFAULT 0.00,
  `ROI` varchar(20) DEFAULT NULL,
  `RTN` varchar(255) DEFAULT NULL,
  `RST` tinyint(1) DEFAULT 0,
  `SSR` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl139`
--

CREATE TABLE `tbl139` (
  `id` int(11) NOT NULL,
  `ODT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `FTP` decimal(10,2) DEFAULT 0.00,
  `CWI` decimal(10,2) DEFAULT 0.00,
  `FDT` date DEFAULT NULL,
  `FAN` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl141`
--

CREATE TABLE `tbl141` (
  `id` int(11) NOT NULL,
  `SDT` date DEFAULT NULL,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `RCN` varchar(20) DEFAULT NULL,
  `SSA` decimal(10,2) DEFAULT 0.00,
  `SSR` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl361`
--

CREATE TABLE `tbl361` (
  `id` int(11) NOT NULL,
  `RHN` varchar(50) DEFAULT NULL,
  `RMN` varchar(20) DEFAULT NULL,
  `RMS` varchar(20) DEFAULT NULL,
  `RML` varchar(20) DEFAULT NULL,
  `RHF` varchar(20) DEFAULT NULL,
  `RHT` varchar(500) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `can_delete` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl361`
--

INSERT INTO `tbl361` (`id`, `RHN`, `RMN`, `RMS`, `RML`, `RHF`, `RHT`, `status`, `can_delete`) VALUES
(1, 'FleetOps', '2', '11', '3', '4', 'N/A', 'Active', 0),
(8, 'Uber', '11', NULL, '11', '011', '11', 'Active', 1),
(12, 'OLA', '11', '11', '11', '11', '111', 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl494`
--

CREATE TABLE `tbl494` (
  `id` int(11) NOT NULL,
  `CWI_Z` varchar(20) DEFAULT NULL,
  `CWI_d` varchar(20) DEFAULT NULL,
  `CCEI_a` varchar(20) DEFAULT NULL,
  `CCEI_b` varchar(20) DEFAULT NULL,
  `CCEI_taSe` varchar(20) DEFAULT NULL,
  `CCEI_n` varchar(20) DEFAULT NULL,
  `CCEI_Xb` varchar(20) DEFAULT NULL,
  `CCEI_Sxx` varchar(20) DEFAULT NULL,
  `FPR` varchar(20) DEFAULT NULL,
  `NWM` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl494`
--

INSERT INTO `tbl494` (`id`, `CWI_Z`, `CWI_d`, `CCEI_a`, `CCEI_b`, `CCEI_taSe`, `CCEI_n`, `CCEI_Xb`, `CCEI_Sxx`, `FPR`, `NWM`) VALUES
(1, '0.063504', '0.07502121', '0.6367', '32.98', '68.396', '0.2', '175.526', '5407986.412', '10', '60');

-- --------------------------------------------------------

--
-- Table structure for table `tracker`
--

CREATE TABLE `tracker` (
  `id` int(11) NOT NULL,
  `veh_date` date DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `CML` decimal(10,2) DEFAULT NULL,
  `CHR` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tracker`
--

INSERT INTO `tracker` (`id`, `veh_date`, `VNO`, `CML`, `CHR`) VALUES
(1, '2021-06-02', 'TN75AC5778', '100.00', '2.00'),
(2, '2021-06-02', 'KAMP0946', '100.00', '2.00'),
(3, '2021-06-07', 'TN75AC5778', '100.00', '2.00'),
(4, '2021-06-07', 'KAMP0946', '100.00', '2.00'),
(5, '2021-06-08', 'TN75AC5778', '100.00', '2.00'),
(6, '2021-06-09', 'TN75AC5778', '100.00', '2.00'),
(7, '2021-06-10', 'TN75AC5778', '100.00', '2.00'),
(8, '2021-06-25', 'TN75AC5778', '100.00', '2.00'),
(9, '2021-06-24', 'TN75AC5778', '100.00', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `uan`
--

CREATE TABLE `uan` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uan`
--

INSERT INTO `uan` (`id`) VALUES
(1001),
(1002),
(1003),
(1004),
(1005),
(1006),
(1007),
(1008),
(1009),
(1010),
(1011),
(1012),
(1013),
(1014),
(1015);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `UAN` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name/Company Name',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Admin,Manager,Client',
  `UDT` date DEFAULT NULL COMMENT 'Register Date',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT 'UAM',
  `UJT` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User Job Title',
  `UZS` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Surname',
  `UZA` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Address',
  `UCN` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Contact Number',
  `CZN` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Contact Name',
  `CMT` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Client Account Type',
  `CMA` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Account Name',
  `CMN` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Account Number or Mobile Money Number',
  `CMB` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Account Branch or Mobile Money Service Provider',
  `UTV` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Activate Account',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `BPA` tinyint(1) NOT NULL DEFAULT 0,
  `BPB` tinyint(1) NOT NULL DEFAULT 0,
  `BPC` tinyint(1) NOT NULL DEFAULT 0,
  `BPD` tinyint(1) NOT NULL DEFAULT 0,
  `BPE` tinyint(1) NOT NULL DEFAULT 0,
  `BPF` tinyint(1) NOT NULL DEFAULT 0,
  `BPG` tinyint(1) NOT NULL DEFAULT 0,
  `BPH` tinyint(1) NOT NULL DEFAULT 0,
  `BPI` tinyint(1) NOT NULL DEFAULT 0,
  `BPJ` tinyint(1) NOT NULL DEFAULT 0,
  `BPJ1` tinyint(1) NOT NULL DEFAULT 0,
  `BPJ2` tinyint(1) NOT NULL DEFAULT 0,
  `BPK` tinyint(1) NOT NULL DEFAULT 0,
  `BPL` tinyint(1) NOT NULL DEFAULT 0,
  `RBA` tinyint(1) NOT NULL DEFAULT 0,
  `RBA1` tinyint(1) NOT NULL DEFAULT 0,
  `RBA2` tinyint(1) NOT NULL DEFAULT 0,
  `RBA3` tinyint(1) NOT NULL DEFAULT 0,
  `RBA4` tinyint(1) NOT NULL DEFAULT 0,
  `RBA4A` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RBB` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `UAN`, `name`, `email`, `usertype`, `UDT`, `parent_id`, `UJT`, `UZS`, `UZA`, `UCN`, `CZN`, `CMT`, `CMA`, `CMN`, `CMB`, `UTV`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `BPA`, `BPB`, `BPC`, `BPD`, `BPE`, `BPF`, `BPG`, `BPH`, `BPI`, `BPJ`, `BPJ1`, `BPJ2`, `BPK`, `BPL`, `RBA`, `RBA1`, `RBA2`, `RBA3`, `RBA4`, `RBA4A`, `RBB`) VALUES
(1, 'U0000', 'admin', 'admin@hubbleclicks.com', 'Admin', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$10$Rn114HHiwhOFFvmZP2/nR.x3QUoRWOQZO7Gm1qFHLjffmkevMm1m.', NULL, '2021-05-22 02:57:11', '2021-05-22 02:57:11', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', 0),
(8, 'U1001', 'Sukumar', 'sukumar@hubbleclicks.com', 'Manager', '2021-05-29', 1, 'SE', 'A', 'Bangalore', '877819392633', NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$10$sQrsJ8oO1U.SSqjsTdyojeC//TJoRd2Bq93hpkrwHzxVxVxkrD2WS', NULL, '2021-05-28 21:19:14', '2021-06-05 18:34:00', 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0),
(10, 'C1001', 'Hubble', 'anand@hubbleclicks.com', 'Client', '2021-05-29', 8, NULL, NULL, 'Bangalore', '9003552268', 'Anand', 'A', NULL, NULL, 'AIRTELTIGO', 1, NULL, '$2y$10$sPRZaBkQvYexTDaqUkDMdeV9uGwMO8qD9BAp6XFyEzJJreI7tPfMq', NULL, '2021-05-28 21:26:59', '2021-06-06 22:39:18', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0),
(11, 'U1002', 'Jino', 'universejino@hubbleclicks.com', 'Manager', '2021-05-29', 1, 'SE', 'A', 'pambanvilai\r\nAasaripallam', '+919047736314', NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$10$Rn114HHiwhOFFvmZP2/nR.x3QUoRWOQZO7Gm1qFHLjffmkevMm1m.', NULL, '2021-05-29 04:03:15', '2021-06-01 04:50:11', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0),
(28, 'U1015', 'Sukumar', 'sukumar.inapp@gmail.com', 'Manager', '2021-06-07', 1, 'SE', 'A', 'Nagercoil', '233206972360', NULL, NULL, NULL, NULL, NULL, 1, NULL, '$2y$10$494aatTdjkLpnzez0EDkP.siROlQAuZ735ln7qxzSulB5ZWVPqDEW', NULL, '2021-06-07 10:59:51', '2021-06-07 11:10:04', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `CAN` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `VDT` date DEFAULT NULL,
  `VNO` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VID` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VRD` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VMK` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VMD` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VCL` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ECY` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CON` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VFT` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VFC` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TSN` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TID` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TSM` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TIP` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VZC1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VZC0` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VBC1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VBC0` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VTV` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `CAN`, `driver_id`, `VDT`, `VNO`, `VID`, `VRD`, `VMK`, `VMD`, `VCL`, `ECY`, `CON`, `VFT`, `VFC`, `TSN`, `TID`, `TSM`, `TIP`, `VZC1`, `VZC0`, `VBC1`, `VBC0`, `VTV`, `created_at`, `updated_at`) VALUES
(1, 'C1001', 3, '2021-06-01', 'TN75AC5778', '1.pdf', '1.pdf', 'Ford', 'Mustang', 'Black', '30', '9958.0302771438', '30', '50', '131311', '12345', '32423332', '111.11.11.11', 'S111', 's333', 's222', 's444', 1, '2021-06-01 04:53:24', '2021-06-26 05:02:11'),
(6, 'C1001', NULL, '2021-06-06', 'KAMP0946', '6.pdf', '6.pdf', 'xxx', 'xxx', 'xxx', '50', '12981.843168913', '50', '50', '111', '12346', '111', '111', '111', '111', '111', '111', 0, '2021-06-05 19:34:09', '2021-06-26 05:05:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `can`
--
ALTER TABLE `can`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_location`
--
ALTER TABLE `current_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_platform`
--
ALTER TABLE `driver_platform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `tbl136`
--
ALTER TABLE `tbl136`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl137`
--
ALTER TABLE `tbl137`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl138`
--
ALTER TABLE `tbl138`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl139`
--
ALTER TABLE `tbl139`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl141`
--
ALTER TABLE `tbl141`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl361`
--
ALTER TABLE `tbl361`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl494`
--
ALTER TABLE `tbl494`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracker`
--
ALTER TABLE `tracker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uan`
--
ALTER TABLE `uan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `can`
--
ALTER TABLE `can`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- AUTO_INCREMENT for table `current_location`
--
ALTER TABLE `current_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `driver_platform`
--
ALTER TABLE `driver_platform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl136`
--
ALTER TABLE `tbl136`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl137`
--
ALTER TABLE `tbl137`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl138`
--
ALTER TABLE `tbl138`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl139`
--
ALTER TABLE `tbl139`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl141`
--
ALTER TABLE `tbl141`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl361`
--
ALTER TABLE `tbl361`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl494`
--
ALTER TABLE `tbl494`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tracker`
--
ALTER TABLE `tracker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `uan`
--
ALTER TABLE `uan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1016;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
