SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL primary key,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `log` (
  `ip` varchar(100) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

COMMIT;