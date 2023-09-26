-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 01:34 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ludo_game_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin dev', 'admin@gmail.com', '$2y$10$/eh3mwnsdzUxRXj92iNCvucUKxPDS4rYPRHNfND328MbMkE6WKywK', NULL, NULL),
(2, 'dev', 'dev@gmail.com', '$2y$10$N5pw25dxItRhXmWw3YPxOuxI1o5yqq2dBY5YGi5upzx/sLkweCy7i', NULL, NULL),
(3, 'admin@admin.com', 'admin@admin.com', '$2y$10$LWG2n4c4PbldLRoez2IzJe1xVWwBaiXJZmQsrzqVZhKAx3uye5zq6', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `biddings`
--

CREATE TABLE `biddings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `round_id` bigint(20) UNSIGNED NOT NULL,
  `board_id` bigint(20) UNSIGNED NOT NULL,
  `bided_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending,1=Running,2=Complete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biding_details`
--

CREATE TABLE `biding_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` bigint(20) UNSIGNED DEFAULT NULL,
  `tournament_id` bigint(20) UNSIGNED DEFAULT NULL,
  `game_id` bigint(20) UNSIGNED DEFAULT NULL,
  `round_id` bigint(20) UNSIGNED DEFAULT NULL,
  `board_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bided_to` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Complete',
  `bid_amount` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `biding_details`
--

INSERT INTO `biding_details` (`id`, `userid`, `tournament_id`, `game_id`, `round_id`, `board_id`, `bided_to`, `status`, `bid_amount`, `created_at`, `updated_at`) VALUES
(3, 4, 3, 8, 2, 2, 6, 0, 20, '2022-10-27 10:35:23', '2022-10-27 10:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `diamond_uses`
--

CREATE TABLE `diamond_uses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` bigint(20) UNSIGNED DEFAULT NULL,
  `tournament_id` bigint(20) UNSIGNED DEFAULT NULL,
  `game_id` bigint(20) UNSIGNED DEFAULT NULL,
  `round_id` bigint(20) UNSIGNED DEFAULT NULL,
  `diamond_use` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diamond_uses`
--

INSERT INTO `diamond_uses` (`id`, `userid`, `tournament_id`, `game_id`, `round_id`, `diamond_use`, `created_at`, `updated_at`) VALUES
(1, 4, 3, 8, 2, '1', '2022-10-26 10:46:13', '2022-10-26 10:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `free2pgames`
--

CREATE TABLE `free2pgames` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_one` int(11) DEFAULT NULL,
  `player_two` int(11) DEFAULT NULL,
  `winner` int(11) DEFAULT NULL,
  `looser` int(11) DEFAULT NULL,
  `game_no` int(11) NOT NULL,
  `game_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `winner_coin` double DEFAULT NULL,
  `entry_coin` double DEFAULT NULL,
  `multiply_by` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `free2pgames`
--

INSERT INTO `free2pgames` (`id`, `player_one`, `player_two`, `winner`, `looser`, `game_no`, `game_id`, `status`, `created_at`, `updated_at`, `winner_coin`, `entry_coin`, `multiply_by`) VALUES
(1, 1, 4, 1, 2, 1, '2345', 1, '2022-09-22 11:30:40', '2022-09-26 10:06:13', 200, 100, 2),
(4, 1, 1, 1, 1, 2, '8633572508bb70', 1, '2022-09-29 10:24:16', '2022-09-29 10:26:27', 100, 100, 1),
(5, 1, NULL, NULL, NULL, 3, '8633572e9ad26b', 0, '2022-09-29 10:26:49', '2022-09-29 10:26:49', 10000, 10000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `free2pgamesettings`
--

CREATE TABLE `free2pgamesettings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `winner_coin_multiply_value` double NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `free2pgamesettings`
--

INSERT INTO `free2pgamesettings` (`id`, `winner_coin_multiply_value`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2022-09-25 11:39:25', '2022-10-13 05:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `free3pgames`
--

CREATE TABLE `free3pgames` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_one` int(11) NOT NULL,
  `player_two` int(11) DEFAULT NULL,
  `player_three` int(11) DEFAULT NULL,
  `first_winner` int(11) DEFAULT NULL,
  `second_winner` int(11) DEFAULT NULL,
  `third_winner` int(11) DEFAULT NULL,
  `first_winner_coin` double DEFAULT NULL,
  `second_winner_coin` double DEFAULT NULL,
  `third_winner_coin` double DEFAULT NULL,
  `entry_fee` double DEFAULT NULL,
  `game_no` int(11) DEFAULT NULL,
  `game_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_winner_multiply` double DEFAULT NULL,
  `second_winner_multiply` double DEFAULT NULL,
  `third_winner_multiply` double DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `free3pgames`
--

INSERT INTO `free3pgames` (`id`, `player_one`, `player_two`, `player_three`, `first_winner`, `second_winner`, `third_winner`, `first_winner_coin`, `second_winner_coin`, `third_winner_coin`, `entry_fee`, `game_no`, `game_id`, `first_winner_multiply`, `second_winner_multiply`, `third_winner_multiply`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 5, 1, 5, 4, 200, 150, 50, 100, 1, '86333dc03db040', 2, 1.5, 0.5, 1, '2022-09-28 05:30:43', '2022-09-28 09:56:30'),
(2, 1, NULL, NULL, NULL, NULL, NULL, 400, 300, 100, 200, 2, '86335747ebb348', 2, 1.5, 0.5, 0, '2022-09-29 10:33:34', '2022-09-29 10:33:34');

-- --------------------------------------------------------

--
-- Table structure for table `free3pgamesettings`
--

CREATE TABLE `free3pgamesettings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_winner_multiply` double DEFAULT NULL,
  `second_winner_multiply` double DEFAULT NULL,
  `third_winner_multiply` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `free3pgamesettings`
--

INSERT INTO `free3pgamesettings` (`id`, `first_winner_multiply`, `second_winner_multiply`, `third_winner_multiply`, `created_at`, `updated_at`) VALUES
(1, 2, 0.5, 0.2, '2022-09-28 04:56:29', '2022-10-13 06:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `free4playergames`
--

CREATE TABLE `free4playergames` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_one` int(11) NOT NULL,
  `player_two` int(11) DEFAULT NULL,
  `player_three` int(11) DEFAULT NULL,
  `player_four` int(11) DEFAULT NULL,
  `first_winner` int(11) DEFAULT NULL,
  `second_winner` int(11) DEFAULT NULL,
  `third_winner` int(11) DEFAULT NULL,
  `loser` int(11) DEFAULT NULL,
  `first_winner_coin` double DEFAULT NULL,
  `second_winner_coin` double DEFAULT NULL,
  `third_winner_coin` double DEFAULT NULL,
  `loser_coin` double DEFAULT NULL,
  `entry_fee` double DEFAULT NULL,
  `game_no` int(11) DEFAULT NULL,
  `game_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_winner_multiply` double DEFAULT NULL,
  `second_winner_multiply` double DEFAULT NULL,
  `third_winner_multiply` double DEFAULT NULL,
  `looser_multiply` double DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `free4playergames`
--

INSERT INTO `free4playergames` (`id`, `player_one`, `player_two`, `player_three`, `player_four`, `first_winner`, `second_winner`, `third_winner`, `loser`, `first_winner_coin`, `second_winner_coin`, `third_winner_coin`, `loser_coin`, `entry_fee`, `game_no`, `game_id`, `first_winner_multiply`, `second_winner_multiply`, `third_winner_multiply`, `looser_multiply`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 5, 4, 4, NULL, NULL, NULL, 6504, 4878, 1626, 650.4, 3252, 1, '2345sdf', 2, 1.5, 0.5, 0.2, 0, '2022-10-12 07:59:34', '2022-10-13 04:34:12');

-- --------------------------------------------------------

--
-- Table structure for table `free4playergamesettings`
--

CREATE TABLE `free4playergamesettings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_winner_multiply` double DEFAULT NULL,
  `second_winner_multiply` double DEFAULT NULL,
  `third_winner_multiply` double DEFAULT NULL,
  `looser_multiply` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `free4playergamesettings`
--

INSERT INTO `free4playergamesettings` (`id`, `first_winner_multiply`, `second_winner_multiply`, `third_winner_multiply`, `looser_multiply`, `created_at`, `updated_at`) VALUES
(1, 2, 0.5, 0.3, 0, '2022-10-12 06:28:48', '2022-10-13 06:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `gamerounds`
--

CREATE TABLE `gamerounds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `round_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `round_end_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending,1=Running,2=Complete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gamerounds`
--

INSERT INTO `gamerounds` (`id`, `tournament_id`, `game_id`, `round_no`, `round_end_time`, `status`, `created_at`, `updated_at`) VALUES
(2, 3, 8, 'final', NULL, 1, '2022-10-18 06:42:10', '2022-10-25 09:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_id` bigint(20) UNSIGNED NOT NULL,
  `game_no` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '1=Running,2=Complete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `tournament_id`, `game_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, '2022-10-15 09:40:00', '2022-10-15 09:40:00'),
(8, 3, 2, 3, '2022-10-18 04:45:55', '2022-10-18 06:42:10');

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
(41, '2014_10_12_100000_create_password_resets_table', 1),
(42, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(43, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(44, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(45, '2016_06_01_000004_create_oauth_clients_table', 1),
(46, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(47, '2019_08_19_000000_create_failed_jobs_table', 1),
(48, '2022_09_04_044632_create_admins_table', 1),
(56, '2022_09_12_105148_create_tournaments_table', 4),
(57, '2022_09_13_142605_create_round_settings_table', 4),
(58, '2022_09_14_155619_create_playerenrolls_table', 5),
(59, '2014_10_12_000000_create_users_table', 6),
(64, '2022_09_22_163534_create_free2pgames_table', 7),
(67, '2022_09_25_095801_create_settings_table', 9),
(68, '2022_09_25_155905_add_new_column_last_login_in_usertable', 10),
(69, '2022_09_22_163601_create_free2pgamesettings_table', 11),
(71, '2022_09_26_112942_add_new_column_in_free2pgames', 12),
(76, '2022_09_28_095344_create_free3pgames_table', 13),
(77, '2022_09_28_103013_create_free3pgamesettings_table', 13),
(79, '2022_10_01_121458_add_new_column_status_in_round_settings', 14),
(80, '2022_10_01_123250_add_new_column_used_diamond-in_tournaments', 15),
(85, '2022_10_12_104702_create_free4playergames_table', 17),
(86, '2022_10_12_120854_create_free4playergamesettings_table', 17),
(87, '2022_10_01_130446_create_games_table', 18),
(88, '2022_10_01_130900_create_gamerounds_table', 18),
(89, '2022_10_01_130936_create_roundludoboards_table', 18),
(90, '2022_10_01_130952_create_playerinboards_table', 18),
(91, '2022_10_15_120715_create_biddings_table', 18),
(92, '2022_10_15_134346_add_new_column_game_id', 19),
(95, '2022_10_25_110453_create_biding_details_table', 20),
(97, '2022_10_26_144530_create_diamond_uses_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0942f103ff361418c582f276261a6ef38215cfe167632ad2ba5c4431671ce4486686e659c6f66e8d', 3, 3, 'MyApp', '[]', 0, '2022-10-20 11:50:15', '2022-10-20 11:50:15', '2023-10-20 17:50:15'),
('0f7cdf396cd4afa1fe3f5ed024cab754adaea3b9eeb27209be9285e42bf9eab6e57533bce5e3b7ae', 1, 1, 'MyApp', '[]', 0, '2022-09-17 11:37:37', '2022-09-17 11:37:37', '2023-09-17 17:37:37'),
('10a7d2818e808eb515b9b5d9da3ca83db6fa49595e9ed7dc33ad7c702bd5e3d481de8359d0b6e357', 1, 1, 'MyApp', '[]', 0, '2022-09-26 05:50:39', '2022-09-26 05:50:39', '2023-09-26 11:50:39'),
('12328cda0dbdbcb467bf7d9e88f20543777e6528b933b9e0e270bc3beb4eb97b2e74ec1c29589168', 5, 3, 'MyApp', '[]', 0, '2022-10-18 05:43:55', '2022-10-18 05:43:55', '2023-10-18 11:43:55'),
('130ea34373f9c6ffa8ff18842e675ad2a93b61d4c33ad36a20d9457277aceae50e6ffacd88d747c1', 3, 1, 'MyApp', '[]', 0, '2022-09-25 10:33:07', '2022-09-25 10:33:07', '2023-09-25 16:33:07'),
('134d83763dfe39a34eabaf4f3db3b228ec4a806725ed04b8222b2c971f08a525b28a8adb1b156365', 1, 1, 'MyApp', '[]', 0, '2022-09-26 03:25:37', '2022-09-26 03:25:37', '2023-09-26 09:25:37'),
('1a600ebe5ae97f863c6014b1144d105a9517b84c740808a88c07f95aa8ae6796d833299529f8887a', 1, 1, 'MyApp', '[]', 0, '2022-09-29 11:36:34', '2022-09-29 11:36:34', '2023-09-29 17:36:34'),
('258c74ebf73a0bf5292cebc09a48ff7cfcb94782ec3636e7315b5209f6e2eee036a2a15d54f88350', 4, 1, 'MyApp', '[]', 0, '2022-09-28 07:54:20', '2022-09-28 07:54:20', '2023-09-28 13:54:20'),
('29002518c5a491ff67067322f7ae90777e203362f69c758615cccce0cf6d98c46b4e269a34263162', 2, 1, 'MyApp', '[]', 0, '2022-09-25 10:21:27', '2022-09-25 10:21:27', '2023-09-25 16:21:27'),
('2eec1a65e842726e0d8b4482dae9360b0db2eff2ec4cf6c58f08325841ef04b0baeb6fa09fe05fe0', 1, 3, 'MyApp', '[]', 0, '2022-10-18 05:42:38', '2022-10-18 05:42:38', '2023-10-18 11:42:38'),
('307bb297001c720dfe8c7756706ac4e7205b23abf88553b4c8798b18056d970be91b18202739d68e', 1, 1, 'MyApp', '[]', 0, '2022-09-14 04:59:43', '2022-09-14 04:59:43', '2023-09-14 10:59:43'),
('33fa81e9ad2042f16c6ede8cda1eb3fa03b91739259b5e3979d9bc22efafb85c005a90b4f29c7160', 2, 1, 'MyApp', '[]', 0, '2022-09-25 10:22:29', '2022-09-25 10:22:29', '2023-09-25 16:22:29'),
('34f036395281b8e38416cbc96419a20a98602e21ea6de34b614fedd904d2c1bcb45f53aa509b7fbf', 6, 3, 'MyApp', '[]', 0, '2022-10-25 06:39:26', '2022-10-25 06:39:26', '2023-10-25 12:39:26'),
('3952f1ccd24cc63ca43e821e38144865f8055aad3387febe2d1c53facb076f0f863f9c17d9f63d09', 5, 1, 'MyApp', '[]', 0, '2022-09-28 07:57:06', '2022-09-28 07:57:06', '2023-09-28 13:57:06'),
('3e563ef08f7b7e0489e8f2fb7222bff5e75afd34822be03112c6e50267c98970415d9c5c00350a23', 6, 1, 'MyApp', '[]', 0, '2022-10-12 10:14:37', '2022-10-12 10:14:37', '2023-10-12 16:14:37'),
('3e8416692e0bf933aa184343761e3fe6417b3299b9a456d4c059bf3486617575aa1f91b491f408c1', 3, 3, 'MyApp', '[]', 0, '2022-10-18 05:47:11', '2022-10-18 05:47:11', '2023-10-18 11:47:11'),
('41f5d5f0cb3f7b14c828d3062ef44b6fda69145086438fb66cf640151cafae56d7847ffbc05e4441', 2, 1, 'MyApp', '[]', 0, '2022-09-29 08:35:47', '2022-09-29 08:35:47', '2023-09-29 14:35:47'),
('422d7b63005a75e38d51e72836f8c80c863b5c2d60f07cd0aa1aa9e891bfd082d64f42179bb4411b', 1, 1, 'MyApp', '[]', 0, '2022-10-12 07:57:40', '2022-10-12 07:57:40', '2023-10-12 13:57:40'),
('4c30a839ef1e3a21a70db25621ca2664f3dd781fc533e2785994ee794591614339a5502a7f09367c', 4, 3, 'MyApp', '[]', 0, '2022-10-26 09:38:52', '2022-10-26 09:38:52', '2023-10-26 15:38:52'),
('4f036554f9dc00993fe1f663ae810a95e2e85da06532f3c640a84bea849aa861709dce08a85a8b19', 4, 3, 'MyApp', '[]', 0, '2022-10-18 04:37:42', '2022-10-18 04:37:42', '2023-10-18 10:37:42'),
('4f9b6cfd78dddbaa7c13adbe5f6002918512c55c974c846f0ba1f8242c6048bff799ac88054a718a', 1, 1, 'MyApp', '[]', 0, '2022-10-13 03:47:47', '2022-10-13 03:47:47', '2023-10-13 09:47:47'),
('51b573050088dc8ba31ec7616ff17447f0e7f8473602f0062f498607989f98030d9a59695dd5a1e7', 3, 1, 'MyApp', '[]', 0, '2022-09-25 10:34:41', '2022-09-25 10:34:41', '2023-09-25 16:34:41'),
('537425b6db1905d3adfc1057292d2cc9aa089a9d462d988fd9a8a583719a72c151726ef2d6de2a2e', 1, 1, 'MyApp', '[]', 0, '2022-09-26 03:26:07', '2022-09-26 03:26:07', '2023-09-26 09:26:07'),
('55a12f2f4a009dffdd2aecd0f91713685b7f37e7bff1a95f00ada04e02460a44a273eed7aca1dab8', 1, 1, 'MyApp', '[]', 0, '2022-10-01 05:27:55', '2022-10-01 05:27:55', '2023-10-01 11:27:55'),
('5ad31f3589a39be8b5567e5af5b0bf58a16cf05b8eb97578f29b3b3aa92e5071f98925f18a8c7657', 6, 3, 'MyApp', '[]', 0, '2022-10-25 08:05:45', '2022-10-25 08:05:45', '2023-10-25 14:05:45'),
('5f1485b6abf90a77cd8e15eb4325cb1a0d4ffece8ea8d1b1e9e81de96920016c264a18742f5b5767', 3, 1, 'MyApp', '[]', 0, '2022-09-25 10:31:52', '2022-09-25 10:31:52', '2023-09-25 16:31:52'),
('5f65851f89334497fee62ca39c9485e27dd443373553038df6297b8a83318c1caa0a1bffb8ff0d59', 5, 3, 'MyApp', '[]', 0, '2022-10-25 07:46:12', '2022-10-25 07:46:12', '2023-10-25 13:46:12'),
('625fd5810a17eb7f9254c4dad23cd5e5a78025d231cbc718d57e8139ee7cd01b1deea85d95255fde', 1, 1, 'MyApp', '[]', 0, '2022-09-22 11:01:59', '2022-09-22 11:01:59', '2023-09-22 17:01:59'),
('62690d675ba49e19d8ad61a13ac6046521225e8479a5a64d8d92ee66773ec890bc1cf0058ded5dfb', 4, 3, 'MyApp', '[]', 0, '2022-10-27 06:21:47', '2022-10-27 06:21:47', '2023-10-27 12:21:47'),
('637bdfedb6ecc0c3346e89f1d2b00bbe4eb2ea762271e24c3eff912c98f3eb0fd902a75e39118d7e', 2, 1, 'MyApp', '[]', 0, '2022-09-25 10:22:53', '2022-09-25 10:22:53', '2023-09-25 16:22:53'),
('64b724f0a0c2c5bcf9f0af47a954b3f1c39e178f27ad2345e68fdfa3cd360be41a87b55050db7f1f', 5, 1, 'MyApp', '[]', 0, '2022-10-12 10:27:01', '2022-10-12 10:27:01', '2023-10-12 16:27:01'),
('6be8ebc07846b33ca18042c42c5d2e5e487b87c97ad2a3d4aad0b8ba709fe1468124a43e028e1bd8', 6, 3, 'MyApp', '[]', 0, '2022-10-18 05:45:20', '2022-10-18 05:45:20', '2023-10-18 11:45:20'),
('6e808269aba0eaf81b9e1c56718acdb2f839de624b9ab860748c6c618710da595cd05c1f6494b01d', 4, 3, 'MyApp', '[]', 0, '2022-10-25 08:07:41', '2022-10-25 08:07:41', '2023-10-25 14:07:41'),
('721c6315f70421f61fdc14b5a289ac6ef7074c5207d50eb8d289b01e703ccb9e8cc288c52f98ded1', 1, 1, 'MyApp', '[]', 0, '2022-09-26 03:26:32', '2022-09-26 03:26:32', '2023-09-26 09:26:32'),
('7b3cf556ae7f253f8b87035270127a9d7a042c978decc7528d57443c02e7780edf10c309a9eebcb7', 5, 3, 'MyApp', '[]', 0, '2022-10-25 08:06:46', '2022-10-25 08:06:46', '2023-10-25 14:06:46'),
('7e23e4b2a55c4f3965da5b91a002affc81214b5d37c2845f757f3c5efe0b11b4c6bae0a5278058ed', 2, 1, 'MyApp', '[]', 0, '2022-09-29 11:37:57', '2022-09-29 11:37:57', '2023-09-29 17:37:57'),
('7e71c472421940a0bc6aa789aa556956593af5077b05f99e47066c3797eeaf7ed66ce2dc209f18a5', 1, 1, 'MyApp', '[]', 0, '2022-09-29 10:26:17', '2022-09-29 10:26:17', '2023-09-29 16:26:17'),
('80a25a5e8d9cb6d4ed81f6e379e784fb2b46aba985fd22b5103c2bf1a4a6893d386c068dd4cef5f1', 1, 1, 'MyApp', '[]', 0, '2022-09-26 11:35:28', '2022-09-26 11:35:28', '2023-09-26 17:35:28'),
('83f5f08b5ea2b9c86de26ed71892bc2a00e0bad140990df263f6db0b61dbe4aa9e3dab3c75764220', 1, 1, 'MyApp', '[]', 0, '2022-09-29 10:23:37', '2022-09-29 10:23:37', '2023-09-29 16:23:37'),
('84243e33974fe97b716a964494e8eea032881eebff42d61cb7c203d6be7693a530f0738161175b78', 1, 1, 'MyApp', '[]', 0, '2022-09-28 05:28:59', '2022-09-28 05:28:59', '2023-09-28 11:28:59'),
('843677940b2d567e91b19d872d9c906ceaba7911d80aebb94cc0270cd7f362285e20bdf99ea3b8f5', 4, 1, 'MyApp', '[]', 0, '2022-09-26 03:27:06', '2022-09-26 03:27:06', '2023-09-26 09:27:06'),
('85c1503cb8d2d902800eac76d734516a159dac851071d66121662b1252985beacd037e3d7a9e7edd', 6, 3, 'MyApp', '[]', 0, '2022-10-25 07:48:54', '2022-10-25 07:48:54', '2023-10-25 13:48:54'),
('8a2c158303eecbf99ca616441b2e0c0158ce3253e1b663bbd538754e184462d160f965bd8887f0c3', 1, 1, 'MyApp', '[]', 0, '2022-10-15 09:38:10', '2022-10-15 09:38:10', '2023-10-15 15:38:10'),
('95141a1d621643ccf4118d2622f3751e4106525ab0f0a7017ccd5a3673df1687bb000dfda29cd662', 1, 1, 'MyApp', '[]', 0, '2022-09-25 10:41:31', '2022-09-25 10:41:31', '2023-09-25 16:41:31'),
('9e149fe795f79569300a753ef1e9a1da9b63ee2963e174ce70d43e62b3b19cd53d0b069b7c31ab0c', 3, 1, 'MyApp', '[]', 0, '2022-09-25 10:34:13', '2022-09-25 10:34:13', '2023-09-25 16:34:13'),
('a0c93e7b79f8c9e68d92baef7575084076922dc7bef44ee60bfd5355587cf84cb301005125537968', 2, 1, 'MyApp', '[]', 0, '2022-09-25 10:19:43', '2022-09-25 10:19:43', '2023-09-25 16:19:43'),
('aa26232adb093485b474727933c477f8ddd9f26ae4be566e3460dd9a0c8861f1fff74532c7dd21d8', 3, 1, 'MyApp', '[]', 0, '2022-09-25 10:30:03', '2022-09-25 10:30:03', '2023-09-25 16:30:03'),
('aca0a61d767fbba7fe4db0b8c049a2c8cae0bbd5c13cbc3e3999615f0e070b6323dfa77bf03eeb0d', 6, 1, 'MyApp', '[]', 0, '2022-09-28 08:00:44', '2022-09-28 08:00:44', '2023-09-28 14:00:44'),
('adb0642eada7d742c8e702f3c9f1df3a3fc7403a75ce4b03c63b0906740e851a0474852e7bc98864', 2, 1, 'MyApp', '[]', 0, '2022-09-25 10:25:01', '2022-09-25 10:25:01', '2023-09-25 16:25:01'),
('b6ac2bc969ddfd85d9f0f421ba0e9961a743ee709f402c812ed8357fd64db72ab25e8d9dcb03d49f', 4, 1, 'MyApp', '[]', 0, '2022-09-26 06:48:16', '2022-09-26 06:48:16', '2023-09-26 12:48:16'),
('ba8b6f75e5a9c983126b9ab09beef0f11721939dee98f141d18b3c1a9bb3de572c90ae71dba8294d', 2, 1, 'MyApp', '[]', 0, '2022-09-25 10:19:28', '2022-09-25 10:19:28', '2023-09-25 16:19:28'),
('c114f1b27991e9743484a107c53a692b6f8c48261d4ec793666b2c7a7d5876a5d895386876b83409', 1, 1, 'MyApp', '[]', 0, '2022-09-15 10:14:10', '2022-09-15 10:14:10', '2023-09-15 16:14:10'),
('c619afc8e51fcc3ce090ebf8c8bea7ca5704a3d2379f592457b8c49d1b4c8360fdb367d1baff7372', 1, 1, 'MyApp', '[]', 0, '2022-09-26 03:25:31', '2022-09-26 03:25:31', '2023-09-26 09:25:31'),
('ceef62a77f9d2920392914f50b56328d301e5bbc0a9108f473341145e7eca80c56650f427547a37e', 4, 1, 'MyApp', '[]', 0, '2022-09-28 07:51:43', '2022-09-28 07:51:43', '2023-09-28 13:51:43'),
('d03e304224d9926b265abf9eae3c0aa5e443360afcd8fbba9ad2e38d5bdf9db997cb4b20d36b4c23', 3, 3, 'MyApp', '[]', 0, '2022-10-18 10:31:17', '2022-10-18 10:31:17', '2023-10-18 16:31:17'),
('d57101826d2f4f698681039052526f4d0adcadd4a7f7c1db44928aa86ee2abbd35165ebf56c5b724', 2, 1, 'MyApp', '[]', 0, '2022-09-25 10:21:02', '2022-09-25 10:21:02', '2023-09-25 16:21:02'),
('d973c751ce0425a8ed35b343c38cb9426995a1700d719de9a8fbc01139c4c51afc9488c0b0806298', 2, 1, 'MyApp', '[]', 0, '2022-09-25 12:15:54', '2022-09-25 12:15:54', '2023-09-25 18:15:54'),
('e0c3160b078d28ce4745847cae534ee3b47588ffafb7eba58809d0178055e36bd29742c4b98eecb1', 4, 1, 'MyApp', '[]', 0, '2022-09-26 03:26:54', '2022-09-26 03:26:54', '2023-09-26 09:26:54'),
('ea5ba835cb86677d2d069d7af380bef61843bfed14ad80e6fac85641f1442ba2c501a65ed51eeb6b', 3, 3, 'MyApp', '[]', 0, '2022-10-26 09:38:13', '2022-10-26 09:38:13', '2023-10-26 15:38:13'),
('f04ee3fd822923921e93ddd1c493a093b6ade8d044c8ce3ed9d35d3e76f12f560074b809a04d634d', 2, 1, 'MyApp', '[]', 0, '2022-09-25 10:16:43', '2022-09-25 10:16:43', '2023-09-25 16:16:43'),
('f5894d3b85f09df6760d05229d1f82b8f6de184d9f731eca9d5539c294b09793bc481957a8330a12', 4, 1, 'MyApp', '[]', 0, '2022-10-15 09:41:28', '2022-10-15 09:41:28', '2023-10-15 15:41:28'),
('ff324f8610bf7f975d2be6b1f4b5bd1fdd94a7f6b031c12d5872164532d12ff5a864733e0acff01b', 4, 1, 'MyApp', '[]', 0, '2022-10-12 10:32:01', '2022-10-12 10:32:01', '2023-10-12 16:32:01');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'LUDO CORNER Personal Access Client', 'OnvHznMR1FAYfjoXQbzXlqRif3NS8rIj0bdoQXEr', NULL, 'http://localhost', 1, 0, 0, '2022-09-14 03:24:46', '2022-09-14 03:24:46'),
(2, NULL, 'LUDO CORNER Password Grant Client', 'G4rEx9MQPgr4M25OvAv5N3cPLF9uspSkqkTL7dFg', 'users', 'http://localhost', 0, 1, 0, '2022-09-14 03:24:46', '2022-09-14 03:24:46'),
(3, NULL, 'LUDO CORNER Personal Access Client', 'g8YiTkP9GVNPa29Otcmu2TtfCArIkWGJXKnugbtx', NULL, 'http://localhost', 1, 0, 0, '2022-10-17 04:54:15', '2022-10-17 04:54:15'),
(4, NULL, 'LUDO CORNER Password Grant Client', '9PJxsjaK8QDS74u6MN1B1oRMyyD4FILcmbIRt6dW', 'users', 'http://localhost', 0, 1, 0, '2022-10-17 04:54:15', '2022-10-17 04:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-09-14 03:24:46', '2022-09-14 03:24:46'),
(2, 3, '2022-10-17 04:54:15', '2022-10-17 04:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playerenrolls`
--

CREATE TABLE `playerenrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `game_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playerenrolls`
--

INSERT INTO `playerenrolls` (`id`, `tournament_id`, `user_id`, `created_at`, `updated_at`, `game_id`) VALUES
(2, 1, 1, '2022-09-29 11:37:34', '2022-09-29 11:37:34', NULL),
(3, 1, 2, '2022-09-29 11:38:13', '2022-09-29 11:38:13', NULL),
(4, 2, 1, '2022-10-15 09:40:00', '2022-10-15 09:40:00', 1),
(11, 3, 4, '2022-10-18 04:45:55', '2022-10-18 04:45:55', 8),
(12, 3, 1, '2022-10-18 05:42:55', '2022-10-18 05:42:55', 8),
(13, 3, 5, '2022-10-18 05:44:15', '2022-10-18 05:44:15', 8),
(17, 3, 3, '2022-10-18 06:42:10', '2022-10-18 06:42:10', 8);

-- --------------------------------------------------------

--
-- Table structure for table `playerinboards`
--

CREATE TABLE `playerinboards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `round_id` bigint(20) UNSIGNED NOT NULL,
  `board_id` bigint(20) UNSIGNED NOT NULL,
  `player_one` int(11) DEFAULT NULL,
  `player_two` int(11) DEFAULT NULL,
  `player_three` int(11) DEFAULT NULL,
  `player_four` int(11) DEFAULT NULL,
  `first_winner` int(11) DEFAULT NULL,
  `second_winner` int(11) DEFAULT NULL,
  `third_winner` int(11) DEFAULT NULL,
  `fourth_winner` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending,1=Running,2=Complete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playerinboards`
--

INSERT INTO `playerinboards` (`id`, `tournament_id`, `game_id`, `round_id`, `board_id`, `player_one`, `player_two`, `player_three`, `player_four`, `first_winner`, `second_winner`, `third_winner`, `fourth_winner`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 8, 2, 2, 3, 6, 4, NULL, NULL, NULL, NULL, NULL, 0, '2022-10-20 11:52:05', '2022-10-26 09:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `roundludoboards`
--

CREATE TABLE `roundludoboards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `round_id` bigint(20) UNSIGNED NOT NULL,
  `board` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending,1=Running,2=Complete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roundludoboards`
--

INSERT INTO `roundludoboards` (`id`, `tournament_id`, `game_id`, `round_id`, `board`, `status`, `created_at`, `updated_at`) VALUES
(2, 3, 8, 2, 'sdgdsfg', 1, '2022-10-20 11:52:05', '2022-10-25 09:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `round_settings`
--

CREATE TABLE `round_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_id` bigint(20) UNSIGNED NOT NULL,
  `board_quantity` int(11) NOT NULL,
  `round_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_gaping` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diamond_limit` int(11) DEFAULT NULL,
  `first_bonus_point` double DEFAULT NULL,
  `second_bonus_point` double DEFAULT NULL,
  `third_bonus_point` double DEFAULT NULL,
  `fourth_bonus_point` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `used_diamond` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `round_settings`
--

INSERT INTO `round_settings` (`id`, `tournament_id`, `board_quantity`, `round_type`, `time_gaping`, `diamond_limit`, `first_bonus_point`, `second_bonus_point`, `third_bonus_point`, `fourth_bonus_point`, `created_at`, `updated_at`, `status`, `used_diamond`) VALUES
(1, 1, 16, '1', '134', 1, NULL, NULL, 1, 1, '2022-09-17 07:48:42', '2022-09-17 11:03:00', 0, 0),
(2, 1, 8, '2', '122', 1, NULL, NULL, 2, 2, '2022-09-17 07:48:42', '2022-09-17 11:03:00', 0, 0),
(3, 1, 4, '3', '183', 1, NULL, NULL, 3, 3, '2022-09-17 07:48:42', '2022-09-17 11:03:00', 0, 0),
(4, 1, 2, '4', '244', 1, NULL, NULL, 7, 4, '2022-09-17 07:48:42', '2022-09-17 11:03:00', 0, 0),
(5, 1, 1, 'final', NULL, 1, 9, 3, 7, 6, '2022-09-17 07:48:42', '2022-09-17 11:03:00', 0, 0),
(6, 2, 16, '1', '61', NULL, NULL, NULL, NULL, 1, '2022-09-17 11:19:03', '2022-09-17 11:20:28', 0, 0),
(7, 2, 8, '2', '122', NULL, NULL, NULL, NULL, 2, '2022-09-17 11:19:03', '2022-09-17 11:20:28', 0, 0),
(8, 2, 4, '3', '183', NULL, NULL, NULL, NULL, 3, '2022-09-17 11:19:03', '2022-09-17 11:20:28', 0, 0),
(9, 2, 1, 'final', NULL, NULL, 8, 7, 6, 5, '2022-09-17 11:19:03', '2022-09-17 11:20:28', 0, 0),
(10, 3, 1, 'final', NULL, 2, 100, 50, 40, 30, '2022-10-18 04:36:51', '2022-10-24 10:15:16', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `free_login_coin` double NOT NULL DEFAULT 0,
  `free_login_diamond` double NOT NULL DEFAULT 0,
  `max_withdraw_limit` double NOT NULL DEFAULT 0,
  `min_withdraw_limit` double NOT NULL DEFAULT 0,
  `referal_bonus` double NOT NULL DEFAULT 0,
  `game_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `free_login_coin`, `free_login_diamond`, `max_withdraw_limit`, `min_withdraw_limit`, `referal_bonus`, `game_logo`, `created_at`, `updated_at`) VALUES
(1, 10000, 10000, 500, 100, 100, NULL, '2022-09-25 04:25:35', '2022-09-25 04:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE `tournaments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tournament_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_start_delay_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_sub_type` int(11) DEFAULT NULL,
  `player_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `player_limit` int(11) NOT NULL,
  `player_enroll` int(11) NOT NULL DEFAULT 0,
  `registration_use` int(11) NOT NULL DEFAULT 1,
  `diamond_use` int(11) NOT NULL DEFAULT 1,
  `registration_fee` double NOT NULL,
  `winning_prize` double NOT NULL,
  `diamond_limit` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `used_diamond` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`id`, `tournament_name`, `game_type`, `game_start_delay_time`, `game_sub_type`, `player_type`, `player_limit`, `player_enroll`, `registration_use`, `diamond_use`, `registration_fee`, `winning_prize`, `diamond_limit`, `status`, `created_at`, `updated_at`, `used_diamond`) VALUES
(1, 'e3wras', '1', '63', 1, '4p', 64, 2, 1, 1, 22, 32, 3, 1, '2022-09-17 07:48:42', '2022-09-29 11:38:13', 0),
(2, 'demo', '1', '182', 1, '2p', 32, 1, 1, 0, 323, 400, NULL, 1, '2022-09-17 11:19:03', '2022-10-15 09:40:00', 0),
(3, '2p', '1', '61', 1, '4p', 4, 0, 0, 1, 2000, 3000, 2, 1, '2022-10-18 04:36:51', '2022-10-18 04:36:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `playerid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_hit` int(11) NOT NULL DEFAULT 0,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `playcoin` double NOT NULL DEFAULT 0,
  `shareholder_fund` double NOT NULL DEFAULT 0,
  `marketing_balance` double NOT NULL DEFAULT 0,
  `recovery_fund` double NOT NULL DEFAULT 0,
  `crypto_asset` double NOT NULL DEFAULT 0,
  `paid_diamond` double NOT NULL DEFAULT 0,
  `paid_coin` double NOT NULL DEFAULT 0,
  `free_coin` double NOT NULL DEFAULT 0,
  `free_diamond` double NOT NULL DEFAULT 0,
  `win_balance` double NOT NULL DEFAULT 0,
  `max_win` double NOT NULL DEFAULT 0,
  `max_loos` double NOT NULL DEFAULT 0,
  `refer_code` int(11) NOT NULL DEFAULT 0,
  `used_reffer_code` int(11) NOT NULL DEFAULT 0,
  `otp_verified_at` timestamp NULL DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `playerid`, `email`, `max_hit`, `country`, `mobile`, `otp`, `gender`, `avatar`, `playcoin`, `shareholder_fund`, `marketing_balance`, `recovery_fund`, `crypto_asset`, `paid_diamond`, `paid_coin`, `free_coin`, `free_diamond`, `win_balance`, `max_win`, `max_loos`, `refer_code`, `used_reffer_code`, `otp_verified_at`, `dob`, `email_verified_at`, `status`, `remember_token`, `created_at`, `updated_at`, `last_login`) VALUES
(1, 'Dev team', '69609080', 'chro.cse1998@gmail.com', 2, 'bd', '01948451764', '38046', 'male', 'sda', 0, 0, 0, 0, 0, 0, 0, 78148, 90000, 0, 0, 0, 0, 25434, '2022-09-22 11:01:59', '2022-11-12', NULL, 0, NULL, '2022-09-22 11:01:24', '2022-10-18 05:42:38', '2022-10-18'),
(2, 'Chiron', '94989248', 'chiron.cse1998@gmail.com', 0, 'uk', NULL, '37065', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 10001, 10000, 0, 0, 0, 0, 0, '2022-09-25 10:16:43', NULL, NULL, 0, NULL, '2022-09-25 10:16:43', '2022-09-29 11:37:57', '2022-09-29'),
(3, NULL, '26114287', NULL, 4, 'bd', '01948451766', '74564', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 50000, 50000, 100, 0, 0, 0, 0, '2022-09-25 10:30:03', NULL, NULL, 0, NULL, '2022-09-25 10:29:37', '2022-10-26 09:38:13', '2022-10-26'),
(4, 'Chiron', '47214504', 'chron.cse1998@gmail.com', 0, 'uk', NULL, '83387', NULL, NULL, 0, 0, 0, 0, 0, 1, 99960, 82742, 80000, 50, 0, 0, 0, 0, '2022-09-26 03:26:54', NULL, NULL, 0, NULL, '2022-09-26 03:26:54', '2022-10-27 10:35:23', '2022-10-27'),
(5, 'Mohon', '91263526', 'chron@gmail.com', 0, 'uk', NULL, '21125', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 37198, 40000, 40, 0, 0, 0, 0, '2022-09-28 07:57:06', NULL, NULL, 0, NULL, '2022-09-28 07:57:06', '2022-10-25 09:36:41', '2022-10-25'),
(6, 'shajahan', '48579303', 'shajahan@gmail.com', 0, 'uk', NULL, '40901', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 36748, 40000, 30, 0, 0, 0, 0, '2022-09-28 08:00:44', NULL, NULL, 0, NULL, '2022-09-28 08:00:44', '2022-10-25 09:37:24', '2022-10-25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `biddings`
--
ALTER TABLE `biddings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biddings_tournament_id_foreign` (`tournament_id`),
  ADD KEY `biddings_game_id_foreign` (`game_id`),
  ADD KEY `biddings_round_id_foreign` (`round_id`),
  ADD KEY `biddings_board_id_foreign` (`board_id`);

--
-- Indexes for table `biding_details`
--
ALTER TABLE `biding_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biding_details_userid_foreign` (`userid`),
  ADD KEY `biding_details_tournament_id_foreign` (`tournament_id`),
  ADD KEY `biding_details_game_id_foreign` (`game_id`),
  ADD KEY `biding_details_round_id_foreign` (`round_id`),
  ADD KEY `biding_details_board_id_foreign` (`board_id`),
  ADD KEY `biding_details_bided_to_foreign` (`bided_to`);

--
-- Indexes for table `diamond_uses`
--
ALTER TABLE `diamond_uses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diamond_uses_userid_foreign` (`userid`),
  ADD KEY `diamond_uses_tournament_id_foreign` (`tournament_id`),
  ADD KEY `diamond_uses_game_id_foreign` (`game_id`),
  ADD KEY `diamond_uses_round_id_foreign` (`round_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `free2pgames`
--
ALTER TABLE `free2pgames`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `free2pgamesettings`
--
ALTER TABLE `free2pgamesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `free3pgames`
--
ALTER TABLE `free3pgames`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `free3pgamesettings`
--
ALTER TABLE `free3pgamesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `free4playergames`
--
ALTER TABLE `free4playergames`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `free4playergamesettings`
--
ALTER TABLE `free4playergamesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gamerounds`
--
ALTER TABLE `gamerounds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gamerounds_tournament_id_foreign` (`tournament_id`),
  ADD KEY `gamerounds_game_id_foreign` (`game_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `games_tournament_id_foreign` (`tournament_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `playerenrolls`
--
ALTER TABLE `playerenrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playerenrolls_tournament_id_foreign` (`tournament_id`),
  ADD KEY `playerenrolls_game_id_foreign` (`game_id`);

--
-- Indexes for table `playerinboards`
--
ALTER TABLE `playerinboards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playerinboards_tournament_id_foreign` (`tournament_id`),
  ADD KEY `playerinboards_game_id_foreign` (`game_id`),
  ADD KEY `playerinboards_round_id_foreign` (`round_id`),
  ADD KEY `playerinboards_board_id_foreign` (`board_id`);

--
-- Indexes for table `roundludoboards`
--
ALTER TABLE `roundludoboards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roundludoboards_tournament_id_foreign` (`tournament_id`),
  ADD KEY `roundludoboards_game_id_foreign` (`game_id`),
  ADD KEY `roundludoboards_round_id_foreign` (`round_id`);

--
-- Indexes for table `round_settings`
--
ALTER TABLE `round_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `round_settings_tournament_id_foreign` (`tournament_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_playerid_unique` (`playerid`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `biddings`
--
ALTER TABLE `biddings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biding_details`
--
ALTER TABLE `biding_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `diamond_uses`
--
ALTER TABLE `diamond_uses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `free2pgames`
--
ALTER TABLE `free2pgames`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `free2pgamesettings`
--
ALTER TABLE `free2pgamesettings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `free3pgames`
--
ALTER TABLE `free3pgames`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `free3pgamesettings`
--
ALTER TABLE `free3pgamesettings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `free4playergames`
--
ALTER TABLE `free4playergames`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `free4playergamesettings`
--
ALTER TABLE `free4playergamesettings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gamerounds`
--
ALTER TABLE `gamerounds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `playerenrolls`
--
ALTER TABLE `playerenrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `playerinboards`
--
ALTER TABLE `playerinboards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roundludoboards`
--
ALTER TABLE `roundludoboards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `round_settings`
--
ALTER TABLE `round_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `biddings`
--
ALTER TABLE `biddings`
  ADD CONSTRAINT `biddings_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `roundludoboards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biddings_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biddings_round_id_foreign` FOREIGN KEY (`round_id`) REFERENCES `gamerounds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biddings_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `biding_details`
--
ALTER TABLE `biding_details`
  ADD CONSTRAINT `biding_details_bided_to_foreign` FOREIGN KEY (`bided_to`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biding_details_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `roundludoboards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biding_details_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biding_details_round_id_foreign` FOREIGN KEY (`round_id`) REFERENCES `gamerounds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biding_details_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biding_details_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diamond_uses`
--
ALTER TABLE `diamond_uses`
  ADD CONSTRAINT `diamond_uses_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diamond_uses_round_id_foreign` FOREIGN KEY (`round_id`) REFERENCES `gamerounds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diamond_uses_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diamond_uses_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gamerounds`
--
ALTER TABLE `gamerounds`
  ADD CONSTRAINT `gamerounds_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gamerounds_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playerenrolls`
--
ALTER TABLE `playerenrolls`
  ADD CONSTRAINT `playerenrolls_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playerenrolls_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playerinboards`
--
ALTER TABLE `playerinboards`
  ADD CONSTRAINT `playerinboards_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `roundludoboards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playerinboards_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playerinboards_round_id_foreign` FOREIGN KEY (`round_id`) REFERENCES `gamerounds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playerinboards_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roundludoboards`
--
ALTER TABLE `roundludoboards`
  ADD CONSTRAINT `roundludoboards_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roundludoboards_round_id_foreign` FOREIGN KEY (`round_id`) REFERENCES `gamerounds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roundludoboards_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `round_settings`
--
ALTER TABLE `round_settings`
  ADD CONSTRAINT `round_settings_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
