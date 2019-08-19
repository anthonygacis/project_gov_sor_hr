-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2019 at 12:57 AM
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
  `employeeid` int(11) NOT NULL,
  `rankid` int(11) DEFAULT NULL,
  `empstatusid` int(11) DEFAULT NULL,
  `salarygradeid` int(11) DEFAULT NULL,
  `emptype` varchar(1) DEFAULT NULL,
  `apptdate` date DEFAULT NULL,
  `campusid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `unitsearned` varchar(10) DEFAULT NULL,
  `yrgraduate` int(11) DEFAULT NULL,
  `honors` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `educbackground`
--

INSERT INTO `educbackground` (`employeeid`, `itemno`, `educlevel`, `schoolname`, `degree`, `periodfrom`, `periodto`, `unitsearned`, `yrgraduate`, `honors`) VALUES
(6, 3, 'elementary', '123123', '123123', 2010, 2015, '1', 2, ''),
(6, 5, 'secondary', 'QWEQWEQWE', 'QWEQWEQWE', 2012, 2016, '2', 2, ''),
(6, 6, 'college', 'ASDASD', 'ASDASD', 2016, 2019, '3', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `empchildren`
--

CREATE TABLE `empchildren` (
  `employeeid` int(11) NOT NULL,
  `itemno` int(11) NOT NULL,
  `childname` varchar(30) DEFAULT NULL,
  `birthdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `mothermname` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeid`, `lname`, `fname`, `midname`, `midinit`, `birthdate`, `birthplace`, `gender`, `civilstatus`, `height`, `weight`, `bloodtype`, `gsisno`, `pagibigno`, `philhealthno`, `sssno`, `tinno`, `agencyemployeeno`, `citizenship`, `residentialaddr1`, `residentialaddr2`, `residentialaddr3`, `residentialaddr4`, `reszipcode`, `permanentaddr1`, `permanentaddr2`, `permanentaddr3`, `permanentaddr4`, `permzipcode`, `telno`, `mobileno`, `emailaddr`, `spouselname`, `spousefname`, `spousemname`, `sp_occupation`, `sp_employer`, `sp_empraddr`, `sp_emprtelno`, `fatherlname`, `fatherfname`, `fathermname`, `motherlname`, `motherfname`, `mothermname`) VALUES
(6, 'ESTUR', 'MA. SYLISA', 'JAYLO', 'J.', '1967-07-14', 'SORSOGON', 'F', 'married', '', '', '', '', '', '', '', '', '670788153', 'FILIPINO', 'SAN JUAN', NULL, NULL, NULL, '4700', 'SAN JUAN', NULL, NULL, NULL, '4700', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `empstatus`
--

CREATE TABLE `empstatus` (
  `empstatusid` int(11) NOT NULL,
  `statustitle` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empstatus`
--

INSERT INTO `empstatus` (`empstatusid`, `statustitle`) VALUES
(6, 'PERMANENT');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `rankid` int(11) NOT NULL,
  `ranktitle` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rankid`, `ranktitle`) VALUES
(4, 'RANK 1');

-- --------------------------------------------------------

--
-- Table structure for table `salarygrade`
--

CREATE TABLE `salarygrade` (
  `salaryid` int(11) NOT NULL,
  `salarytitle` varchar(6) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salarygrade`
--

INSERT INTO `salarygrade` (`salaryid`, `salarytitle`, `amount`) VALUES
(2, 'SG-1-1', 10510);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `uid` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_type` varchar(100) DEFAULT NULL,
  `gmt_created` datetime DEFAULT NULL,
  `priviledges` text,
  `gmt_last_access` datetime DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`uid`, `username`, `password`, `user_type`, `gmt_created`, `priviledges`, `gmt_last_access`, `fname`, `mname`, `lname`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2019-08-18 09:02:00', 'employee,emp_status,rank,salary_grade,set_appointment', '2019-08-19 08:25:45', 'ADMIN', 'ADMIN', 'ADMIN'),
(3, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', '2019-08-18 22:18:58', 'employee,emp_status,salary_grade,set_appointment', NULL, 'USER1', 'USER1', 'USER1'),
(4, 'user2', '7e58d63b60197ceb55a1c487989a3720', 'user', '2019-08-18 22:20:04', 'employee,rank,salary_grade,set_appointment', NULL, 'USER2', 'USER2', 'USER2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointmenttno`,`employeeid`) USING BTREE,
  ADD KEY `employeeid` (`employeeid`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`campusid`);

--
-- Indexes for table `educbackground`
--
ALTER TABLE `educbackground`
  ADD PRIMARY KEY (`itemno`,`employeeid`) USING BTREE,
  ADD KEY `employeeid` (`employeeid`);

--
-- Indexes for table `empchildren`
--
ALTER TABLE `empchildren`
  ADD PRIMARY KEY (`itemno`,`employeeid`) USING BTREE,
  ADD KEY `employeeid` (`employeeid`);

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
  ADD PRIMARY KEY (`itemno`,`employeeid`),
  ADD KEY `employeeid` (`employeeid`);

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
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointmenttno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `campusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `educbackground`
--
ALTER TABLE `educbackground`
  MODIFY `itemno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
  MODIFY `empstatusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `itemno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rank`
--
ALTER TABLE `rank`
  MODIFY `rankid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `salarygrade`
--
ALTER TABLE `salarygrade`
  MODIFY `salaryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `educbackground`
--
ALTER TABLE `educbackground`
  ADD CONSTRAINT `educbackground_ibfk_1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `empchildren`
--
ALTER TABLE `empchildren`
  ADD CONSTRAINT `empchildren_ibfk_1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `license`
--
ALTER TABLE `license`
  ADD CONSTRAINT `license_ibfk_1` FOREIGN KEY (`employeeid`) REFERENCES `employee` (`employeeid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
