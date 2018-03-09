-- phpMyAdmin SQL Dump
-- version 4.3.9
-- http://www.phpmyadmin.net
--
-- Host: 
-- Generation Time: Dec 30, 2016 at 10:10 PM
-- Server version: 5.5.42
-- PHP Version: 5.4.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `F16336team2`
--

-- --------------------------------------------------------

--
-- Table structure for table `currency_exch`
--

CREATE TABLE IF NOT EXISTS `currency_exch` (
  `currency_pair` varchar(40) NOT NULL,
  `latest_spotrate` float NOT NULL,
  `latest_sp_m` double DEFAULT NULL,
  `buyer` varchar(40) DEFAULT NULL,
  `highest_bidp_m` double DEFAULT NULL,
  `curr_num_bids` int(40) DEFAULT NULL,
  `lowest_askp_m` double DEFAULT NULL,
  `curr_num_asks` int(40) DEFAULT NULL,
  `active_traders` int(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency_exch`
--

INSERT INTO `currency_exch` (`currency_pair`, `latest_spotrate`, `latest_sp_m`, `buyer`, `highest_bidp_m`, `curr_num_bids`, `lowest_askp_m`, `curr_num_asks`, `active_traders`) VALUES
('EURO-POUND', 1.18, 932.2, NULL, 0, 0, 0, 0, 0),
('RUPEE-EURO', 73.23, 68103.9, NULL, 0, 0, 0, 0, 0),
('RUPEE-POUND', 86.67, 68469.3, NULL, 0, 0, 0, 0, 0),
('RUPEE-USD', 68.04, 68040, NULL, 0, 0, 0, 0, 0),
('USD-EURO', 1.08, 1004.4, NULL, 0, 0, 0, 0, 0),
('USD-POUND', 1.27, 1003.3, NULL, 0, 0, 0, 0, 0),
('YEN-EURO', 122.26, 113701.8, NULL, 0, 0, 0, 0, 0),
('YEN-POUND', 144.8, 114392, NULL, 0, 0, 0, 0, 0),
('YEN-RUPEE', 1.67, 113626.8, NULL, 0, 0, 0, 0, 0),
('YEN-USD', 113.7, 113700, NULL, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `eu`
--

CREATE TABLE IF NOT EXISTS `eu` (
  `currency` varchar(40) NOT NULL,
  `ex_rate` float NOT NULL,
  `curr_sply_m` int(40) NOT NULL,
  `bond_sply_m` double NOT NULL,
  `coupon` float NOT NULL,
  `trade_sr_df_m` int(40) NOT NULL,
  `prime_ir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eu`
--

INSERT INTO `eu` (`currency`, `ex_rate`, `curr_sply_m`, `bond_sply_m`, `coupon`, `trade_sr_df_m`, `prime_ir`) VALUES
('EURO', 1, 13201, 9300, 2.15, 0, 0.72),
('POUND', 0.84, 4138, 1562.4, 1.44, -43, 0.2),
('RUPEE', 73.23, 5917, 136207.8, 7.02, 401, 6.2),
('USD', 1.08, 2421, 3013.2, 2.5, 214, 1.12),
('YEN', 122.26, 15421, 341105.4, 0.12, 821, 1.353);

-- --------------------------------------------------------

--
-- Table structure for table `exch_stream`
--

CREATE TABLE IF NOT EXISTS `exch_stream` (
  `country` varchar(40) NOT NULL,
  `trader_id` varchar(40) DEFAULT NULL,
  `bid_currency` int(11) DEFAULT NULL,
  `bid_rate` float DEFAULT NULL,
  `ask_currency` int(11) DEFAULT NULL,
  `ask_rate` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `india`
--

CREATE TABLE IF NOT EXISTS `india` (
  `currency` varchar(40) NOT NULL,
  `ex_rate` float NOT NULL,
  `curr_sply_m` int(40) NOT NULL,
  `bond_sply_m` double NOT NULL,
  `coupon` float NOT NULL,
  `trade_sr_df_m` int(40) NOT NULL,
  `prime_ir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `india`
--

INSERT INTO `india` (`currency`, `ex_rate`, `curr_sply_m`, `bond_sply_m`, `coupon`, `trade_sr_df_m`, `prime_ir`) VALUES
('EURO', 0.014, 2110, 952.56, 1.7, 114, 0.42),
('POUND', 0.012, 2636, 1632.96, 1.61, -116, 0.3),
('RUPEE', 1, 19140, 816480, 9.44, 0, 6.1),
('USD', 0.015, 2442, 1020.6, 3.49, -167, 2.8),
('YEN', 1.67, 8916, 340880.4, 1.4, 412, 0.65);

-- --------------------------------------------------------

--
-- Table structure for table `jp`
--

CREATE TABLE IF NOT EXISTS `jp` (
  `currency` varchar(40) NOT NULL,
  `ex_rate` float NOT NULL,
  `curr_sply_m` int(40) NOT NULL,
  `bond_sply_m` double NOT NULL,
  `coupon` float NOT NULL,
  `trade_sr_df_m` int(40) NOT NULL,
  `prime_ir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jp`
--

INSERT INTO `jp` (`currency`, `ex_rate`, `curr_sply_m`, `bond_sply_m`, `coupon`, `trade_sr_df_m`, `prime_ir`) VALUES
('EURO', 0.0082, 560, 2797.02, 1.4, -153, 0.1),
('POUND', 0.0069, 421, 784.53, 1.55, -91, 0.25),
('RUPEE', 0.6, 8240, 136440, 9.1, 536, 6.6),
('USD', 0.0088, 4249, 3001.68, 3.42, -125, 1.3),
('YEN', 1, 21192, 1137000, 1.45, 0, 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `uk`
--

CREATE TABLE IF NOT EXISTS `uk` (
  `currency` varchar(40) NOT NULL,
  `ex_rate` float NOT NULL,
  `curr_sply_m` int(40) NOT NULL,
  `bond_sply_m` double NOT NULL,
  `coupon` float NOT NULL,
  `trade_sr_df_m` int(40) NOT NULL,
  `prime_ir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uk`
--

INSERT INTO `uk` (`currency`, `ex_rate`, `curr_sply_m`, `bond_sply_m`, `coupon`, `trade_sr_df_m`, `prime_ir`) VALUES
('EURO', 1.18, 4713, 3728.8, 1.3, 244, 0.14),
('POUND', 1, 12492, 8690, 1.4, 0, 0.2),
('RUPEE', 86.67, 7721, 205407.9, 9.19, 433, 6.65),
('USD', 1.27, 3112, 2006.6, 3.2, 482, 2.1),
('YEN', 144.8, 8921, 114392, 1.13, 352, 0.39);

-- --------------------------------------------------------

--
-- Table structure for table `us`
--

CREATE TABLE IF NOT EXISTS `us` (
  `currency` varchar(40) NOT NULL,
  `ex_rate` float NOT NULL,
  `curr_sply_m` int(40) NOT NULL,
  `bond_sply_m` double NOT NULL,
  `coupon` float NOT NULL,
  `trade_sr_df_m` int(40) NOT NULL,
  `prime_ir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `us`
--

INSERT INTO `us` (`currency`, `ex_rate`, `curr_sply_m`, `bond_sply_m`, `coupon`, `trade_sr_df_m`, `prime_ir`) VALUES
('EURO', 0.93, 110, 1860, 1.2, 329, 0.17),
('POUND', 0.79, 2589, 3160, 1.5, -153, 0.25),
('RUPEE', 68.04, 7592, 68040, 8.2, 277, 6.3),
('USD', 1, 11820, 11000, 3.5, 0, 2.69),
('YEN', 113.7, 12710, 341100, 1.475, 135, 0.52);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currency_exch`
--
ALTER TABLE `currency_exch`
  ADD PRIMARY KEY (`currency_pair`);

--
-- Indexes for table `eu`
--
ALTER TABLE `eu`
  ADD PRIMARY KEY (`currency`);

--
-- Indexes for table `exch_stream`
--
ALTER TABLE `exch_stream`
  ADD PRIMARY KEY (`country`);

--
-- Indexes for table `india`
--
ALTER TABLE `india`
  ADD PRIMARY KEY (`currency`);

--
-- Indexes for table `jp`
--
ALTER TABLE `jp`
  ADD PRIMARY KEY (`currency`);

--
-- Indexes for table `uk`
--
ALTER TABLE `uk`
  ADD PRIMARY KEY (`currency`);

--
-- Indexes for table `us`
--
ALTER TABLE `us`
  ADD PRIMARY KEY (`currency`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
