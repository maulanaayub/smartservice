-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2020 at 08:48 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salatiga_template`
--

-- --------------------------------------------------------

--
-- Table structure for table `iain_log`
--

CREATE TABLE `iain_log` (
  `log_id` int(11) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_user` varchar(50) NOT NULL,
  `log_role` varchar(100) NOT NULL,
  `log_aksi` varchar(50) NOT NULL,
  `log_ip` varchar(50) NOT NULL,
  `log_namepc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iain_log`
--

INSERT INTO `iain_log` (`log_id`, `log_time`, `log_user`, `log_role`, `log_aksi`, `log_ip`, `log_namepc`) VALUES
(149, '2020-09-09 03:15:27', 'admin', 'kosong', 'account not registered!', '::1', 'DESKTOP-V7AS5GS'),
(150, '2020-09-09 03:17:04', 'admin', 'pass_coba:a', 'account not registered!', '::1', 'DESKTOP-V7AS5GS'),
(151, '2020-09-09 03:17:17', 'admin', 'pass_coba:s', 'account not registered!', '::1', 'DESKTOP-V7AS5GS'),
(152, '2020-09-09 03:17:56', 'admin', 'pass_coba:j', 'account not registered!', '::1', 'DESKTOP-V7AS5GS'),
(153, '2020-09-09 03:18:49', 'asdsadsa', 'asdsadas', 'account not registered!', '::1', 'DESKTOP-V7AS5GS'),
(154, '2020-09-09 03:19:17', 'frrtv', 'pass.dicoba', 'account not registered!', '::1', 'DESKTOP-V7AS5GS'),
(155, '2020-09-09 03:20:42', 'coba', 'password :c', 'account not registered!', '::1', 'DESKTOP-V7AS5GS'),
(156, '2020-09-09 03:21:27', 'thytny', 'password :hythythythtyh', 'account not registered!', '::1', 'DESKTOP-V7AS5GS'),
(157, '2020-09-09 03:24:56', 'rvp23', '1', 'login_success role:1', '::1', 'DESKTOP-V7AS5GS'),
(158, '2020-09-09 03:24:56', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(159, '2020-09-09 03:24:58', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(160, '2020-09-09 03:39:09', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(161, '2020-09-09 03:39:13', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(162, '2020-09-16 04:12:24', 'rvp23', '1', 'login_success role:1', '::1', 'DESKTOP-V7AS5GS'),
(163, '2020-09-16 04:12:25', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(164, '2020-09-16 04:12:28', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(165, '2020-09-16 04:12:33', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(166, '2020-09-16 04:12:34', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(167, '2020-09-16 04:12:37', 'rvp23', '1', 'Menu Management', '::1', 'DESKTOP-V7AS5GS'),
(168, '2020-09-16 04:12:38', 'rvp23', '1', 'Sub Menu', '::1', 'DESKTOP-V7AS5GS'),
(169, '2020-09-16 04:12:43', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(170, '2020-09-16 04:14:05', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(171, '2020-09-16 04:14:37', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(172, '2020-09-16 04:14:41', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(173, '2020-09-16 04:14:47', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(174, '2020-09-16 04:19:16', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(175, '2020-09-16 04:21:53', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(176, '2020-09-16 04:22:21', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(177, '2020-09-16 04:22:24', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(178, '2020-09-16 04:25:51', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(179, '2020-09-16 04:26:37', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(180, '2020-09-16 04:26:42', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(181, '2020-09-16 04:26:46', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(182, '2020-09-16 04:26:50', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(183, '2020-09-16 04:26:55', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(184, '2020-09-16 04:27:00', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(185, '2020-09-16 04:27:05', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(186, '2020-09-16 04:27:44', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(187, '2020-09-16 04:27:46', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(188, '2020-09-16 04:29:59', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(189, '2020-09-16 04:30:04', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(190, '2020-09-16 04:30:10', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(191, '2020-09-16 04:30:12', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(192, '2020-09-16 04:30:14', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(193, '2020-09-16 04:30:15', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(194, '2020-09-16 04:30:18', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(195, '2020-09-16 04:30:19', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(196, '2020-09-16 04:30:49', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(197, '2020-09-16 04:30:51', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(198, '2020-09-16 04:30:54', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(199, '2020-09-16 04:31:22', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(200, '2020-09-16 04:31:26', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(201, '2020-09-16 04:31:31', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(202, '2020-09-16 04:31:36', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(203, '2020-09-16 04:31:36', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(204, '2020-09-16 04:31:37', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(205, '2020-09-16 04:31:38', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(206, '2020-09-16 04:31:39', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(207, '2020-09-16 04:31:43', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(208, '2020-09-16 04:31:47', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(209, '2020-09-16 04:31:48', 'rvp23', '1', 'Manajement User', '::1', 'DESKTOP-V7AS5GS'),
(210, '2020-09-16 04:31:57', 'rvp23', '1', 'Manajement User', '::1', 'DESKTOP-V7AS5GS'),
(211, '2020-09-16 04:32:07', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(212, '2020-09-16 04:32:08', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(213, '2020-09-16 08:51:15', 'rvp23', '1', 'password_wrong', '::1', 'DESKTOP-V7AS5GS'),
(214, '2020-09-16 08:51:21', 'rvp23', '1', 'login_success role:1', '::1', 'DESKTOP-V7AS5GS'),
(215, '2020-09-16 08:51:22', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(216, '2020-09-16 08:51:24', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(217, '2020-09-16 08:51:28', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(218, '2020-09-16 08:51:32', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(219, '2020-09-16 08:51:35', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(220, '2020-09-16 08:51:39', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(221, '2020-09-16 08:51:44', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(222, '2020-09-16 08:51:49', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(223, '2020-09-16 08:51:53', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(224, '2020-09-16 08:51:56', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(225, '2020-09-16 08:52:00', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(226, '2020-09-16 08:52:04', 'rvp23', '1', 'log_out', '::1', 'DESKTOP-V7AS5GS'),
(227, '2020-09-16 08:52:11', 'rvp23', '1', 'login_success role:1', '::1', 'DESKTOP-V7AS5GS'),
(228, '2020-09-16 08:52:11', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(229, '2020-09-16 08:52:13', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(230, '2020-09-16 08:52:33', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(231, '2020-09-18 09:10:54', 'rvp23', '1', 'login_success role:1', '::1', 'DESKTOP-V7AS5GS'),
(232, '2020-09-18 09:10:54', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(233, '2020-09-18 09:10:57', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(234, '2020-09-18 09:11:02', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(235, '2020-09-18 09:11:05', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(236, '2020-09-18 09:11:09', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(237, '2020-09-18 09:11:13', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(238, '2020-09-18 09:11:15', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(239, '2020-09-18 09:11:19', 'rvp23', '1', 'Manajement User', '::1', 'DESKTOP-V7AS5GS'),
(240, '2020-09-18 09:11:25', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(241, '2020-09-18 09:11:26', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(242, '2020-09-18 09:11:28', 'rvp23', '1', 'log_out', '::1', 'DESKTOP-V7AS5GS'),
(243, '2020-09-21 08:14:29', 'rvp23', '1', 'login_success role:1', '::1', 'DESKTOP-V7AS5GS'),
(244, '2020-09-21 08:14:29', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(245, '2020-09-21 08:14:33', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(246, '2020-09-21 08:14:37', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(247, '2020-09-21 08:14:41', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(248, '2020-09-21 08:14:48', 'rvp23', '1', 'Menu Management', '::1', 'DESKTOP-V7AS5GS'),
(249, '2020-09-21 08:14:51', 'rvp23', '1', 'Sub Menu', '::1', 'DESKTOP-V7AS5GS'),
(250, '2020-09-21 08:14:57', 'rvp23', '1', 'Manajement User', '::1', 'DESKTOP-V7AS5GS'),
(251, '2020-09-21 08:15:52', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(252, '2020-09-21 08:15:53', 'rvp23', '1', 'dashboard_menu', '::1', 'DESKTOP-V7AS5GS'),
(253, '2020-09-21 08:15:54', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(254, '2020-09-21 08:15:54', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(255, '2020-09-21 08:15:57', 'rvp23', '1', 'role_menu', '::1', 'DESKTOP-V7AS5GS'),
(256, '2020-09-21 08:16:00', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(257, '2020-09-21 08:16:03', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(258, '2020-09-21 08:16:06', 'rvp23', '1', 'ChangeAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(259, '2020-09-21 08:16:09', 'rvp23', '1', 'DeletedAccess_success', '::1', 'DESKTOP-V7AS5GS'),
(260, '2020-09-25 05:41:18', ';l,;l,;', 'password :l,l;l[pl[plplpokopk', 'account not registered!', '::1', 'DESKTOP-V7AS5GS');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `image_large` varchar(50) NOT NULL,
  `image_medium` varchar(50) NOT NULL,
  `image_small` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`, `image_large`, `image_medium`, `image_small`) VALUES
(4, 'Rio Vindar Prakoso', 'rvp23', 'riovindarp@iainsalatiga.ac.id', 'no-image.jpg', '$2y$10$O.8iS7Gq8XQxJGYgJz7vj.uubAafKe.co8ippszgLjU0U/8R0N/Ym', 1, 1, 1598414187, '', '', 'no-image.jpg'),
(40, 'Naufal Arman', 'nopal', 'naufal@iainsalatiga.ac.id', '0657af91d25544efad534de9a4874cfe.jpg', '$2y$10$fxFUE/PMHcr/vcm4HamPOuYLkubX0FGxME7MhGKDupeTlHkN16Kke', 11, 1, 1599056911, '0657af91d25544efad534de9a4874cfe.jpg', '0657af91d25544efad534de9a4874cfe.jpg', '0657af91d25544efad534de9a4874cfe.jpg'),
(41, 'Maulana Ayub Dwi Saputra', 'ayub', 'ayub@iainsalatiga.ac.id', '4b935e695e276b96f8937b38f9dbcb6b.jpg', '$2y$10$wx5V43IHtHbCQ.u3n8J.oOPyfuAqPt7VHHDr.tVKZ98oQGImC070S', 2, 1, 1599057205, '4b935e695e276b96f8937b38f9dbcb6b.jpg', '4b935e695e276b96f8937b38f9dbcb6b.jpg', '4b935e695e276b96f8937b38f9dbcb6b.jpg'),
(42, 'tes', 'tes', 'tes@gmail.com', '4b4172b6b14e41c12b93c971e8a5f33d.jpg', '$2y$10$8YbjHwWXSNgylK1dAs3A/OlHqQR5Igrsn5fY/sO/1V2pnylts0tQm', 11, 1, 1599095285, '4b4172b6b14e41c12b93c971e8a5f33d.jpg', '4b4172b6b14e41c12b93c971e8a5f33d.jpg', '4b4172b6b14e41c12b93c971e8a5f33d.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(31, 2, 2),
(57, 11, 2),
(58, 2, 98),
(93, 1, 3),
(95, 1, 98),
(96, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `nama_menu` varchar(128) NOT NULL,
  `Description` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `nama_menu`, `Description`) VALUES
(1, 'Admin', 'Menu Admin,Mengatur full akses aplikasi'),
(2, 'Home', 'Mengatur jalannya aplikasi dan juga melihat profile'),
(3, 'Menu', 'Mengatur manajemen menu aplikasi'),
(98, 'User', 'Untuk mengatur segala hal tentang user');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Operator'),
(11, 'Admin App');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `user_menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `user_menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fa fa-desktop', 1),
(3, 2, 'Profile', 'home', 'fa fa-user', 1),
(4, 3, 'Menu Management', 'menu', 'fa fa-folder', 1),
(5, 3, 'SubMenu Management', 'menu/submenu', 'fa fa-folder-open', 1),
(19, 1, 'Role', 'admin/role', 'fa fa-linux', 1),
(22, 98, 'Manajement User', 'user', 'fa fa-users', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `iain_log`
--
ALTER TABLE `iain_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `iain_log`
--
ALTER TABLE `iain_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
