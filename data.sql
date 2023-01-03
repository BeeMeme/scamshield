-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2021 at 11:03 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(32) UNSIGNED NOT NULL,
  `type` int(11) UNSIGNED NOT NULL,
  `condition` int(32) UNSIGNED NOT NULL,
  `reward_energy` int(32) UNSIGNED NOT NULL,
  `reward_usd` decimal(10,6) DEFAULT 0.000000
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `achievement_history`
--

CREATE TABLE `achievement_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `achievement_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `autofaucet_history`
--

CREATE TABLE `autofaucet_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cheat_logs`
--

CREATE TABLE `cheat_logs` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `log` varchar(150) DEFAULT NULL,
  `create_time` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coinflip_history`
--

CREATE TABLE `coinflip_history` (
  `id` int(32) NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `coin` varchar(3) NOT NULL,
  `result` varchar(3) NOT NULL,
  `bet_amount` decimal(10,6) NOT NULL,
  `profit` decimal(10,6) NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(32) UNSIGNED NOT NULL,
  `currency_name` varchar(75) NOT NULL,
  `name` varchar(75) NOT NULL,
  `code` varchar(75) NOT NULL,
  `api` varchar(75) NOT NULL,
  `token` varchar(75) NOT NULL,
  `price` decimal(14,8) NOT NULL,
  `wallet` varchar(20) NOT NULL,
  `account_number` varchar(30) NOT NULL,
  `api_id` varchar(30) NOT NULL,
  `minimum_withdrawal` decimal(10,6) DEFAULT 0.000001,
  `status` int(11) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `code` varchar(75) NOT NULL,
  `status` varchar(75) NOT NULL,
  `create_time` int(32) UNSIGNED NOT NULL,
  `type` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dice_history`
--

CREATE TABLE `dice_history` (
  `id` int(60) NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `salt` varchar(100) NOT NULL,
  `roll` decimal(5,2) NOT NULL,
  `target` decimal(5,2) NOT NULL,
  `bet` decimal(10,6) DEFAULT 0.000000,
  `profit` decimal(10,6) DEFAULT 0.000000,
  `open` int(1) NOT NULL,
  `type` int(1) NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faucet_history`
--

CREATE TABLE `faucet_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faucet_stats`
--

CREATE TABLE `faucet_stats` (
  `id` int(32) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `new_users` int(32) UNSIGNED DEFAULT 0,
  `active_users` int(32) UNSIGNED DEFAULT 0,
  `autofaucet_count` int(32) UNSIGNED DEFAULT 0,
  `faucet_count` int(32) UNSIGNED DEFAULT 0,
  `shortlink_count` int(32) UNSIGNED DEFAULT 0,
  `ptc_count` int(32) UNSIGNED DEFAULT 0,
  `dice_count` int(32) UNSIGNED DEFAULT 0,
  `offerwall_count` int(32) UNSIGNED DEFAULT 0,
  `deposit_count` int(32) UNSIGNED DEFAULT 0,
  `autofaucet_amount` decimal(10,6) DEFAULT 0.000000,
  `faucet_amount` decimal(10,6) DEFAULT 0.000000,
  `shortlink_amount` decimal(10,6) DEFAULT 0.000000,
  `ptc_amount` decimal(10,6) DEFAULT 0.000000,
  `dice_amount` decimal(10,6) DEFAULT 0.000000,
  `offerwall_amount` decimal(10,6) DEFAULT 0.000000,
  `deposit_amount` decimal(10,6) DEFAULT 0.000000,
  `withdraw_amount` decimal(10,6) DEFAULT 0.000000,
  `is_done` int(11) UNSIGNED DEFAULT 0,
  `coinflip_count` int(32) UNSIGNED DEFAULT 0,
  `coinflip_amount` decimal(10,6) DEFAULT 0.000000,
  `achievement_count` int(32) UNSIGNED DEFAULT 0,
  `achievement_amount` decimal(10,6) DEFAULT 0.000000,
  `wheel_amount` decimal(10,6) DEFAULT 0.000000,
  `wheel_count` int(32) UNSIGNED DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip_addresses`
--

CREATE TABLE `ip_addresses` (
  `id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `last_use` int(32) UNSIGNED NOT NULL,
  `sub` varchar(75) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(32) UNSIGNED NOT NULL,
  `name` varchar(75) NOT NULL,
  `reward` decimal(10,6) DEFAULT 0.000000,
  `energy` int(32) UNSIGNED DEFAULT 0,
  `url` longtext NOT NULL,
  `view_per_day` int(11) UNSIGNED DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `link_history`
--

CREATE TABLE `link_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `link_id` int(10) NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lotteries`
--

CREATE TABLE `lotteries` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `number` int(32) UNSIGNED NOT NULL,
  `create_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lottery_winners`
--

CREATE TABLE `lottery_winners` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `number` int(32) UNSIGNED NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `create_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `content` varchar(200) NOT NULL,
  `status` int(11) DEFAULT 0,
  `type` int(11) DEFAULT 0,
  `create_time` int(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offerwall_history`
--

CREATE TABLE `offerwall_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `offerwall` varchar(50) NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `trans_id` varchar(40) NOT NULL,
  `status` int(10) DEFAULT 0,
  `available_at` int(32) NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offerwall_ips`
--

CREATE TABLE `offerwall_ips` (
  `id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `last_use` int(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `other_history`
--

CREATE TABLE `other_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(32) UNSIGNED NOT NULL,
  `title` longtext NOT NULL,
  `slug` varchar(50) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ptc_ads`
--

CREATE TABLE `ptc_ads` (
  `id` int(32) UNSIGNED NOT NULL,
  `owner` int(32) UNSIGNED NOT NULL,
  `name` varchar(75) NOT NULL,
  `description` varchar(75) NOT NULL,
  `reward` decimal(10,6) DEFAULT 0.000000,
  `timer` int(32) UNSIGNED NOT NULL,
  `url` longtext NOT NULL,
  `total_view` int(32) NOT NULL,
  `views` int(32) NOT NULL,
  `status` varchar(10) NOT NULL,
  `option_id` int(32) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ptc_history`
--

CREATE TABLE `ptc_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `ad_id` int(32) UNSIGNED NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `ip_address` varchar(75) NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ptc_option`
--

CREATE TABLE `ptc_option` (
  `id` int(32) UNSIGNED NOT NULL,
  `timer` int(32) UNSIGNED NOT NULL,
  `price` decimal(10,6) DEFAULT 0.000000,
  `reward` decimal(10,6) DEFAULT 0.000000,
  `min_view` int(32) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(32) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'status', 'off'),
(2, 'name', 'Vie Faucet Script'),
(3, 'description', 'Free Bitcoin'),
(4, 'site_email', 'admin@viefaucet.com'),
(5, 'admin_email', 'tungaqhd@gmail.com'),
(6, 'minimum_deposit', '1'),
(7, 'instant_withdraw', 'on'),
(8, 'withdraw_limit', '1'),
(9, 'timer', '300'),
(10, 'reward', '0.0006'),
(11, 'daily_limit', '100'),
(12, 'coinbase_api', ''),
(13, 'coinbase_secret', ''),
(14, 'referral', '10'),
(15, 'iphub', ''),
(16, 'proxycheck', ''),
(17, 'antibotlinks', 'on'),
(18, 'footer_code', ''),
(19, 'authenticator_code', ''),
(20, 'username', 'admin'),
(21, 'password', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
(22, 'login_captcha', 'recaptchav2|solvemedia|hcaptcha'),
(23, 'register_captcha', 'recaptchav3|recaptchav2|solvemedia'),
(24, 'faucet_captcha', 'recaptchav3|recaptchav2|solvemedia'),
(25, 'ptc_captcha', 'recaptchav2|solvemedia'),
(26, 'recaptcha_v3_site_key', ''),
(27, 'recaptcha_v3_secret_key', ''),
(28, 'recaptcha_v2_site_key', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'),
(29, 'recaptcha_v2_secret_key', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'),
(30, 'c_key', ''),
(31, 'v_key', ''),
(32, 'h_key', ''),
(33, 'hcaptcha_site_key', ''),
(34, 'hcaptcha_secret_key', ''),
(35, 'lottery_base_reward', '1'),
(36, 'lottery_price', '1'),
(37, 'lottery_reward', '1'),
(38, 'lottery_date', '0'),
(39, 'lottery_duration', '0'),
(40, 'autofaucet_timer', '60'),
(41, 'autofaucet_reward', '1'),
(42, 'autofaucet_cost', '10'),
(43, 'login_ad', ''),
(44, 'register_ad', ''),
(45, 'dashboard_top_ad', ''),
(46, 'dashboard_header_ad', ''),
(47, 'dashboard_bottom_ad', ''),
(48, 'achievements_top_ad', ''),
(49, 'achievements_footer_ad', ''),
(50, 'faucet_top_ad', ''),
(51, 'faucet_header_ad', ''),
(52, 'faucet_left_ad', ''),
(53, 'faucet_right_ad', ''),
(54, 'faucet_bottom_ad', ''),
(55, 'faucet_footer_ad', ''),
(56, 'autofaucet_top_ad', ''),
(57, 'links_top_ad', ''),
(58, 'links_footer_ad', ''),
(59, 'ptc_top_ad', ''),
(60, 'ptc_footer_ad', ''),
(61, 'lottery_top_ad', ''),
(62, 'lottery_bottom_ad', ''),
(63, 'lottery_left_ad', ''),
(64, 'lottery_right_ad', ''),
(65, 'achievement_exp_reward', '0'),
(66, 'faucet_exp_reward', '0'),
(67, 'shortlink_exp_reward', '0'),
(68, 'ptc_exp_reward', '0'),
(69, 'lottery_exp_reward', '0'),
(70, 'offerwall_exp_reward', '0'),
(71, 'autofaucet_exp_reward', '0'),
(72, 'achievement_status', 'on'),
(73, 'faucet_status', 'on'),
(74, 'autofaucet_status', 'on'),
(75, 'shortlink_status', 'on'),
(76, 'ptc_status', 'on'),
(77, 'lottery_status', 'on'),
(78, 'offerwall_status', 'on'),
(79, 'leaderboard_date', '0'),
(80, 'wannads_status', 'off'),
(81, 'offertoro_status', 'off'),
(82, 'cpx_status', 'off'),
(83, 'offerwall_min_level', '10'),
(84, 'offerwall_exp', '0'),
(85, 'wannads_api_key', ''),
(86, 'wannads_secret_key', ''),
(87, 'wannads_hold', ''),
(88, 'offertoro_pub_id', ''),
(89, 'offertoro_app_id', ''),
(90, 'offertoro_app_secret', ''),
(91, 'offertoro_hold', ''),
(92, 'cpx_app_id', ''),
(93, 'cpx_hash', ''),
(94, 'cpx_hold', ''),
(95, 'ayetstudios_status', 'off'),
(96, 'ayetstudios_id', ''),
(97, 'ayetstudios_api', ''),
(98, 'ayetstudios_hold', '1'),
(99, 'offerdaddy_status', 'off'),
(100, 'offerdaddy_hold', ''),
(101, 'offerdaddy_app_key', ''),
(102, 'offerdaddy_app_token', ''),
(103, 'personaly_status', 'off'),
(104, 'personaly_hold', ''),
(105, 'personaly_id', ''),
(106, 'personaly_hash', ''),
(107, 'personaly_secret_key', ''),
(108, 'dice_status', 'on'),
(109, 'max_bet', '1'),
(110, 'min_bet', '0.0001'),
(111, 'house_edge', '0.1'),
(112, 'faucetpay_username', 'tungaqhd'),
(113, 'faucetpay_currency', 'BTC'),
(114, 'mail_service', 'mail'),
(115, 'smtp_host', ''),
(116, 'smtp_port', ''),
(117, 'smtp_username', ''),
(118, 'smtp_password', ''),
(119, 'activity_contest_reward', ''),
(120, 'referral_contest_reward', ''),
(121, 'faucet_contest_reward', ''),
(122, 'shortlink_contest_reward', ''),
(123, 'offerwall_contest_reward', ''),
(124, 'firewall', 'off'),
(125, 'banned_mails', ''),
(126, 'global_notification', ''),
(127, 'captcha_fail_limit', '8'),
(128, 'admin_username', 'tungaqhd'),
(129, 'pollfish_status', 'off'),
(130, 'pollfish_hold', '1'),
(131, 'pollfish_api', ''),
(132, 'pollfish_secret', ''),
(133, 'theme', 'light'),
(134, 'home_page', '1'),
(135, 'bitswall_status', 'off'),
(136, 'bitswall_hold', '1'),
(137, 'bitswall_api', ''),
(138, 'bitswall_secret', ''),
(139, 'tasks_status', 'on'),
(140, 'tasks_top_ad', ''),
(141, 'tasks_footer_ad', ''),
(142, 'coinflip_status', 'off'),
(143, 'coinflip_edge', '1'),
(144, 'coinflip_top_ad', ''),
(145, 'coinflip_footer_ad', ''),
(146, 'coinflip_max_bet', '0.00001'),
(147, 'coinflip_min_bet', '1'),
(148, 'faucetpay_deposit_status', 'on'),
(149, 'coinbase_deposit_status', 'on'),
(150, 'payeer_status', 'on'),
(151, 'payeer_id', ''),
(152, 'payeer_secret', ''),
(153, 'payeer_min_deposit', '0.5'),
(154, 'coinbase_min_deposit', '0.5'),
(155, 'faucetpay_min_deposit', '0.5'),
(156, 'level_bonus', '0.001'),
(157, 'max_bonus', '0.5'),
(158, 'currency_name', 'token'),
(159, 'currency_rate', '0.00001'),
(160, 'faucet_cost', '10'),
(161, 'monlix_api', ''),
(162, 'monlix_secret', ''),
(163, 'monlix_hold', '1'),
(164, 'monlix_status', 'off'),
(165, 'wheel_energy', '10'),
(166, 'wheel_status', 'off'),
(167, 'wheel_timer', '20'),
(168, 'wheel_limit', '100'),
(169, 'wheel_top_ad', 'top'),
(170, 'wheel_header_ad', 'header'),
(171, 'wheel_left_ad', 'left'),
(172, 'wheel_right_ad', 'right'),
(173, 'wheel_bottom_ad', 'bottom'),
(174, 'wheel_footer_ad', 'footer'),
(175, 'mining_share', '80'),
(176, 'mining_status', 'off'),
(177, 'webminepool_site_key', ''),
(178, 'webminepool_secret_key', ''),
(179, 'btc_price', '20'),
(180, 'offerwall_min_hold', '0.5');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(32) UNSIGNED NOT NULL,
  `name` varchar(75) NOT NULL,
  `description` varchar(600) NOT NULL,
  `requirement` varchar(100) NOT NULL,
  `usd_reward` decimal(10,6) DEFAULT 0.000000,
  `energy_reward` int(32) UNSIGNED NOT NULL,
  `exp_reward` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_history`
--

CREATE TABLE `task_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `task_id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `usd_reward` decimal(10,6) DEFAULT 0.000000,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_submission`
--

CREATE TABLE `task_submission` (
  `id` int(32) UNSIGNED NOT NULL,
  `task_id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `proof` varchar(100) NOT NULL,
  `status` int(11) UNSIGNED DEFAULT 0,
  `claim_time` int(32) UNSIGNED NOT NULL,
  `hide` int(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(32) UNSIGNED NOT NULL,
  `email` varchar(75) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(75) NOT NULL,
  `wallet` varchar(50) NOT NULL,
  `balance` decimal(10,6) DEFAULT 0.000000,
  `dep_balance` decimal(10,6) DEFAULT 0.000000,
  `energy` int(32) UNSIGNED DEFAULT 0,
  `ip_address` varchar(75) NOT NULL,
  `referred_by` int(32) UNSIGNED DEFAULT 0,
  `last_claim` int(32) UNSIGNED DEFAULT 0,
  `last_active` int(32) UNSIGNED DEFAULT 0,
  `secret` varchar(30) NOT NULL,
  `token` varchar(30) NOT NULL,
  `claims` int(32) UNSIGNED DEFAULT 0,
  `verified` int(32) UNSIGNED DEFAULT 0,
  `isocode` varchar(10) DEFAULT 'N/A',
  `country` varchar(30) DEFAULT 'N/A',
  `exp` int(32) UNSIGNED DEFAULT 0,
  `level` int(32) UNSIGNED DEFAULT 0,
  `joined` int(32) UNSIGNED DEFAULT 0,
  `total_earned` decimal(10,6) DEFAULT 0.000000,
  `ref_count` int(32) UNSIGNED DEFAULT 0,
  `faucet_count_tmp` int(32) DEFAULT 0,
  `faucet_count` int(32) DEFAULT 0,
  `shortlink_count_tmp` int(32) DEFAULT 0,
  `shortlink_count` int(32) DEFAULT 0,
  `offerwall_count_tmp` int(32) DEFAULT 0,
  `offerwall_count` int(32) DEFAULT 0,
  `status` char(10) DEFAULT '0',
  `last_firewall` int(32) DEFAULT 0,
  `referral_source` varchar(75) NOT NULL,
  `fail` int(11) DEFAULT 0,
  `last_auto` int(32) UNSIGNED DEFAULT 0,
  `last_suspect` int(32) DEFAULT 0,
  `fp_hash` varchar(75) DEFAULT 'none',
  `wheel_cnt` int(32) DEFAULT 0,
  `wheel_claim` int(32) DEFAULT 0,
  `today_faucet` int(32) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `user_id` int(32) UNSIGNED NOT NULL,
  `link_id` int(32) UNSIGNED NOT NULL,
  `url` longtext NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `secret_keys` varchar(20) NOT NULL,
  `create_time` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wheel_history`
--

CREATE TABLE `wheel_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wheel_prizes`
--

CREATE TABLE `wheel_prizes` (
  `id` int(32) UNSIGNED NOT NULL,
  `color` varchar(10) NOT NULL,
  `usd_reward` decimal(10,6) DEFAULT 0.000000,
  `exp_reward` int(32) NOT NULL,
  `probability` decimal(5,3) DEFAULT 0.000,
  `text` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wheel_prizes`
--

INSERT INTO `wheel_prizes` (`id`, `color`, `usd_reward`, `exp_reward`, `probability`, `text`) VALUES
(1, '#845EC2', '0.001000', 10, '30.000', '0.001'),
(2, '#D65DB1', '0.002000', 10, '30.000', '0.002'),
(3, '#FF6F91', '0.003000', 10, '30.000', '0.003'),
(4, '#FF9671', '0.004000', 10, '10.000', '0.004');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_history`
--

CREATE TABLE `withdraw_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `method` int(10) UNSIGNED NOT NULL,
  `wallet` varchar(50) NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `achievement_history`
--
ALTER TABLE `achievement_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `autofaucet_history`
--
ALTER TABLE `autofaucet_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheat_logs`
--
ALTER TABLE `cheat_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coinflip_history`
--
ALTER TABLE `coinflip_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dice_history`
--
ALTER TABLE `dice_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faucet_history`
--
ALTER TABLE `faucet_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faucet_stats`
--
ALTER TABLE `faucet_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_history`
--
ALTER TABLE `link_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lotteries`
--
ALTER TABLE `lotteries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lottery_winners`
--
ALTER TABLE `lottery_winners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offerwall_history`
--
ALTER TABLE `offerwall_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offerwall_ips`
--
ALTER TABLE `offerwall_ips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_history`
--
ALTER TABLE `other_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ptc_ads`
--
ALTER TABLE `ptc_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ptc_history`
--
ALTER TABLE `ptc_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ptc_option`
--
ALTER TABLE `ptc_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_history`
--
ALTER TABLE `task_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_submission`
--
ALTER TABLE `task_submission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wheel_history`
--
ALTER TABLE `wheel_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wheel_prizes`
--
ALTER TABLE `wheel_prizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_history`
--
ALTER TABLE `withdraw_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `achievement_history`
--
ALTER TABLE `achievement_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `autofaucet_history`
--
ALTER TABLE `autofaucet_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheat_logs`
--
ALTER TABLE `cheat_logs`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coinflip_history`
--
ALTER TABLE `coinflip_history`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dice_history`
--
ALTER TABLE `dice_history`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faucet_history`
--
ALTER TABLE `faucet_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faucet_stats`
--
ALTER TABLE `faucet_stats`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `link_history`
--
ALTER TABLE `link_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lotteries`
--
ALTER TABLE `lotteries`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lottery_winners`
--
ALTER TABLE `lottery_winners`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offerwall_history`
--
ALTER TABLE `offerwall_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offerwall_ips`
--
ALTER TABLE `offerwall_ips`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_history`
--
ALTER TABLE `other_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ptc_ads`
--
ALTER TABLE `ptc_ads`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ptc_history`
--
ALTER TABLE `ptc_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ptc_option`
--
ALTER TABLE `ptc_option`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_history`
--
ALTER TABLE `task_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_submission`
--
ALTER TABLE `task_submission`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wheel_history`
--
ALTER TABLE `wheel_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wheel_prizes`
--
ALTER TABLE `wheel_prizes`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `withdraw_history`
--
ALTER TABLE `withdraw_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
