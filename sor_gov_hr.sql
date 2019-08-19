-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2019 at 03:27 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sor_gov_hr`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointmenttno` int(11) NOT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `rankid` int(11) DEFAULT NULL,
  `empstatusid` int(11) DEFAULT NULL,
  `salarygradeid` int(11) DEFAULT NULL,
  `emptype` varchar(1) DEFAULT NULL,
  `apptdate` date DEFAULT NULL,
  `campusid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointmenttno`, `employeeid`, `rankid`, `empstatusid`, `salarygradeid`, `emptype`, `apptdate`, `campusid`) VALUES
(9, 5, 1, 5, 2, 'T', '2002-02-22', NULL),
(8, 6, 1, 3, 2, 'T', '1111-11-11', NULL),
(7, 2, 1, 5, 2, 'T', '2018-02-01', 1),
(10, 6, 2, 5, 2, NULL, '2017-12-20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `campusid` int(11) NOT NULL,
  `campusname` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`campusid`, `campusname`) VALUES
(1, 'Sorsogon Campus'),
(2, 'Bulan Campus'),
(3, 'Magallanes'),
(4, 'Castilla');

-- --------------------------------------------------------

--
-- Table structure for table `educbackground`
--

CREATE TABLE `educbackground` (
  `employeeid` int(11) NOT NULL,
  `itemno` int(11) NOT NULL,
  `educlevel` varchar(30) DEFAULT NULL,
  `schoolname` varchar(75) DEFAULT NULL,
  `degree` varchar(75) DEFAULT NULL,
  `periodfrom` int(11) DEFAULT NULL,
  `periodto` int(11) DEFAULT NULL,
  `unitsearned` double DEFAULT NULL,
  `yrgraduate` int(11) DEFAULT NULL,
  `honors` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `educbackground`
--

INSERT INTO `educbackground` (`employeeid`, `itemno`, `educlevel`, `schoolname`, `degree`, `periodfrom`, `periodto`, `unitsearned`, `yrgraduate`, `honors`) VALUES
(2, 2, 'secondary', 'MATNOG NATIONAL HIGH SCHOOL', 'HIGH SCHOOL', 2008, 2012, 0, 2, ''),
(2, 1, 'elementary', 'POROPANDAN', 'ELEMENTARY', 2006, 2008, 0, 2008, 'SALUTATORIAN');

-- --------------------------------------------------------

--
-- Table structure for table `empchildren`
--

CREATE TABLE `empchildren` (
  `employeeid` int(11) NOT NULL,
  `itemno` int(11) NOT NULL,
  `childname` varchar(30) DEFAULT NULL,
  `birthdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empchildren`
--

INSERT INTO `empchildren` (`employeeid`, `itemno`, `childname`, `birthdate`) VALUES
(2, 10, 'CHILD 1', '2222-02-22'),
(2, 9, 'CHILD 2', '1111-11-11');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeid` int(11) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `midname` varchar(30) NOT NULL,
  `midinit` varchar(5) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(50) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `civilstatus` varchar(20) DEFAULT NULL,
  `height` varchar(6) DEFAULT NULL,
  `weight` varchar(6) DEFAULT NULL,
  `bloodtype` varchar(2) DEFAULT NULL,
  `gsisno` varchar(20) DEFAULT NULL,
  `pagibigno` varchar(20) DEFAULT NULL,
  `philhealthno` varchar(20) DEFAULT NULL,
  `sssno` varchar(20) DEFAULT NULL,
  `tinno` varchar(20) DEFAULT NULL,
  `agencyemployeeno` varchar(20) DEFAULT NULL,
  `citizenship` varchar(15) DEFAULT NULL,
  `residentialaddr1` varchar(30) DEFAULT NULL,
  `residentialaddr2` varchar(30) DEFAULT NULL,
  `residentialaddr3` varchar(30) DEFAULT NULL,
  `residentialaddr4` varchar(30) DEFAULT NULL,
  `reszipcode` varchar(5) DEFAULT NULL,
  `permanentaddr1` varchar(30) DEFAULT NULL,
  `permanentaddr2` varchar(30) DEFAULT NULL,
  `permanentaddr3` varchar(30) DEFAULT NULL,
  `permanentaddr4` varchar(30) DEFAULT NULL,
  `permzipcode` varchar(5) DEFAULT NULL,
  `telno` varchar(15) DEFAULT NULL,
  `mobileno` varchar(15) DEFAULT NULL,
  `emailaddr` varchar(30) DEFAULT NULL,
  `spouselname` varchar(30) DEFAULT NULL,
  `spousefname` varchar(30) DEFAULT NULL,
  `spousemname` varchar(30) DEFAULT NULL,
  `sp_occupation` varchar(30) DEFAULT NULL,
  `sp_employer` varchar(30) DEFAULT NULL,
  `sp_empraddr` varchar(30) DEFAULT NULL,
  `sp_emprtelno` varchar(15) DEFAULT NULL,
  `fatherlname` varchar(30) DEFAULT NULL,
  `fatherfname` varchar(30) DEFAULT NULL,
  `fathermname` varchar(30) DEFAULT NULL,
  `motherlname` varchar(30) DEFAULT NULL,
  `motherfname` varchar(30) DEFAULT NULL,
  `mothermname` varchar(30) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeid`, `lname`, `fname`, `midname`, `midinit`, `birthdate`, `birthplace`, `gender`, `civilstatus`, `height`, `weight`, `bloodtype`, `gsisno`, `pagibigno`, `philhealthno`, `sssno`, `tinno`, `agencyemployeeno`, `citizenship`, `residentialaddr1`, `residentialaddr2`, `residentialaddr3`, `residentialaddr4`, `reszipcode`, `permanentaddr1`, `permanentaddr2`, `permanentaddr3`, `permanentaddr4`, `permzipcode`, `telno`, `mobileno`, `emailaddr`, `spouselname`, `spousefname`, `spousemname`, `sp_occupation`, `sp_employer`, `sp_empraddr`, `sp_emprtelno`, `fatherlname`, `fatherfname`, `fathermname`, `motherlname`, `motherfname`, `mothermname`, `password`, `user_type`) VALUES
(1, 'ADMIN', 'ADMIN', 'ADMIN', 'A.', '1111-11-11', 'ADMIN', 'M', 'single', '', '62', 'O', '', '', '', '', '', '369', 'FILIPINO', 'QUEZON CITY', '', '', '', '0000', 'LAGUNA', '', '', '', '000', '', '', 'admin@yahoo.com', '', '', '', '', '', '', '', 'ASDASD', 'ASDASD', 'ASDASD', 'ASD', 'ASD', 'ASD', 'admin', 'admin'),
(2, 'GACIS', 'ANTHONY', 'SUMEGUIN', 'S.', '1111-11-11', 'QUEZON CITY', 'M', 'single', '', '62', '', '', '', '', '', '', '123', 'FILIPINO', 'ZONE 5, BULAN, SORSOGON', NULL, NULL, NULL, '4706', 'POROPANDAN', NULL, NULL, NULL, '4708', '', '', 'anthony.gacis@yahoo.com', '', '', '', '', '', '', '', 'ASDASD', 'ASDASD', 'ASDASD', 'ASD', 'ASD', 'ASD', 'sscgaming16', 'user'),
(6, 'ESTUR', 'MA. SYLISA', 'JAYLO', 'J.', '1967-07-14', 'SORSOGON', 'F', 'married', '', '', '', '', '', '', '', '', '670788153', 'FILIPINO', 'SAN JUAN', NULL, NULL, NULL, '4700', 'SAN JUAN', NULL, NULL, NULL, '4700', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018_dd5b5e6', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `empstatus`
--

CREATE TABLE `empstatus` (
  `empstatusid` int(11) NOT NULL,
  `statustitle` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empstatus`
--

INSERT INTO `empstatus` (`empstatusid`, `statustitle`) VALUES
(3, 'CASUAL'),
(5, 'CONTRACT OF SERVICE');

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

CREATE TABLE `license` (
  `employeeid` int(11) NOT NULL,
  `itemno` int(11) NOT NULL,
  `licensename` varchar(50) DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `examdate` date DEFAULT NULL,
  `place` varchar(30) DEFAULT NULL,
  `licenseno` varchar(30) DEFAULT NULL,
  `validdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`employeeid`, `itemno`, `licensename`, `rating`, `examdate`, `place`, `licenseno`, `validdate`) VALUES
(2, 3, 'PRC 1', 84, '2000-12-12', 'NAGA', '123456', '2018-05-12'),
(2, 2, 'PRC 1', 83, '2000-12-12', 'NAGA', '456789', '2018-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `rankid` int(11) NOT NULL,
  `ranktitle` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rankid`, `ranktitle`) VALUES
(1, 'INSTRUCTOR I'),
(2, 'INSTRUCTOR II');

-- --------------------------------------------------------

--
-- Table structure for table `salarygrade`
--

CREATE TABLE `salarygrade` (
  `salaryid` int(11) NOT NULL,
  `salarytitle` varchar(6) NOT NULL,
  `amount` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salarygrade`
--

INSERT INTO `salarygrade` (`salaryid`, `salarytitle`, `amount`) VALUES
(2, 'SG-1-1', 10510);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointmenttno`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`campusid`);

--
-- Indexes for table `educbackground`
--
ALTER TABLE `educbackground`
  ADD PRIMARY KEY (`employeeid`,`itemno`);

--
-- Indexes for table `empchildren`
--
ALTER TABLE `empchildren`
  ADD PRIMARY KEY (`itemno`,`employeeid`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeid`);

--
-- Indexes for table `empstatus`
--
ALTER TABLE `empstatus`
  ADD PRIMARY KEY (`empstatusid`);

--
-- Indexes for table `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`itemno`,`employeeid`);

--
-- Indexes for table `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`rankid`);

--
-- Indexes for table `salarygrade`
--
ALTER TABLE `salarygrade`
  ADD PRIMARY KEY (`salaryid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointmenttno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `campusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `educbackground`
--
ALTER TABLE `educbackground`
  MODIFY `itemno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `empchildren`
--
ALTER TABLE `empchildren`
  MODIFY `itemno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `empstatus`
--
ALTER TABLE `empstatus`
  MODIFY `empstatusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `itemno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rank`
--
ALTER TABLE `rank`
  MODIFY `rankid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `salarygrade`
--
ALTER TABLE `salarygrade`
  MODIFY `salaryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
