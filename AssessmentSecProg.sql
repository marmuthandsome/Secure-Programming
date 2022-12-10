SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL primary key,
  `username` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Admin', '$2y$10$SmT/WyDn6m01FCKpodu5DecIlw0KMaJOvGvIe2TCCMyJ6wMSekG06'), --admin123
(2, 'Maintainer', '$2y$10$rdqM2Wei4fNyeAIz033/s.SpcdJqqS4Eml8cMKR.S8B2DWS0qrL/K'), --maintainer123
(3, 'Supervisor', '$2y$10$xm48y6.wjCDWZ40rS0cbiOPO0Rbl0cqWNPKmt/kEJIwSTEuW9bzWC'), --supervisor123
(4, 'Employee', '$2y$10$0KLJdNkYcXb.UaJfmzOV1OuCHScE3PNgaXwtg9uZFDn1Zh2sRnvGy'); --employee123


CREATE TABLE `communications` (
  `id` int(11) NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `recipient_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(64) NOT NULL,
  `message` text NOT NULL,
  `send_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `communications` (`id`, `sender_id`, `recipient_id`, `title`, `message`, `send_at`) VALUES
(2, 1, 1, 'Important Request', 'There are important request', '2019-05-03 06:02:33'),
(3, 1, 4, 'Emergency Request', 'There are emergency request', '2019-05-03 06:13:10'),
(4, 2, 3, 'Unknown Request', 'There are unknown request', '2019-08-02 05:22:25'),
(5, 2, 2, 'Null Request', 'There are null request', '2019-08-02 05:23:36');



COMMIT;