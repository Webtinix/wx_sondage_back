-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 13 juin 2024 à 14:42
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wx_sondage`
--

-- --------------------------------------------------------

--
-- Structure de la table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tech_name` varchar(255) NOT NULL,
  `lib` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `attr` text DEFAULT NULL,
  `attr_label` text DEFAULT NULL,
  `render_in` text DEFAULT NULL,
  `module_in` text DEFAULT NULL,
  `render_out` text DEFAULT NULL,
  `module_out` text DEFAULT NULL,
  `is_lang` tinyint(1) NOT NULL DEFAULT 0,
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `list_visible` tinyint(1) NOT NULL DEFAULT 1,
  `required` tinyint(1) NOT NULL DEFAULT 1,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  `is_dynamic_class_src` tinyint(1) NOT NULL DEFAULT 0,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `groupe_attribute_id` bigint(20) UNSIGNED NOT NULL,
  `classe_src_id` bigint(20) UNSIGNED DEFAULT NULL,
  `component_id` bigint(20) UNSIGNED NOT NULL,
  `component_id_multi` bigint(20) UNSIGNED NOT NULL,
  `component_id_unique` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `attributes`
--

INSERT INTO `attributes` (`id`, `tech_name`, `lib`, `position`, `attr`, `attr_label`, `render_in`, `module_in`, `render_out`, `module_out`, `is_lang`, `actif`, `visible`, `list_visible`, `required`, `disabled`, `is_dynamic_class_src`, `classe_id`, `groupe_attribute_id`, `classe_src_id`, `component_id`, `component_id_multi`, `component_id_unique`, `created_at`, `updated_at`) VALUES
(340, 'attribute_optionliste_des_options_par_defaut_du_sondage', 'Description du genre', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 0, 0, 0, 142, 185, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(341, 'nominscription_1', 'Nom(s)', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 139, 186, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(342, 'nominscription_2', 'Nom(s)', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(343, 'nominscription_3', 'Nom(s)', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(344, 'prenominscription_1', 'Prénom(s)', 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 139, 186, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(345, 'prenominscription_2', 'Prénom(s)', 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(346, 'prenominscription_3', 'Prénom(s)', 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(347, 'genreinscription_1', 'Genre', 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 139, 186, 142, 5, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(348, 'genreinscription_2', 'Genre', 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, 142, 5, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(349, 'genreinscription_3', 'Genre', 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, 142, 5, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(350, 'telephoneinscription_1', 'Téléphone', 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 139, 186, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(351, 'telephoneinscription_2', 'Téléphone', 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(352, 'telephoneinscription_3', 'Téléphone', 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(353, 'emailinscription_1', 'Email', 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 139, 186, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(354, 'emailinscription_2', 'Email', 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 4, 1, 3, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(355, 'emailinscription_3', 'Email', 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(356, 'date_de_naissanceinscription_2', 'Date de naissance', 6, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 7, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(357, 'date_de_naissanceinscription_3', 'Date de naissance', 6, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 7, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(358, 'lieu_de_naissanceinscription_2', 'Lieu de naissance', 7, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(359, 'lieu_de_naissanceinscription_3', 'Lieu de naissance', 7, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(360, 'villeinscription_2', 'Ville', 8, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(361, 'villeinscription_3', 'Ville', 8, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(362, 'arrondissementinscription_2', 'Arrondissement', 9, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(363, 'arrondissementinscription_3', 'Arrondissement', 9, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(364, 'quartierinscription_2', 'Quartier', 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(365, 'quartierinscription_3', 'Quartier', 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(366, 'cvinscription_2', 'CV', 11, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 140, 187, NULL, 15, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(367, 'cvinscription_3', 'CV', 11, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 15, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(368, 'professioninscription_1', 'Profession', 6, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 139, 186, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(369, 'n_porteur_projetinscription_3', 'Noms du porteur de projet', 12, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(370, 'p_porteur_projetinscription_3', 'Prenoms du porteur de projet', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(371, 'titre_du_projetinscription_3', 'Titre du Projet de soutenance', 14, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(372, 'niveauinscription_3', 'Niveau', 15, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(373, 'secteur_inscription_3', 'Secteur', 16, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 4, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(374, 'themeinscription_3', 'Thème', 17, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 13, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45'),
(375, 'description_projetinscription_3', 'Description du Projet de soutenance', 18, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 0, 141, 188, NULL, 13, 1, 3, '2024-05-23 12:04:45', '2024-05-23 12:04:45');

-- --------------------------------------------------------

--
-- Structure de la table `attribute_langs`
--

CREATE TABLE `attribute_langs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lib` varchar(255) NOT NULL,
  `lang_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tech_name` varchar(255) NOT NULL,
  `lib` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `component_multi_id` bigint(20) UNSIGNED NOT NULL,
  `component_unique_id` bigint(20) UNSIGNED NOT NULL,
  `class_parent_id` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `tech_name`, `lib`, `company_id`, `component_multi_id`, `component_unique_id`, `class_parent_id`, `created_at`, `updated_at`) VALUES
(139, 'inscription_formulaire_de_participation', 'Formulaire de participation', 2, 14, 3, '0', '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(140, 'formulaire_d_inscription_au_72h_chrono_emploi_ou_stage', 'Formulaire d’inscription au 72h chrono Emploi ou stage', 2, 14, 3, '0', '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(141, 'formulaire_d_inscription_au_challenge_projet_de_soutenance', 'Formulaire d’inscription au Challenge Projet de soutenance', 2, 14, 3, '0', '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(142, 'liste_des_options_par_defaut_du_sondage', 'liste_des_options_par_defaut', 2, 14, 3, '0', '2024-05-23 12:04:44', '2024-05-23 12:04:44');

-- --------------------------------------------------------

--
-- Structure de la table `class_langs`
--

CREATE TABLE `class_langs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lib` varchar(255) NOT NULL,
  `lang_id` bigint(20) UNSIGNED NOT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` char(36) NOT NULL,
  `lib` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`id`, `uid`, `lib`, `created_at`, `updated_at`) VALUES
(2, 'wx-cbc4bc09-7e17-4a13-a222-1509533b3', 'Webtinix', '2024-05-22 14:00:38', '2024-05-22 14:00:38');

-- --------------------------------------------------------

--
-- Structure de la table `components`
--

CREATE TABLE `components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lib` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `components`
--

INSERT INTO `components` (`id`, `lib`, `created_at`, `updated_at`) VALUES
(1, 'com.webtinix.infusio.server.DataTable', NULL, NULL),
(2, 'com.webtinix.infusio.server.Formation.DataTable', NULL, NULL),
(3, 'com.webtinix.infusio.server.Form', NULL, NULL),
(4, 'com.webtinix.infusio.server.InputText', NULL, NULL),
(5, 'com.webtinix.infusio.server.InputSelect', NULL, NULL),
(6, 'com.webtinix.infusio.server.SubmitButton', NULL, NULL),
(7, 'com.webtinix.infusio.server.InputDate', NULL, NULL),
(8, 'com.webtinix.infusio.GroupeAttributes', NULL, NULL),
(9, 'com.webtinix.infusio.InputHidden', NULL, NULL),
(10, 'com.webtinix.infusio.InputNumber', NULL, NULL),
(11, 'com.webtinix.infusio.server.RadioButton', NULL, NULL),
(12, 'com.webtinix.infusio.server.CheckBox', NULL, NULL),
(13, 'com.webtinix.infusio.server.TextArea', NULL, NULL),
(14, 'com.webtinix.infusio.server.SondageResult', NULL, NULL),
(15, 'com.webtinix.infusio.server.InputFile', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `datas`
--

CREATE TABLE `datas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` text NOT NULL,
  `instance_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `classe_id_src` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `datas`
--

INSERT INTO `datas` (`id`, `value`, `instance_id`, `class_id`, `classe_id_src`, `attribute_id`, `created_at`, `updated_at`) VALUES
(1578, 'M', 409, 142, NULL, 340, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(1579, 'F', 410, 142, NULL, 340, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(1580, 'Lié', 411, 139, NULL, 341, '2024-05-24 17:14:43', '2024-05-24 17:14:43'),
(1581, 'Orphée', 411, 139, NULL, 344, '2024-05-24 17:14:43', '2024-05-24 17:14:43'),
(1582, '409', 411, 139, NULL, 347, '2024-05-24 17:14:43', '2024-05-24 17:14:43'),
(1583, '0625478569', 411, 139, NULL, 350, '2024-05-24 17:14:43', '2024-05-24 17:14:43'),
(1584, 'lieloumloum@gmail.com', 411, 139, NULL, 353, '2024-05-24 17:14:43', '2024-05-24 17:14:43'),
(1585, 'Développeur', 411, 139, NULL, 368, '2024-05-24 17:14:43', '2024-05-24 17:14:43'),
(1586, 'Lié', 412, 139, NULL, 341, '2024-05-24 17:26:45', '2024-05-24 17:26:45'),
(1587, 'Orphée', 412, 139, NULL, 344, '2024-05-24 17:26:45', '2024-05-24 17:26:45'),
(1588, '409', 412, 139, NULL, 347, '2024-05-24 17:26:45', '2024-05-24 17:26:45'),
(1589, '0625478569', 412, 139, NULL, 350, '2024-05-24 17:26:45', '2024-05-24 17:26:45'),
(1590, 'lieloumloum@gmail.com', 412, 139, NULL, 353, '2024-05-24 17:26:45', '2024-05-24 17:26:45'),
(1591, 'Développeur', 412, 139, NULL, 368, '2024-05-24 17:26:45', '2024-05-24 17:26:45'),
(1592, 'Lié', 413, 140, NULL, 342, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1593, 'Orphée', 413, 140, NULL, 345, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1594, '409', 413, 140, NULL, 348, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1595, '0625478569', 413, 140, NULL, 351, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1596, 'lieloumloum@gmail.com', 413, 140, NULL, 354, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1597, '2004-12-24', 413, 140, NULL, 356, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1598, 'Congo', 413, 140, NULL, 358, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1599, 'Mortville', 413, 140, NULL, 360, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1600, '7', 413, 140, NULL, 362, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1601, '77', 413, 140, NULL, 364, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1602, 'Aucune réponse', 413, 140, NULL, 366, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(1603, 'Lié', 414, 141, NULL, 343, '2024-05-24 19:42:55', '2024-05-24 19:42:55'),
(1604, 'Orphée', 414, 141, NULL, 346, '2024-05-24 19:42:55', '2024-05-24 19:42:55'),
(1605, '409', 414, 141, NULL, 349, '2024-05-24 19:42:55', '2024-05-24 19:42:55'),
(1606, '0625478569', 414, 141, NULL, 352, '2024-05-24 19:42:55', '2024-05-24 19:42:55'),
(1607, 'lieloumloum@gmail.com', 414, 141, NULL, 355, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1608, '2024-05-17', 414, 141, NULL, 357, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1609, 'Brazza-ville', 414, 141, NULL, 359, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1610, 'Mortville', 414, 141, NULL, 361, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1611, '22', 414, 141, NULL, 363, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1612, '77', 414, 141, NULL, 365, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1613, 'Aucune réponse', 414, 141, NULL, 367, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1614, 'Webtinix', 414, 141, NULL, 369, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1615, 'Webtinix SA', 414, 141, NULL, 370, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1616, 'WX Sondage', 414, 141, NULL, 371, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1617, 'P1', 414, 141, NULL, 372, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1618, 'Tech', 414, 141, NULL, 373, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1619, 'vas te faire foutre', 414, 141, NULL, 374, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1620, 'Vas encore te faire foutre', 414, 141, NULL, 375, '2024-05-24 19:42:56', '2024-05-24 19:42:56'),
(1621, 'Lié', 415, 141, NULL, 343, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1622, 'Orphée', 415, 141, NULL, 346, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1623, '409', 415, 141, NULL, 349, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1624, '0625478569', 415, 141, NULL, 352, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1625, 'lieloumloum@gmail.com', 415, 141, NULL, 355, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1626, '2024-06-06', 415, 141, NULL, 357, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1627, 'Brazza-ville', 415, 141, NULL, 359, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1628, 'Mortville', 415, 141, NULL, 361, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1629, '22', 415, 141, NULL, 363, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(1630, '77', 415, 141, NULL, 365, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1631, 'erreur', 415, 141, NULL, 367, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1632, 'Webtinix', 415, 141, NULL, 369, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1633, 'Webtinix SA', 415, 141, NULL, 370, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1634, 'WX Sondage', 415, 141, NULL, 371, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1635, 'P1', 415, 141, NULL, 372, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1636, 'Tech', 415, 141, NULL, 373, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1637, 'Finally, you may call the .use method multiple times to assign multiple middleware. For example:', 415, 141, NULL, 374, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1638, 'Finally, you may call the .use method multiple times to assign multiple middleware. For example:', 415, 141, NULL, 375, '2024-06-06 06:44:39', '2024-06-06 06:44:39'),
(1639, 'Lié', 416, 141, NULL, 343, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1640, 'Orphée', 416, 141, NULL, 346, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1641, '410', 416, 141, NULL, 349, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1642, '0625478569', 416, 141, NULL, 352, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1643, 'lieloumloum@gmail.com', 416, 141, NULL, 355, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1644, '2024-06-21', 416, 141, NULL, 357, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1645, 'Brazza-ville', 416, 141, NULL, 359, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1646, 'Mortville', 416, 141, NULL, 361, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1647, '22', 416, 141, NULL, 363, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1648, '77', 416, 141, NULL, 365, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1649, 'erreur', 416, 141, NULL, 367, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(1650, 'Webtinix', 416, 141, NULL, 369, '2024-06-06 06:50:00', '2024-06-06 06:50:00'),
(1651, 'Webtinix SA', 416, 141, NULL, 370, '2024-06-06 06:50:00', '2024-06-06 06:50:00'),
(1652, 'WX Sondage', 416, 141, NULL, 371, '2024-06-06 06:50:00', '2024-06-06 06:50:00'),
(1653, 'P1', 416, 141, NULL, 372, '2024-06-06 06:50:00', '2024-06-06 06:50:00'),
(1654, 'Tech', 416, 141, NULL, 373, '2024-06-06 06:50:00', '2024-06-06 06:50:00'),
(1655, 'Finally, you may call the .use method multiple times to assign multiple middleware. For example:', 416, 141, NULL, 374, '2024-06-06 06:50:00', '2024-06-06 06:50:00'),
(1656, 'Finally, you may call the .use method multiple times to assign multiple middleware. For example:', 416, 141, NULL, 375, '2024-06-06 06:50:00', '2024-06-06 06:50:00'),
(1657, 'Nom', 417, 141, NULL, 343, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1658, 'Prénom', 417, 141, NULL, 346, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1659, '410', 417, 141, NULL, 349, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1660, '0625478569', 417, 141, NULL, 352, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1661, 'lieloumloum@gmail.com', 417, 141, NULL, 355, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1662, '2024-06-29', 417, 141, NULL, 357, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1663, 'Brazza-ville', 417, 141, NULL, 359, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1664, 'COURBEVOIE', 417, 141, NULL, 361, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1665, '22', 417, 141, NULL, 363, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1666, '77', 417, 141, NULL, 365, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1667, 'Condition GÃ©nerale-1717663968436.pdf', 417, 141, NULL, 367, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1668, 'Webtinix', 417, 141, NULL, 369, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1669, 'Webtinix SA', 417, 141, NULL, 370, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1670, 'WX Sondage', 417, 141, NULL, 371, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1671, 'P1', 417, 141, NULL, 372, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1672, 'Tech', 417, 141, NULL, 373, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1673, 'Finally, you may call the .use method multiple times to assign multiple middleware. For example:', 417, 141, NULL, 374, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1674, 'Finally, you may call the .use method multiple times to assign multiple middleware. For example:', 417, 141, NULL, 375, '2024-06-06 06:53:09', '2024-06-06 06:53:09'),
(1675, 'Lié', 418, 140, NULL, 342, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1676, 'Orphée', 418, 140, NULL, 345, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1677, '409', 418, 140, NULL, 348, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1678, '0625478569', 418, 140, NULL, 351, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1679, 'lieloumloum@gmail.com', 418, 140, NULL, 354, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1680, '2024-06-13', 418, 140, NULL, 356, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1681, 'Congo', 418, 140, NULL, 358, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1682, 'Mortville', 418, 140, NULL, 360, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1683, '7', 418, 140, NULL, 362, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1684, '77', 418, 140, NULL, 364, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1685, 'Devis Extention du rÃ©seau caisse DGTT-1718207354719.pdf', 418, 140, NULL, 366, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(1686, 'Nom', 419, 140, NULL, 342, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1687, 'Prénom', 419, 140, NULL, 345, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1688, '409', 419, 140, NULL, 348, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1689, '0625478569', 419, 140, NULL, 351, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1690, 'lieloumloum@gmail.com', 419, 140, NULL, 354, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1691, '2024-06-13', 419, 140, NULL, 356, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1692, 'Congo', 419, 140, NULL, 358, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1693, 'COURBEVOIE', 419, 140, NULL, 360, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1694, '7', 419, 140, NULL, 362, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1695, '77', 419, 140, NULL, 364, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1696, 'Annotation 2024-05-25 021331-1718207509092.png', 419, 140, NULL, 366, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(1697, 'Nom_12', 420, 140, NULL, 342, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1698, 'Prénom_23', 420, 140, NULL, 345, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1699, '409', 420, 140, NULL, 348, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1700, '0625478569', 420, 140, NULL, 351, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1701, 'lieloumloum@gmail.com', 420, 140, NULL, 354, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1702, '2024-06-28', 420, 140, NULL, 356, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1703, 'Congo', 420, 140, NULL, 358, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1704, 'COURBEVOIE', 420, 140, NULL, 360, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1705, '7', 420, 140, NULL, 362, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1706, '77', 420, 140, NULL, 364, '2024-06-12 13:57:41', '2024-06-12 13:57:41'),
(1707, 'WX Government 001-1718207858423.png', 420, 140, NULL, 366, '2024-06-12 13:57:41', '2024-06-12 13:57:41');

-- --------------------------------------------------------

--
-- Structure de la table `data_langs`
--

CREATE TABLE `data_langs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lang_id` bigint(20) UNSIGNED NOT NULL,
  `data_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `groupe_attributes`
--

CREATE TABLE `groupe_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `attr` text DEFAULT NULL,
  `lib` varchar(255) DEFAULT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `component_id_multi` bigint(20) UNSIGNED DEFAULT NULL,
  `component_id_unique` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `groupe_attributes`
--

INSERT INTO `groupe_attributes` (`id`, `position`, `attr`, `lib`, `classe_id`, `component_id_multi`, `component_id_unique`, `created_at`, `updated_at`) VALUES
(185, 1, '{\"className\":\"grid gap-4\"}', NULL, 142, 8, 8, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(186, 1, '{\"className\":\"grid gap-4\"}', NULL, 139, 8, 8, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(187, 1, '{\"className\":\"grid gap-4\"}', NULL, 140, 8, 8, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(188, 1, '{\"className\":\"grid gap-4\"}', NULL, 141, 8, 8, '2024-05-23 12:04:44', '2024-05-23 12:04:44');

-- --------------------------------------------------------

--
-- Structure de la table `instances`
--

CREATE TABLE `instances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instances`
--

INSERT INTO `instances` (`id`, `classe_id`, `parent_id`, `created_at`, `updated_at`) VALUES
(409, 142, NULL, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(410, 142, NULL, '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(411, 139, NULL, '2024-05-24 17:14:43', '2024-05-24 17:14:43'),
(412, 139, NULL, '2024-05-24 17:26:45', '2024-05-24 17:26:45'),
(413, 140, NULL, '2024-05-24 19:34:32', '2024-05-24 19:34:32'),
(414, 141, NULL, '2024-05-24 19:42:55', '2024-05-24 19:42:55'),
(415, 141, NULL, '2024-06-06 06:44:38', '2024-06-06 06:44:38'),
(416, 141, NULL, '2024-06-06 06:49:59', '2024-06-06 06:49:59'),
(417, 141, NULL, '2024-06-06 06:53:08', '2024-06-06 06:53:08'),
(418, 140, NULL, '2024-06-12 13:49:19', '2024-06-12 13:49:19'),
(419, 140, NULL, '2024-06-12 13:51:56', '2024-06-12 13:51:56'),
(420, 140, NULL, '2024-06-12 13:57:41', '2024-06-12 13:57:41');

-- --------------------------------------------------------

--
-- Structure de la table `langs`
--

CREATE TABLE `langs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lib` varchar(255) NOT NULL,
  `iso` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `langs`
--

INSERT INTO `langs` (`id`, `lib`, `iso`, `created_at`, `updated_at`) VALUES
(2, 'Français', 'fr', '2024-05-22 14:04:29', '2024-05-22 14:04:29');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `fonction` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `telephone`, `role`, `prenom`, `status`, `fonction`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(11, 'SEOPC-Admin', '+242068078734', 'Administrateur', 'SEOPC', 'Actif', 'Administrateur', 'contact@seopc.cg', NULL, '$2y$10$oP5F.b47LSFZDdMZQQ0GA.cFuqWSYyybftROKJ8qScOttrdJvAw2m', NULL, '2024-06-13 09:03:40', '2024-06-13 09:03:40');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attributes_tech_name_unique` (`tech_name`),
  ADD KEY `attributes_classe_id_foreign` (`classe_id`),
  ADD KEY `attributes_groupe_attribute_id_foreign` (`groupe_attribute_id`),
  ADD KEY `attributes_classe_src_id_foreign` (`classe_src_id`),
  ADD KEY `attributes_component_id_foreign` (`component_id`),
  ADD KEY `attributes_component_id_multi_foreign` (`component_id_multi`),
  ADD KEY `attributes_component_id_unique_foreign` (`component_id_unique`);

--
-- Index pour la table `attribute_langs`
--
ALTER TABLE `attribute_langs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_langs_lang_id_foreign` (`lang_id`),
  ADD KEY `attribute_langs_attribute_id_foreign` (`attribute_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classes_tech_name_unique` (`tech_name`),
  ADD KEY `classes_company_id_foreign` (`company_id`),
  ADD KEY `classes_component_multi_id_foreign` (`component_multi_id`),
  ADD KEY `classes_component_unique_id_foreign` (`component_unique_id`);

--
-- Index pour la table `class_langs`
--
ALTER TABLE `class_langs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_langs_lang_id_foreign` (`lang_id`),
  ADD KEY `class_langs_classe_id_foreign` (`classe_id`);

--
-- Index pour la table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_uid_unique` (`uid`);

--
-- Index pour la table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `datas`
--
ALTER TABLE `datas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datas_instance_id_foreign` (`instance_id`),
  ADD KEY `datas_class_id_foreign` (`class_id`),
  ADD KEY `datas_classe_id_src_foreign` (`classe_id_src`),
  ADD KEY `datas_attribute_id_foreign` (`attribute_id`);

--
-- Index pour la table `data_langs`
--
ALTER TABLE `data_langs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_langs_lang_id_foreign` (`lang_id`),
  ADD KEY `data_langs_data_id_foreign` (`data_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `groupe_attributes`
--
ALTER TABLE `groupe_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupe_attributes_classe_id_foreign` (`classe_id`),
  ADD KEY `groupe_attributes_component_id_multi_foreign` (`component_id_multi`),
  ADD KEY `groupe_attributes_component_id_unique_foreign` (`component_id_unique`);

--
-- Index pour la table `instances`
--
ALTER TABLE `instances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instances_classe_id_foreign` (`classe_id`),
  ADD KEY `instances_parent_id_foreign` (`parent_id`);

--
-- Index pour la table `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `langs_iso_unique` (`iso`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_telephone_unique` (`telephone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT pour la table `attribute_langs`
--
ALTER TABLE `attribute_langs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT pour la table `class_langs`
--
ALTER TABLE `class_langs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `components`
--
ALTER TABLE `components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `datas`
--
ALTER TABLE `datas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1708;

--
-- AUTO_INCREMENT pour la table `data_langs`
--
ALTER TABLE `data_langs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `groupe_attributes`
--
ALTER TABLE `groupe_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT pour la table `instances`
--
ALTER TABLE `instances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- AUTO_INCREMENT pour la table `langs`
--
ALTER TABLE `langs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `attributes_classe_src_id_foreign` FOREIGN KEY (`classe_src_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `attributes_component_id_foreign` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `attributes_component_id_multi_foreign` FOREIGN KEY (`component_id_multi`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `attributes_component_id_unique_foreign` FOREIGN KEY (`component_id_unique`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `attributes_groupe_attribute_id_foreign` FOREIGN KEY (`groupe_attribute_id`) REFERENCES `groupe_attributes` (`id`);

--
-- Contraintes pour la table `attribute_langs`
--
ALTER TABLE `attribute_langs`
  ADD CONSTRAINT `attribute_langs_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`),
  ADD CONSTRAINT `attribute_langs_lang_id_foreign` FOREIGN KEY (`lang_id`) REFERENCES `langs` (`id`);

--
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `classes_component_multi_id_foreign` FOREIGN KEY (`component_multi_id`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `classes_component_unique_id_foreign` FOREIGN KEY (`component_unique_id`) REFERENCES `components` (`id`);

--
-- Contraintes pour la table `class_langs`
--
ALTER TABLE `class_langs`
  ADD CONSTRAINT `class_langs_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `class_langs_lang_id_foreign` FOREIGN KEY (`lang_id`) REFERENCES `langs` (`id`);

--
-- Contraintes pour la table `datas`
--
ALTER TABLE `datas`
  ADD CONSTRAINT `datas_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`),
  ADD CONSTRAINT `datas_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `datas_classe_id_src_foreign` FOREIGN KEY (`classe_id_src`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `datas_instance_id_foreign` FOREIGN KEY (`instance_id`) REFERENCES `instances` (`id`);

--
-- Contraintes pour la table `data_langs`
--
ALTER TABLE `data_langs`
  ADD CONSTRAINT `data_langs_data_id_foreign` FOREIGN KEY (`data_id`) REFERENCES `datas` (`id`),
  ADD CONSTRAINT `data_langs_lang_id_foreign` FOREIGN KEY (`lang_id`) REFERENCES `langs` (`id`);

--
-- Contraintes pour la table `groupe_attributes`
--
ALTER TABLE `groupe_attributes`
  ADD CONSTRAINT `groupe_attributes_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `groupe_attributes_component_id_multi_foreign` FOREIGN KEY (`component_id_multi`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `groupe_attributes_component_id_unique_foreign` FOREIGN KEY (`component_id_unique`) REFERENCES `components` (`id`);

--
-- Contraintes pour la table `instances`
--
ALTER TABLE `instances`
  ADD CONSTRAINT `instances_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `instances_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `instances` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
