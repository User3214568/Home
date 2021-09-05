-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 05 sep. 2021 à 18:51
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `laravel`
--

-- --------------------------------------------------------

--
-- Structure de la table `criteres`
--

DROP TABLE IF EXISTS `criteres`;
CREATE TABLE IF NOT EXISTS `criteres` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `note_validation` double(8,2) NOT NULL,
  `note_aj` double(8,2) NOT NULL,
  `number_aj` int(11) NOT NULL,
  `number_nv` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `criteres`
--

INSERT INTO `criteres` (`id`, `note_validation`, `note_aj`, `number_aj`, `number_nv`, `created_at`, `updated_at`) VALUES
(3, 12.00, 8.00, 1, 2, '2021-08-29 19:41:24', '2021-08-29 19:41:24'),
(4, 1.00, 1.00, 1, 1, '2021-08-29 19:44:48', '2021-08-29 19:44:48'),
(5, 10.00, 10.00, 10, 10, '2021-08-29 19:50:47', '2021-08-29 19:50:47'),
(6, 12.00, 8.00, 1, 2, '2021-08-29 19:53:34', '2021-08-29 19:53:34'),
(7, 12.00, 8.00, 1, 2, '2021-08-29 19:56:39', '2021-08-29 19:56:39'),
(8, 12.00, 8.00, 1, 2, '2021-08-29 20:02:26', '2021-08-29 20:02:26'),
(9, 12.00, 8.00, 1, 2, '2021-08-29 20:10:10', '2021-08-29 20:10:10');

-- --------------------------------------------------------

--
-- Structure de la table `devoirs`
--

DROP TABLE IF EXISTS `devoirs`;
CREATE TABLE IF NOT EXISTS `devoirs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ratio` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `session` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `devoirs_module_id_foreign` (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `devoirs`
--

INSERT INTO `devoirs` (`id`, `name`, `ratio`, `created_at`, `updated_at`, `module_id`, `session`) VALUES
(1, 'CC1', 30.00, '2021-08-28 18:15:35', '2021-08-28 18:15:35', 12, 0),
(2, 'CC2', 70.00, '2021-08-28 18:15:35', '2021-08-28 18:15:35', 12, 0),
(3, 'CC1', 100.00, '2021-08-28 18:20:19', '2021-08-28 18:20:19', 13, 0),
(5, 'CC2', 50.00, '2021-08-28 18:20:49', '2021-08-28 18:20:49', 14, 0),
(6, 'MiniProjet', 20.00, '2021-08-28 18:20:49', '2021-08-28 18:20:49', 14, 0),
(36, 'CC1', 100.00, '2021-09-05 17:38:04', '2021-09-05 17:38:04', 24, 1),
(17, 'RAT', 100.00, '2021-08-29 19:15:45', '2021-08-29 19:15:45', 17, 2),
(16, 'CC2', 50.00, '2021-08-29 19:15:45', '2021-08-29 19:15:45', 17, 1),
(15, 'CC1', 50.00, '2021-08-29 19:15:45', '2021-08-29 19:15:45', 17, 1),
(13, 'CC1', 100.00, '2021-08-29 16:28:32', '2021-08-29 16:28:32', 16, 1),
(14, 'CC', 100.00, '2021-08-29 16:28:32', '2021-08-29 16:28:32', 16, 2),
(18, 'CC1', 25.00, '2021-08-29 19:16:52', '2021-08-29 19:16:52', 18, 1),
(19, 'CC2', 50.00, '2021-08-29 19:16:52', '2021-08-29 19:16:52', 18, 1),
(20, 'Mini Projet', 25.00, '2021-08-29 19:16:52', '2021-08-29 19:16:52', 18, 1),
(21, 'Control', 70.00, '2021-08-29 19:16:52', '2021-08-29 19:16:52', 18, 2),
(22, 'Mini Projet', 30.00, '2021-08-29 19:16:52', '2021-08-29 19:16:52', 18, 2),
(23, 'CC', 100.00, '2021-08-29 19:17:18', '2021-08-29 19:17:18', 19, 1),
(24, 'Control', 100.00, '2021-08-29 19:17:18', '2021-08-29 19:17:18', 19, 2),
(25, 'CC1', 30.00, '2021-08-29 19:18:25', '2021-08-29 19:18:25', 20, 1),
(26, 'CC2', 50.00, '2021-08-29 19:18:25', '2021-08-29 19:18:25', 20, 1),
(27, 'AC', 20.00, '2021-08-29 19:18:25', '2021-08-29 19:18:25', 20, 1),
(28, 'Control', 100.00, '2021-08-29 19:18:25', '2021-08-29 19:18:25', 20, 2),
(29, 'CC', 100.00, '2021-08-29 19:26:55', '2021-08-29 19:26:55', 21, 1),
(30, 'Control', 100.00, '2021-08-29 19:26:55', '2021-08-29 19:26:55', 21, 2),
(31, 'CC1', 50.00, '2021-08-29 19:27:35', '2021-08-29 19:27:35', 22, 1),
(32, 'CC2', 50.00, '2021-08-29 19:27:35', '2021-08-29 19:27:35', 22, 1),
(33, 'Control', 100.00, '2021-08-29 19:27:35', '2021-08-29 19:27:35', 22, 2),
(34, 'CC', 100.00, '2021-08-29 19:27:57', '2021-08-29 19:27:57', 23, 1),
(35, 'RAT', 100.00, '2021-08-29 19:27:57', '2021-08-29 19:27:57', 23, 2),
(37, 'Control', 100.00, '2021-09-05 17:38:04', '2021-09-05 17:38:04', 24, 2);

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `cin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cne` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `born_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `born_place` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cin`),
  KEY `etudiants_formation_id_foreign` (`formation_id`),
  KEY `etudiants_promotion_id_foreign` (`promotion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`cin`, `cne`, `email`, `first_name`, `last_name`, `born_date`, `created_at`, `updated_at`, `formation_id`, `promotion_id`, `born_place`, `phone`) VALUES
('L5486', NULL, 'said@gmail.com', 'EL Makkaoui', 'Yassine', '1996-10-10', '2021-09-05 17:10:27', '2021-09-05 17:10:27', 26, 94, 'Fes', '68745654213'),
('Q4566', NULL, 'said@gmail.com', 'Makhlouf', 'Ibrahim', '1996-10-10', '2021-09-05 16:21:53', '2021-09-05 16:21:53', 26, 94, 'Fes', '68745654213'),
('A54889', NULL, 'said@gmail.com', 'Hamdi', 'Ali', '1995-10-15', '2021-09-05 16:15:22', '2021-09-05 16:15:22', 26, 94, 'Casablance', '695468979');

-- --------------------------------------------------------

--
-- Structure de la table `evaluations`
--

DROP TABLE IF EXISTS `evaluations`;
CREATE TABLE IF NOT EXISTS `evaluations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` double(8,2) DEFAULT NULL,
  `etudiant_cin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `devoir_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `evaluations_etudiant_cin_foreign` (`etudiant_cin`)
) ENGINE=MyISAM AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evaluations`
--

INSERT INTO `evaluations` (`id`, `created_at`, `updated_at`, `note`, `etudiant_cin`, `devoir_id`) VALUES
(169, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 15),
(168, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 16),
(166, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 19),
(165, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 18),
(164, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 23),
(159, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 29),
(157, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 16),
(156, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 20),
(155, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 19),
(154, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 18),
(153, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 23),
(152, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 23),
(146, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 16),
(145, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 20),
(144, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 19),
(143, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 18),
(142, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 23),
(141, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 23),
(110, '2021-08-30 08:08:06', '2021-09-01 02:35:10', 11.00, 'D12', 23),
(111, '2021-08-30 08:08:06', '2021-08-30 08:08:06', NULL, 'D12', 23),
(112, '2021-08-30 08:08:06', '2021-08-30 08:08:06', NULL, 'D12', 18),
(113, '2021-08-30 08:08:06', '2021-08-30 08:08:06', NULL, 'D12', 19),
(114, '2021-08-30 08:08:06', '2021-08-30 08:08:06', NULL, 'D12', 20),
(115, '2021-08-30 08:08:06', '2021-08-30 08:08:06', NULL, 'D12', 16),
(116, '2021-08-30 08:08:06', '2021-08-30 08:08:06', NULL, 'D12', 15),
(117, '2021-08-30 08:08:07', '2021-08-31 16:09:02', 13.50, 'F13', 29),
(118, '2021-08-30 08:08:07', '2021-08-31 13:50:57', 16.00, 'F13', 25),
(119, '2021-08-30 08:08:07', '2021-08-31 13:50:57', 4.00, 'F13', 26),
(120, '2021-08-30 08:08:07', '2021-08-31 13:50:57', 11.00, 'F13', 27),
(121, '2021-08-30 08:08:07', '2021-09-01 02:35:10', 13.25, 'F13', 23),
(122, '2021-08-30 08:08:07', '2021-08-30 08:08:07', NULL, 'F13', 23),
(123, '2021-08-30 08:08:07', '2021-08-30 08:08:07', NULL, 'F13', 18),
(124, '2021-08-30 08:08:07', '2021-08-30 08:08:07', NULL, 'F13', 19),
(125, '2021-08-30 08:08:07', '2021-08-30 08:08:07', NULL, 'F13', 20),
(126, '2021-08-30 08:08:07', '2021-08-30 08:08:07', NULL, 'F13', 16),
(127, '2021-08-30 08:08:07', '2021-08-30 08:08:07', NULL, 'F13', 15),
(167, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 20),
(150, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 26),
(149, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 25),
(148, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 29),
(139, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 26),
(138, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 25),
(137, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 29),
(163, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 23),
(151, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 27),
(140, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 27),
(162, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 27),
(161, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 26),
(160, '2021-09-05 17:10:27', '2021-09-05 17:10:27', NULL, 'L5486', 25),
(158, '2021-09-05 16:21:53', '2021-09-05 16:21:53', NULL, 'Q4566', 15),
(147, '2021-09-05 16:15:22', '2021-09-05 16:15:22', NULL, 'A54889', 15),
(128, '2021-09-01 02:35:43', '2021-09-01 03:27:39', 7.50, 'A11', 24),
(129, '2021-09-01 02:35:43', '2021-09-01 04:02:35', 15.80, 'C11', 24),
(130, '2021-09-01 02:35:43', '2021-09-01 04:02:35', 17.20, 'D12', 24),
(131, '2021-09-01 02:40:58', '2021-09-01 02:40:58', NULL, 'A11', 24),
(132, '2021-09-01 02:40:58', '2021-09-01 02:40:58', NULL, 'C11', 24),
(133, '2021-09-01 02:40:58', '2021-09-01 02:40:58', NULL, 'D12', 24),
(134, '2021-09-01 17:49:38', '2021-09-01 17:51:38', 12.50, 'A11', 30),
(135, '2021-09-01 17:50:27', '2021-09-01 17:50:27', NULL, 'A11', 30),
(136, '2021-09-01 17:50:28', '2021-09-01 17:51:38', 15.00, 'IB44ezf45', 30);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

DROP TABLE IF EXISTS `formations`;
CREATE TABLE IF NOT EXISTS `formations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `critere_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `formations_critere_id_foreign` (`critere_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id`, `name`, `description`, `created_at`, `updated_at`, `critere_id`) VALUES
(26, 'GI', 'Descritiptin de la fomariomturin dGenie informatique.', '2021-08-29 20:10:10', '2021-08-29 20:10:10', 9);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_08_18_114053_create_etudiant_table', 1),
(5, '2021_08_18_131031_create_formation_table', 1),
(6, '2021_08_18_131707_create_module_table', 1),
(29, '2021_08_21_175003_create_semestres_table', 5),
(8, '2021_08_22_215136_create_promotions_table', 1),
(9, '2021_08_26_172304_create_etudiant_module_table', 1),
(10, '2021_08_26_192737_edit_etudiant_module', 1),
(11, '2021_08_26_200253_create_promotion_semestre_tabe', 1),
(13, '2021_08_26_214621_create_promotion_semestre_table', 2),
(22, '2021_08_26_230829_create_devoirs_table', 3),
(23, '2021_08_27_151315_create_evaluations_table', 3),
(27, '2021_08_29_165417_update_devoirs_table', 4),
(28, '2021_08_29_182703_update_formations_table', 4),
(30, '2021_09_01_194144_create_tranches_table', 6),
(35, '2021_09_02_114356_create_paiements_table', 7),
(36, '2021_09_04_081834_create_professeurs_table', 7);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `index` int(11) DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `professeur_id` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modules_professeur_id_foreign` (`professeur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `name`, `index`, `description`, `created_at`, `updated_at`, `professeur_id`) VALUES
(21, 'Module5', 0, 'Desc', '2021-08-29 19:26:55', '2021-08-29 19:26:55', NULL),
(20, 'Module4', 0, 'Module', '2021-08-29 19:18:25', '2021-08-29 19:18:25', NULL),
(19, 'Module3', 0, 'Module', '2021-08-29 19:17:18', '2021-08-29 19:17:18', NULL),
(18, 'Module2', 0, 'Module', '2021-08-29 19:16:52', '2021-08-29 19:16:52', NULL),
(17, 'Module1', 0, 'Module', '2021-08-29 19:15:45', '2021-08-29 19:15:45', NULL),
(22, 'Module', 0, 'desc', '2021-08-29 19:27:35', '2021-08-29 19:27:35', NULL),
(23, 'Module7', 0, 'desc', '2021-08-29 19:27:57', '2021-08-29 19:27:57', NULL),
(24, 'Module88', 0, 'Le M88', '2021-09-05 17:38:04', '2021-09-05 17:38:04', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `module_semestre`
--

DROP TABLE IF EXISTS `module_semestre`;
CREATE TABLE IF NOT EXISTS `module_semestre` (
  `semestre_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  KEY `module_semestre_semestre_id_foreign` (`semestre_id`),
  KEY `module_semestre_module_id_foreign` (`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `module_semestre`
--

INSERT INTO `module_semestre` (`semestre_id`, `module_id`) VALUES
(112, 21),
(112, 20),
(112, 19),
(113, 18),
(113, 17),
(113, 22),
(114, 17),
(114, 22),
(114, 23),
(115, 20),
(115, 19),
(115, 18),
(115, 17),
(115, 22),
(115, 23),
(116, 21),
(116, 20),
(117, 19),
(118, 20),
(119, 21),
(120, 21),
(120, 20),
(121, 20),
(121, 19),
(122, 18),
(122, 17),
(123, 19),
(123, 18),
(123, 17),
(123, 22),
(123, 23),
(124, 21),
(124, 20),
(124, 19),
(125, 18),
(125, 17),
(125, 22),
(126, 18),
(126, 17),
(126, 23),
(127, 20),
(127, 19),
(127, 18),
(128, 21),
(128, 20),
(129, 21),
(129, 20),
(129, 19),
(129, 18),
(130, 17),
(130, 22),
(130, 23),
(131, 21),
(131, 20),
(131, 19),
(131, 18),
(132, 21),
(132, 20),
(133, 19),
(133, 18),
(133, 17),
(134, 19),
(134, 22),
(134, 23),
(135, 19),
(135, 18),
(135, 17),
(135, 22),
(135, 23),
(136, 21),
(136, 20),
(136, 19),
(137, 19),
(137, 18),
(137, 17),
(138, 17),
(138, 22),
(138, 23),
(139, 21),
(139, 20),
(139, 19),
(139, 18),
(139, 17),
(139, 22);

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
CREATE TABLE IF NOT EXISTS `paiements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant` double(8,2) NOT NULL,
  `professeur_id` bigint(20) UNSIGNED NOT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `date_payement` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id`, `montant`, `professeur_id`, `formation_id`, `date_payement`, `created_at`, `updated_at`) VALUES
(1, 3000.00, 1, 26, '2021-09-04', '2021-09-04 16:51:49', '2021-09-04 16:51:49'),
(2, 5600.00, 1, 26, '2021-09-05', '2021-09-04 22:22:20', '2021-09-04 22:22:20'),
(3, 1800.00, 1, 26, '2020-10-10', '2021-09-05 10:35:15', '2021-09-05 10:35:15'),
(4, 150.00, 1, 26, '2020-10-10', '2021-09-05 10:38:32', '2021-09-05 10:38:32');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeurs`
--

DROP TABLE IF EXISTS `professeurs`;
CREATE TABLE IF NOT EXISTS `professeurs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `somme` double(8,2) NOT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professeurs`
--

INSERT INTO `professeurs` (`id`, `created_at`, `updated_at`, `name`, `somme`, `formation_id`, `module_id`) VALUES
(1, '2021-09-04 16:46:52', '2021-09-04 16:46:52', 'Said Leprofesseur', 7120.00, 26, 20);

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `promotions_formation_id_foreign` (`formation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`id`, `nom`, `numero`, `created_at`, `updated_at`, `formation_id`) VALUES
(95, '2ème Année', 2, '2021-08-29 20:10:10', '2021-08-29 20:10:10', 26),
(94, '1ére Année', 1, '2021-08-29 20:10:10', '2021-08-29 20:10:10', 26);

-- --------------------------------------------------------

--
-- Structure de la table `semestres`
--

DROP TABLE IF EXISTS `semestres`;
CREATE TABLE IF NOT EXISTS `semestres` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `semestres_formation_id_foreign` (`formation_id`),
  KEY `semestres_promotion_id_foreign` (`promotion_id`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `semestres`
--

INSERT INTO `semestres` (`id`, `numero`, `created_at`, `updated_at`, `formation_id`, `promotion_id`) VALUES
(136, 1, '2021-08-29 20:10:10', '2021-08-29 20:10:10', 26, 94),
(137, 2, '2021-08-29 20:10:10', '2021-08-29 20:10:10', 26, 94),
(138, 3, '2021-08-29 20:10:10', '2021-08-29 20:10:10', 26, 95),
(139, 4, '2021-08-29 20:10:10', '2021-08-29 20:10:10', 26, 95);

-- --------------------------------------------------------

--
-- Structure de la table `tranches`
--

DROP TABLE IF EXISTS `tranches`;
CREATE TABLE IF NOT EXISTS `tranches` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vers` double(8,2) NOT NULL,
  `date_vers` date NOT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etudiant_cin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tranches_etudiant_cin_foreign` (`etudiant_cin`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tranches`
--

INSERT INTO `tranches` (`id`, `vers`, `date_vers`, `ref`, `etudiant_cin`, `proved`, `created_at`, `updated_at`) VALUES
(74, 16000.00, '2020-10-09', 'ANBC5Z78FA945F640', 'D12', 1, '2021-09-05 11:39:58', '2021-09-05 11:39:58'),
(72, 1000.00, '2021-02-03', 'SNXBYUEFJZEYFOE', 'A11', 1, '2021-09-05 11:39:58', '2021-09-05 11:39:58'),
(73, 1200.00, '2020-10-15', 'SLDJUEHFAUHFB', 'IB44ezf45', 1, '2021-09-05 11:39:58', '2021-09-05 11:39:58'),
(71, 1500.00, '2020-10-10', 'ASDEKXHCYEKrien', 'A11', 0, '2021-09-05 11:39:58', '2021-09-05 11:39:58');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `cin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cin`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`cin`, `first_name`, `last_name`, `phone`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('IB1004', 'Hamza', 'Mahfoud', NULL, 'hamza@gmail.com', NULL, '$2y$10$xF9UUBsBWFY2/fygACJTEeUtJ6BSyeOLThDdYpi62g3jYb75V0wqK', NULL, '2021-08-26 19:23:06', '2021-08-26 19:23:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
