-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 04:08 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main`
--

-- --------------------------------------------------------

--
-- Table structure for table `aicompany`
--

CREATE TABLE `aicompany` (
  `ID` int(11) NOT NULL,
  `Label` varchar(40) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `createdat` date DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `updatedat` date DEFAULT NULL,
  `oldid` int(11) DEFAULT NULL,
  `Companyid` bigint(20) DEFAULT NULL,
  `Divisionid` bigint(20) DEFAULT NULL,
  `YearCode` bigint(20) DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `formid` int(11) DEFAULT NULL,
  `active` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `aidivision`
--

CREATE TABLE `aidivision` (
  `ID` int(11) NOT NULL,
  `Label` varchar(40) NOT NULL,
  `Remarks` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `aigroup`
--

CREATE TABLE `aigroup` (
  `ID` int(11) NOT NULL,
  `Label` varchar(200) DEFAULT NULL,
  `ChannelPartnerID` int(11) DEFAULT NULL,
  `ContactEmail` varchar(200) DEFAULT NULL,
  `ContactPerson` varchar(500) DEFAULT NULL,
  `ContactNumber` varchar(500) DEFAULT NULL,
  `ContactAddress` varchar(1000) DEFAULT NULL,
  `CreatedAt` datetime(3) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `UpdatedAt` datetime(3) DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT NULL,
  `isArchived` tinyint(4) DEFAULT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `DivisionId` int(11) DEFAULT NULL,
  `YearCode` int(11) DEFAULT NULL,
  `FormID` int(11) DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL,
  `DataFromClientServer` tinyint(4) DEFAULT NULL,
  `ImageToClientServer` tinyint(4) DEFAULT NULL,
  `DataFromClientURL` longtext DEFAULT NULL,
  `ImageToClientURL` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `aigrouplicense`
--

CREATE TABLE `aigrouplicense` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `License` varchar(1000) DEFAULT NULL,
  `StartDate` datetime(3) NOT NULL,
  `EndDate` datetime(3) NOT NULL,
  `LicenseType` int(11) DEFAULT NULL,
  `MaxUsers` int(11) DEFAULT NULL,
  `MaxActiveUsers` int(11) DEFAULT NULL,
  `VerificationCode` varchar(500) DEFAULT NULL,
  `LicenseAssignedBy` int(11) DEFAULT NULL,
  `LicenseAuthCode` varchar(500) DEFAULT NULL,
  `CreatedAt` datetime(3) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `UpdatedAt` datetime(3) DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT NULL,
  `isArchived` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `aigroupproductaccess`
--

CREATE TABLE `aigroupproductaccess` (
  `GroupID` int(11) DEFAULT NULL,
  `ProductCategoryID` int(11) NOT NULL,
  `isActive` tinyint(4) DEFAULT NULL,
  `isArchived` tinyint(4) DEFAULT NULL,
  `CreatedAt` datetime(3) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `UpdatedAt` datetime(3) DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `formid` int(11) DEFAULT NULL,
  `registerid` int(11) DEFAULT NULL,
  `active` tinyint(3) UNSIGNED DEFAULT NULL,
  `oldid` int(11) DEFAULT NULL,
  `Companyid` bigint(20) DEFAULT NULL,
  `Divisionid` bigint(20) DEFAULT NULL,
  `YearCode` bigint(20) DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `entryid` int(11) DEFAULT NULL,
  `oldentryid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `aiproductcategory`
--

CREATE TABLE `aiproductcategory` (
  `ID` int(11) NOT NULL,
  `Label` varchar(500) NOT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT NULL,
  `isArchived` tinyint(4) DEFAULT NULL,
  `CreatedAt` datetime(3) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `UpdatedAt` datetime(3) DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `formid` int(11) DEFAULT NULL,
  `registerid` int(11) DEFAULT NULL,
  `active` tinyint(3) UNSIGNED DEFAULT NULL,
  `oldid` int(11) DEFAULT NULL,
  `Companyid` bigint(20) DEFAULT NULL,
  `Divisionid` bigint(20) DEFAULT NULL,
  `YearCode` bigint(20) DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `producttype` int(11) DEFAULT NULL,
  `subcategory` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `aireg`
--

CREATE TABLE `aireg` (
  `ID` int(11) NOT NULL,
  `CompanyID` int(11) NOT NULL,
  `DivisionID` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Database_name` varchar(50) DEFAULT NULL,
  `del_Grp` int(11) DEFAULT NULL,
  `Channel_PartnerID` int(11) DEFAULT NULL,
  `Ip` varchar(20) DEFAULT NULL,
  `Port` varchar(20) DEFAULT NULL,
  `Sql_User_Id` varchar(20) DEFAULT NULL,
  `Decrypted_Password` varchar(20) DEFAULT NULL,
  `Create_Date` datetime DEFAULT NULL,
  `Amc_Paid` decimal(19,4) DEFAULT NULL,
  `Company_ShortCode` varchar(5) DEFAULT NULL,
  `Servicess_Stopped` tinyint(3) UNSIGNED DEFAULT NULL,
  `Is_Amc_Period` tinyint(3) UNSIGNED DEFAULT NULL,
  `License_actiavation` tinyint(3) UNSIGNED DEFAULT NULL,
  `Period` varchar(20) DEFAULT NULL,
  `Nof_Concurrent_Users` tinyint(3) UNSIGNED DEFAULT NULL,
  `Grp_Email_Pass` varchar(20) DEFAULT NULL,
  `Grp_Email` varchar(20) DEFAULT NULL,
  `dtbases` varchar(100) DEFAULT NULL,
  `formid` int(11) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `createdat` date DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `updatedat` date DEFAULT NULL,
  `YearCode` bigint(20) DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `aireg1`
--

CREATE TABLE `aireg1` (
  `ID` int(11) NOT NULL,
  `CompanyID1` int(11) NOT NULL,
  `DivisionID1` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Database_name` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `del_Grp` int(11) DEFAULT NULL,
  `Channel_PartnerID` int(11) DEFAULT NULL,
  `Ip` varchar(20) DEFAULT NULL,
  `Port` varchar(20) DEFAULT NULL,
  `Sql_User_Id` varchar(20) DEFAULT NULL,
  `Decrypted_Password` varchar(20) DEFAULT NULL,
  `Create_Date` datetime DEFAULT NULL,
  `Amc_Paid` decimal(19,4) DEFAULT NULL,
  `Company_ShortCode` varchar(5) DEFAULT NULL,
  `Servicess_Stopped` tinyint(3) UNSIGNED DEFAULT NULL,
  `Is_Amc_Period` tinyint(3) UNSIGNED DEFAULT NULL,
  `License_actiavation` tinyint(3) UNSIGNED DEFAULT NULL,
  `Period` varchar(20) DEFAULT NULL,
  `Nof_Concurrent_Users` tinyint(3) UNSIGNED DEFAULT NULL,
  `Grp_Email_Pass` varchar(20) DEFAULT NULL,
  `Grp_Email` varchar(20) DEFAULT NULL,
  `dtbases` varchar(100) DEFAULT NULL,
  `formid` int(11) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `createdat` date DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `updatedat` date DEFAULT NULL,
  `YearCode` bigint(20) DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `Companyid` bigint(20) DEFAULT NULL,
  `Divisionid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `aiyear`
--

CREATE TABLE `aiyear` (
  `ID` int(11) NOT NULL,
  `Label` varchar(40) NOT NULL,
  `sdate` date DEFAULT NULL,
  `edate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `companyroleaccess`
--

CREATE TABLE `companyroleaccess` (
  `RoleID` int(11) NOT NULL,
  `RegID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `developerchanges`
--

CREATE TABLE `developerchanges` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `tablename` varchar(50) DEFAULT NULL,
  `date` datetime(3) DEFAULT NULL,
  `engineer` varchar(50) DEFAULT NULL,
  `formid` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `columnheading` varchar(50) DEFAULT NULL,
  `partyid` int(11) DEFAULT NULL,
  `dbfieldname` varchar(50) DEFAULT NULL,
  `iscompulsory` varchar(10) DEFAULT NULL,
  `help_tvs` varchar(100) DEFAULT NULL,
  `structure` varchar(50) DEFAULT NULL,
  `size` double DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  `vieworder` int(11) DEFAULT NULL,
  `helpspt` varchar(100) DEFAULT NULL,
  `helpcolumn` varchar(50) DEFAULT NULL,
  `specialinstructionsonhelp` varchar(100) DEFAULT NULL,
  `scriptssp` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `registerid` int(11) DEFAULT NULL,
  `active` tinyint(3) UNSIGNED DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `createdat` date DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `updatedat` date DEFAULT NULL,
  `oldid` int(11) DEFAULT NULL,
  `Companyid` bigint(20) DEFAULT NULL,
  `Divisionid` bigint(20) DEFAULT NULL,
  `YearCode` bigint(20) DEFAULT NULL,
  `uniqueid` bigint(20) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `developererrorlogs`
--

CREATE TABLE `developererrorlogs` (
  `ID` int(11) NOT NULL,
  `FormID` int(11) NOT NULL,
  `CompanyID` int(11) NOT NULL,
  `DivisionID` int(11) NOT NULL,
  `YearCode` bigint(20) DEFAULT NULL,
  `Database_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `ErrorCode` int(11) NOT NULL,
  `ErrorField` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Description` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `RecommendedSolution` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedAt` datetime(3) DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedAt` datetime(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `einvoiceimagetmp`
--

CREATE TABLE `einvoiceimagetmp` (
  `id` int(11) DEFAULT NULL,
  `EntryID` bigint(20) DEFAULT NULL,
  `CompanyID` int(11) DEFAULT NULL,
  `DivisionID` int(11) DEFAULT NULL,
  `YearCode` int(11) DEFAULT NULL,
  `FormID` int(11) DEFAULT NULL,
  `Response_QRImage` longblob DEFAULT NULL,
  `Image_name` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `formeditlock`
--

CREATE TABLE `formeditlock` (
  `ID` bigint(20) NOT NULL,
  `EntryID` bigint(20) DEFAULT NULL,
  `FormID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `CompanyID` int(11) DEFAULT NULL,
  `DivisionID` int(11) DEFAULT NULL,
  `YearCode` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `isDeleted` tinyint(4) DEFAULT NULL,
  `CreatedAt` datetime(3) DEFAULT NULL,
  `UpdatedAt` datetime(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aicompany`
--
ALTER TABLE `aicompany`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `aidivision`
--
ALTER TABLE `aidivision`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `aigroup`
--
ALTER TABLE `aigroup`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `aigrouplicense`
--
ALTER TABLE `aigrouplicense`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `aigroupproductaccess`
--
ALTER TABLE `aigroupproductaccess`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aiproductcategory`
--
ALTER TABLE `aiproductcategory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `aireg`
--
ALTER TABLE `aireg`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `aireg1`
--
ALTER TABLE `aireg1`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `aiyear`
--
ALTER TABLE `aiyear`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `developerchanges`
--
ALTER TABLE `developerchanges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `developererrorlogs`
--
ALTER TABLE `developererrorlogs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `formeditlock`
--
ALTER TABLE `formeditlock`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aicompany`
--
ALTER TABLE `aicompany`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aidivision`
--
ALTER TABLE `aidivision`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aigroup`
--
ALTER TABLE `aigroup`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aigrouplicense`
--
ALTER TABLE `aigrouplicense`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aigroupproductaccess`
--
ALTER TABLE `aigroupproductaccess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aiproductcategory`
--
ALTER TABLE `aiproductcategory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aireg`
--
ALTER TABLE `aireg`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aireg1`
--
ALTER TABLE `aireg1`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aiyear`
--
ALTER TABLE `aiyear`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `developerchanges`
--
ALTER TABLE `developerchanges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `developererrorlogs`
--
ALTER TABLE `developererrorlogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formeditlock`
--
ALTER TABLE `formeditlock`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
