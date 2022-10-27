SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS sdteeulmhcln DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE sdteeulmhcln;

CREATE TABLE `botconversations` (
  `ID` bigint(20) NOT NULL,
  `BOTID` bigint(20) NOT NULL DEFAULT '0',
  `CONVERSATIONID` varchar(40) NOT NULL,
  `USERQUERY` varchar(140) NOT NULL,
  `BOTRESPONSE` text NOT NULL,
  `BOTCONFIDENCE` int(11) NOT NULL,
  `USERNAME` varchar(40) NOT NULL DEFAULT 'Visitor',
  `TIMESTAMP` varchar(10) NOT NULL,
  `REVIEWED` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `botknowledge` (
  `ID` bigint(20) NOT NULL,
  `BOTID` bigint(20) NOT NULL,
  `QUESTION` varchar(140) NOT NULL,
  `BOTRESPONSE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `botlist` (
  `ID` bigint(20) NOT NULL,
  `BOTNAME` varchar(40) NOT NULL DEFAULT 'ChatBot',
  `BOTAVATAR` varchar(120) NOT NULL DEFAULT 'https://www.phpchatbot.com/chatnow/images/default.png',
  `CLOSEMATCH` int(11) DEFAULT '75',
  `EXACTMATCH` int(11) NOT NULL DEFAULT '90',
  `CREATIONDATE` varchar(10) NOT NULL,
  `CREATOR` varchar(40) NOT NULL DEFAULT 'Unknown',
  `CREATORID` bigint(20) DEFAULT NULL,
  `BOTSTATUS` enum('0','1') NOT NULL DEFAULT '1',
  `GREETING` varchar(120) NOT NULL DEFAULT 'Hello!'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `botlogs` (
  `ID` bigint(20) NOT NULL,
  `BOTID` bigint(20) NOT NULL,
  `CONVERSATIONID` varchar(40) NOT NULL,
  `DIALOG` text NOT NULL,
  `TIMESTAMP` varchar(10) NOT NULL,
  `REVIEWED` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `botmakers` (
  `ID` bigint(20) NOT NULL,
  `USERNAME` varchar(320) NOT NULL,
  `PASSWORD` varchar(32) NOT NULL,
  `DISPLAYNAME` varchar(40) NOT NULL,
  `USERSTATUS` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `botmakers` (`ID`, `USERNAME`, `PASSWORD`, `DISPLAYNAME`, `USERSTATUS`) VALUES
(1, 'admin@phpchatbot.com', '029bde2457318c173c0bedc1c81ea39b', 'Bot Admin', '1');


ALTER TABLE `botconversations`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `botknowledge`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `botlist`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `botlogs`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `botmakers`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `botconversations`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `botknowledge`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `botlist`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `botlogs`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `botmakers`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
