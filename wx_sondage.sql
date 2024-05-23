-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 23 mai 2024 à 23:23
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
(139, 'inscription_1', 'Formulaire de participation', 2, 14, 3, '0', '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(140, 'inscription_2', 'Formulaire d’inscription au 72h chrono Emploi ou stage', 2, 14, 3, '0', '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
(141, 'inscription_3', 'Formulaire d’inscription au Challenge Projet de soutenance', 2, 14, 3, '0', '2024-05-23 12:04:44', '2024-05-23 12:04:44'),
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
(1579, 'F', 410, 142, NULL, 340, '2024-05-23 12:04:44', '2024-05-23 12:04:44');

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
(410, 142, NULL, '2024-05-23 12:04:44', '2024-05-23 12:04:44');

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
(1, 'Dupont', 'jean.dupont@example.com', 'formateur', 'Jean', 'actif', 'manager', 'jean.dupont@example.com', NULL, '$2y$10$fodYkjdB4L8d/9XnE6k2BuF1XopdbHZdUuE2BaDK/IKAQb38RJIdO', NULL, '2024-03-25 09:15:23', '2024-03-25 09:15:23'),
(2, 'MiX', 'contact@gmail.com', 'formateur', 'GGix', '159', 'TTTix', 'contact@gmail.com', NULL, '45', NULL, '2024-03-26 17:24:51', '2024-04-07 21:08:36'),
(3, 'MOUANDZA HOUESSOU', 'angelhoues@gmail.com', 'admin', 'Ange D.', 'Actif', 'Manager G.', 'angelhoues@gmail.com', NULL, '$2y$10$dWQcG.f2W8z9LGEni5LDR.9hjd/YaUY.M13RPA1hmDV5MjlXFhgZa', NULL, '2024-03-27 02:23:19', '2024-03-27 02:23:19'),
(4, 'New', 'new@gmail.com', 'formateur', 'New', 'New', 'New', 'new@gmail.com', NULL, '456', NULL, '2024-04-07 21:10:30', '2024-04-07 21:30:28'),
(6, 'test', 'test@gmail.com', 'formateur', 'test', 'mmm', 'test', 'test@gmail.com', NULL, '$2y$10$c9emwVWSHJ9b6r2itTX.peaO2BAp3Xhga7a.zL.28FQbfwLyYAdR2', NULL, '2024-04-07 21:31:18', '2024-04-07 21:31:18'),
(9, 'ONKELE', '064624544', 'formateur', 'Rama', 'Actif', 'Responsable projet', 'ramaonkele@gmail.com', NULL, '$2y$10$ySBD.gkVOPwCGomCXuwouufWAm4uu8q4Ux1sA1utd81mslywD9fAy', NULL, '2024-04-12 08:10:54', '2024-04-12 08:10:54'),
(10, 'Bounda', '065735708', 'formateur', 'Camille', 'Actif', 'Formateur', 'camillebounda@gmail.com', NULL, '$2y$10$JiaUzGZeplx1BeflCA7VxOtCO3IT93yspIHgpxiWvDjuCvY27XTEm', NULL, '2024-04-12 22:23:25', '2024-04-12 22:23:25');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1580;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=411;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
