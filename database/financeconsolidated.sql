-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 25 juin 2026 à 19:02
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `financeconsolidated`
--

-- --------------------------------------------------------

--
-- Structure de la table `bailleurs`
--

CREATE TABLE `bailleurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `capital` decimal(15,2) NOT NULL,
  `montant_max_projet` decimal(15,2) NOT NULL,
  `secteurs_preferes` text NOT NULL,
  `types_bailleurs` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bailleurs`
--

INSERT INTO `bailleurs` (`id`, `id_utilisateur`, `capital`, `montant_max_projet`, `secteurs_preferes`, `types_bailleurs`, `created_at`, `updated_at`) VALUES
(1, 14, 0.00, 0.00, '', '', '2026-06-13 17:07:47', '2026-06-13 17:07:47'),
(2, 15, 0.00, 0.00, '', '', '2026-06-13 18:21:47', '2026-06-13 18:21:47');

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
-- Structure de la table `contrats`
--

CREATE TABLE `contrats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `financement_id` bigint(20) UNSIGNED NOT NULL,
  `date_signature` timestamp NULL DEFAULT NULL,
  `fichier_url` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `statut` enum('brouillon','signe','annule') NOT NULL DEFAULT 'brouillon',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `date_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `echeances`
--

CREATE TABLE `echeances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `financements_id` bigint(20) UNSIGNED NOT NULL,
  `numero_echeance` int(11) NOT NULL,
  `date_prevu` date NOT NULL,
  `montant_prevu` decimal(15,2) NOT NULL,
  `montant_capital` decimal(15,2) NOT NULL,
  `montant_interet` decimal(15,2) NOT NULL,
  `statut` enum('en_attente','paye','retarde') NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entrepreneurs`
--

CREATE TABLE `entrepreneurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `secteur_dactivite` varchar(255) NOT NULL,
  `description_profil` text NOT NULL,
  `annees_experiences` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entrepreneurs`
--

INSERT INTO `entrepreneurs` (`id`, `id_utilisateur`, `secteur_dactivite`, `description_profil`, `annees_experiences`, `created_at`, `updated_at`) VALUES
(1, 4, 'Non spécifié', 'Nouveau profil', 0, '2026-06-06 18:15:25', '2026-06-06 18:15:25'),
(2, 6, 'Non spécifié', 'Nouveau profil', 0, '2026-06-06 18:24:45', '2026-06-06 18:24:45'),
(3, 12, '', '', 0, '2026-06-10 14:37:07', '2026-06-10 14:37:07');

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
-- Structure de la table `financements`
--

CREATE TABLE `financements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `id_bailleur` bigint(20) UNSIGNED NOT NULL,
  `montant_accorde` decimal(15,2) NOT NULL,
  `duree` int(11) NOT NULL,
  `taux_interet` decimal(5,2) NOT NULL,
  `statut` enum('en_attente','approuve','rejete','rembourse') NOT NULL,
  `date_accorde` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `garanties`
--

CREATE TABLE `garanties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_financement` bigint(20) UNSIGNED NOT NULL,
  `type_garantie` varchar(255) NOT NULL,
  `valeur_estime` decimal(15,2) NOT NULL,
  `document_url` varchar(255) NOT NULL,
  `statut` enum('en_attente','valide','rejete') NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_23_154444_create_bailleurs_table', 1),
(5, '2026_05_23_154722_create_entrepreneurs_table', 1),
(6, '2026_05_23_154808_create_documents_table', 1),
(7, '2026_05_23_155238_create_notifications_table', 1),
(8, '2026_05_23_155505_create_projets_table', 1),
(9, '2026_05_23_155506_create_financements_table', 1),
(10, '2026_05_23_155604_create_garanties_table', 1),
(11, '2026_05_23_155618_create_contrats_table', 1),
(12, '2026_05_23_155645_create_echeances_table', 1),
(13, '2026_05_23_165546_create_offre_financements_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `lue` tinyint(1) NOT NULL DEFAULT 0,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offre_financements`
--

CREATE TABLE `offre_financements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `projet_id` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `id_bailleur` bigint(20) UNSIGNED NOT NULL,
  `montant_propose` decimal(15,2) NOT NULL,
  `taux_interet` decimal(5,2) NOT NULL,
  `duree_mois` int(11) NOT NULL,
  `conditions` text DEFAULT NULL,
  `secteur_cible` varchar(255) DEFAULT NULL,
  `statut` enum('en_attente','accepte','rejete') NOT NULL DEFAULT 'en_attente',
  `date_accord` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `id_entrepreneur` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `montant_demande` decimal(15,2) NOT NULL,
  `montant_collecte` decimal(15,2) NOT NULL DEFAULT 0.00,
  `categorie` varchar(255) NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `date_limite` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `statut` enum('en_attente','approuve','rejete','finance','termine') NOT NULL DEFAULT 'en_attente',
  `document_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `id_utilisateur`, `id_entrepreneur`, `titre`, `description`, `montant_demande`, `montant_collecte`, `categorie`, `localisation`, `date_limite`, `statut`, `document_url`, `created_at`, `updated_at`) VALUES
(1, 12, 3, 'gestion fonciere', 'AFGYNNFD?J?FGFFFRHHG', 500000.00, 0.00, 'Tech', 'Dakar', '2026-06-24 23:17:55', 'en_attente', NULL, '2026-06-24 23:17:55', '2026-06-24 23:17:55');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DBX4jHVLbvxHORDIDbNO327F0PZTzqAzRl2kCyy9', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibU15c3k4M0tEcTBoUTJaTVNucHRUZHhSekljc2thREUxYnBUMXJEZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbnRyZXByZW5ldXIvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEyO30=', 1782343075),
('ipXh62S0znjJdmBfoLbykxAH9p0706CleyDaEwix', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.124.2 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkY0NnZHdXE4WGNWTmJGTmJ1VVA5alcyMHIxZUZKNDdTMWY2ZGU4RiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1782338872),
('P5dIuWhQICg9sQTM1Vk2zaFW8eV2glVdmKg0aUew', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib1d5MUM2RTltSWRVUHcxOW9xRGF6bHltZmF6RWlQaXpCb3dWMnE4NiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbnRyZXByZW5ldXIvcHJvZmlsL21vZGlmaWVyIjtzOjU6InJvdXRlIjtzOjI0OiJlbnRyZXByZW5ldXIucHJvZmlsLmVkaXQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjt9', 1781828854);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `role` enum('admin','bailleur','entrepreneur') NOT NULL,
  `statut` enum('actif','inactif') NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `prenom`, `nom`, `email`, `mot_de_passe`, `telephone`, `role`, `statut`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `avatar`) VALUES
(1, 'Bineta', 'Ndoye', 'bineta@gmail.com', '$2y$12$6FsHAgAgFyByPZgF6xanqOn5ccNjxZp0Vc5K./xaWAexCr1cxta3u', '771234567', 'admin', 'actif', '2026-06-06 18:05:25', '', '2026-06-06 18:05:25', '2026-06-06 18:05:25', 'default.png'),
(2, 'Sanou', 'Ndoye', 'sanou@gmail.com', '$2y$12$7To8MYke9XzEVtRypeLFzOO2B7pLx/.Yr5f/bRfzog6rTyfVuu3h.', '771234567', 'bailleur', 'actif', '2026-06-06 18:05:26', '', '2026-06-06 18:05:26', '2026-06-06 18:05:26', 'default.png'),
(3, 'Ndeye', 'Ndiaye', 'ndeye@gmail.com', '$2y$12$GJgkX458cO9uTNIx6uoQ5O3NfeV8u2AA8CmozcFqBvoQHo7nDuFom', '771234567', 'entrepreneur', 'actif', '2026-06-06 18:05:26', '', '2026-06-06 18:05:26', '2026-06-06 18:05:26', 'default.png'),
(4, 'Aminata', 'Ndiaye', 'aminatandiaye@gmail.com', '$2y$12$gyVN8nyQ24cDYDi0NqSn3.AO0WVvwO6rnF3pCb34Ka/blrA22udjy', '78 145 67 88', 'entrepreneur', 'actif', NULL, NULL, '2026-06-06 18:15:25', '2026-06-06 18:15:25', 'default.png'),
(6, 'Alsanne', 'Faye', 'alsannefaye@gmail.com', '$2y$12$jKxQjE5c2WNkDuFxX2BBXOn9Gyw/RikAaoZoWSs/oM4lvDrEZZr1C', '77 146 77 89', 'entrepreneur', 'actif', NULL, NULL, '2026-06-06 18:24:45', '2026-06-06 18:24:45', 'default.png'),
(11, 'Doudou', 'Ndiaye', 'doudoundiaye@gmail.com', '$2y$12$9rDWt6rwO2N3if2UDSW1KuUARrYSPavN2FGFOfmSVLJGIkqzcRKQ6', '77 204 66 11', 'bailleur', 'actif', NULL, NULL, '2026-06-10 00:17:18', '2026-06-10 00:17:18', ''),
(12, 'Mohamed', 'Dieng', 'mohameddieng@gmail.com', '$2y$12$iJyWNK.4N.y5ra7O9ChILuma9p8WC6zYdkEUrvZmzcAzR5XnSKWc2', '77 283 47 09', 'entrepreneur', 'actif', NULL, NULL, '2026-06-10 14:37:07', '2026-06-10 14:37:07', ''),
(13, 'Babacar', 'Sow', 'babacarsow@gmail.com', '$2y$12$9ecPQot6ifvxFauO1WlUKuKKpTl.pccTlBtQTlgT0ePtJ6nrGZwky', '78 355 20 84', 'bailleur', 'actif', NULL, 'uKjq8Ps9cXw19ytqVoGscFjEKXZzsvStwn5uq4Go8NWLkdOO8Bb2S4X9BUHN', '2026-06-13 17:01:51', '2026-06-13 17:01:51', ''),
(14, 'Babacar', 'Sow', 'babacar5sow@gmail.com', '$2y$12$mH0niEQTSUbKN4vMWsRysuylFoRjnE4E3j3O2m07mOhBH3kN0T4kq', '78 355 20 84', 'bailleur', 'actif', NULL, NULL, '2026-06-13 17:07:47', '2026-06-13 17:07:47', ''),
(15, 'Khadidiatou', 'Fall', 'khadidiatoufall@gmail.com', '$2y$12$/23uQyV3eGKke25bhsn/iOSq2/y3Ie073IiR0d.PRze0Zf0VqDkOi', '70 456 34 80', 'bailleur', 'actif', NULL, NULL, '2026-06-13 18:21:47', '2026-06-13 18:21:47', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bailleurs`
--
ALTER TABLE `bailleurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bailleurs_id_utilisateur_foreign` (`id_utilisateur`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Index pour la table `contrats`
--
ALTER TABLE `contrats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contrats_financement_id_foreign` (`financement_id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_id_utilisateur_foreign` (`id_utilisateur`);

--
-- Index pour la table `echeances`
--
ALTER TABLE `echeances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `echeances_financements_id_foreign` (`financements_id`);

--
-- Index pour la table `entrepreneurs`
--
ALTER TABLE `entrepreneurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entrepreneurs_id_utilisateur_foreign` (`id_utilisateur`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `financements`
--
ALTER TABLE `financements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financements_id_utilisateur_foreign` (`id_utilisateur`),
  ADD KEY `financements_id_bailleur_foreign` (`id_bailleur`);

--
-- Index pour la table `garanties`
--
ALTER TABLE `garanties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `garanties_id_financement_foreign` (`id_financement`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_id_utilisateur_foreign` (`id_utilisateur`);

--
-- Index pour la table `offre_financements`
--
ALTER TABLE `offre_financements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offre_financements_projet_id_foreign` (`projet_id`),
  ADD KEY `offre_financements_id_utilisateur_foreign` (`id_utilisateur`),
  ADD KEY `offre_financements_id_bailleur_foreign` (`id_bailleur`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projets_id_utilisateur_foreign` (`id_utilisateur`),
  ADD KEY `projets_id_entrepreneur_foreign` (`id_entrepreneur`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bailleurs`
--
ALTER TABLE `bailleurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `contrats`
--
ALTER TABLE `contrats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `echeances`
--
ALTER TABLE `echeances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entrepreneurs`
--
ALTER TABLE `entrepreneurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `financements`
--
ALTER TABLE `financements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `garanties`
--
ALTER TABLE `garanties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `offre_financements`
--
ALTER TABLE `offre_financements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bailleurs`
--
ALTER TABLE `bailleurs`
  ADD CONSTRAINT `bailleurs_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `contrats`
--
ALTER TABLE `contrats`
  ADD CONSTRAINT `contrats_financement_id_foreign` FOREIGN KEY (`financement_id`) REFERENCES `financements` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `echeances`
--
ALTER TABLE `echeances`
  ADD CONSTRAINT `echeances_financements_id_foreign` FOREIGN KEY (`financements_id`) REFERENCES `financements` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entrepreneurs`
--
ALTER TABLE `entrepreneurs`
  ADD CONSTRAINT `entrepreneurs_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `financements`
--
ALTER TABLE `financements`
  ADD CONSTRAINT `financements_id_bailleur_foreign` FOREIGN KEY (`id_bailleur`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `financements_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `garanties`
--
ALTER TABLE `garanties`
  ADD CONSTRAINT `garanties_id_financement_foreign` FOREIGN KEY (`id_financement`) REFERENCES `financements` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `offre_financements`
--
ALTER TABLE `offre_financements`
  ADD CONSTRAINT `offre_financements_id_bailleur_foreign` FOREIGN KEY (`id_bailleur`) REFERENCES `bailleurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offre_financements_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offre_financements_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projets`
--
ALTER TABLE `projets`
  ADD CONSTRAINT `projets_id_entrepreneur_foreign` FOREIGN KEY (`id_entrepreneur`) REFERENCES `entrepreneurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projets_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
