
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `papers` (
  `paper_id` varchar(15) NOT NULL,
  `title` varchar(500),
  `author` varchar(500),
  `year` int DEFAULT 0,
  `cit` int DEFAULT 0,
  `abstract` blob,
  `betweenness` float,
  `indegree` int,
  `clustering` float,
  `pagerank` float,
  PRIMARY KEY (`paper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
