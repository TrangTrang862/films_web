-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 18, 2024 at 02:29 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `film`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_cover` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `actors`
--

INSERT INTO `actors` (`id`, `name`, `dob`, `avatar`, `background_cover`, `overview`, `biography`, `created_at`, `updated_at`) VALUES
(1, 'ASH', '2000-01-25', 'actor_avatars/avatar.jpg', 'actor_background_covers/cover.jpg', 'overviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverview', 'biographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiography', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(2, 'MWAK', '1998-12-07', 'actor_avatars/avatar.jpg', 'actor_background_covers/cover.jpg', 'overviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverview', 'biographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiography', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(3, 'HANI', '1999-06-15', 'actor_avatars/avatar.jpg', 'actor_background_covers/cover.jpg', 'overviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverviewoverview', 'biographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiographybiography', '2024-09-15 08:20:46', '2024-09-15 08:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super_admin@app.com', NULL, NULL, '$2y$10$fjepxU/7PlPw1Eqt3aNE9ukGgcylu8cFZWroptaVRTcPD2/fs4xR6', NULL, '2024-09-15 08:20:46', '2024-09-15 08:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Category1', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(2, 'Category2', '2024-09-15 08:20:46', '2024-09-15 08:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `film_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_cover` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`, `name`, `year`, `overview`, `background_cover`, `poster`, `video`, `created_at`, `updated_at`) VALUES
(7, 'thuong', '2343', 'erewrewrewrewr', 'film_background_covers/sxexXoTrjuC71FzZckjvn8leEzvCQAileG5dn9o2.jpeg', 'film_posters/f5z0vH6zni9su99PxGFfn2x7xpanBGdhgd4fxX5f.jpeg', 'film_videos/RhqWQlyUA3Qn9QVzQQqpbDhu8rlOLVcIna9GISZp.mp4', '2024-09-18 07:04:40', '2024-09-18 07:04:40'),
(8, 'product123', '3232', 'wewewewe', 'film_background_covers/RoE4foyF48FrSr0W7LzummDUUhvUrmcA3SEiPPQw.png', 'film_posters/KHQQ5xpWJVxCB03VH7OgpmB5UXW9wKz27Yuq56Z9.png', 'film_videos/oYUhYW6qQL7yg8FEnLfnNSSo5DZeY4veLpbCaoRA.mp4', '2024-09-18 07:09:55', '2024-09-18 07:09:55'),
(9, 'testdwdw', '2343', 'dwdwdwd', 'film_background_covers/fsMLrJV976uufjv0cl5CraT1I16nVU3ogH3oOEzR.jpeg', 'film_posters/YAN8bHE6PPbKw1MqGfK0OzAlOlgvSc60NunAvC5O.jpeg', 'film_videos/ycqAGfgJta5gtvkyAgv3iXpr6ABGfBXlN2uwa4gX.mp4', '2024-09-18 07:22:41', '2024-09-18 07:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `film_actor`
--

CREATE TABLE `film_actor` (
  `id` bigint UNSIGNED NOT NULL,
  `film_id` bigint UNSIGNED NOT NULL,
  `actor_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `film_actor`
--

INSERT INTO `film_actor` (`id`, `film_id`, `actor_id`, `created_at`, `updated_at`) VALUES
(6, 7, 1, NULL, NULL),
(7, 7, 2, NULL, NULL),
(8, 8, 2, NULL, NULL),
(9, 9, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `film_category`
--

CREATE TABLE `film_category` (
  `id` bigint UNSIGNED NOT NULL,
  `film_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `film_category`
--

INSERT INTO `film_category` (`id`, `film_id`, `category_id`, `created_at`, `updated_at`) VALUES
(6, 7, 1, NULL, NULL),
(7, 7, 2, NULL, NULL),
(8, 8, 1, NULL, NULL),
(9, 9, 1, NULL, NULL),
(10, 9, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `email`, `title`, `message`, `created_at`, `updated_at`) VALUES
(1, 'bimax270702@gmail.com', '34', '234234', '2024-09-15 08:20:08', '2024-09-15 08:20:08'),
(2, 'user1@app.com', 'user1', 'user1user1user1user1user1user1', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(3, 'user2@app.com', 'user2', 'user2user2user2user2user2user2', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(4, 'user3@app.com', 'user3', 'user3user3user3user3user3user3', '2024-09-15 08:20:46', '2024-09-15 08:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2020_06_02_095050_create_admins_table', 1),
(10, '2020_06_03_195558_laratrust_setup_tables', 1),
(11, '2020_06_04_194447_create_films_table', 1),
(12, '2020_06_04_232843_create_categories_table', 1),
(13, '2020_06_05_001446_create_film_category_table', 1),
(14, '2020_06_05_120307_create_ratings_table', 1),
(15, '2020_06_07_080359_create_reviews_table', 1),
(16, '2020_06_07_090829_create_favorites_table', 1),
(17, '2020_06_07_150108_create_actors_table', 1),
(18, '2020_06_07_163648_create_film_actor_table', 1),
(19, '2020_06_07_172955_create_messages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'create_admins', 'Create Admins', 'Create Admins', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(2, 'read_admins', 'Read Admins', 'Read Admins', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(3, 'update_admins', 'Update Admins', 'Update Admins', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(4, 'delete_admins', 'Delete Admins', 'Delete Admins', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(5, 'create_clients', 'Create Clients', 'Create Clients', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(6, 'read_clients', 'Read Clients', 'Read Clients', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(7, 'update_clients', 'Update Clients', 'Update Clients', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(8, 'delete_clients', 'Delete Clients', 'Delete Clients', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(9, 'create_films', 'Create Films', 'Create Films', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(10, 'read_films', 'Read Films', 'Read Films', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(11, 'update_films', 'Update Films', 'Update Films', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(12, 'delete_films', 'Delete Films', 'Delete Films', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(13, 'create_categories', 'Create Categories', 'Create Categories', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(14, 'read_categories', 'Read Categories', 'Read Categories', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(15, 'update_categories', 'Update Categories', 'Update Categories', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(16, 'delete_categories', 'Delete Categories', 'Delete Categories', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(17, 'create_actors', 'Create Actors', 'Create Actors', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(18, 'read_actors', 'Read Actors', 'Read Actors', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(19, 'update_actors', 'Update Actors', 'Update Actors', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(20, 'delete_actors', 'Delete Actors', 'Delete Actors', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(21, 'read_ratings', 'Read Ratings', 'Read Ratings', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(22, 'delete_ratings', 'Delete Ratings', 'Delete Ratings', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(23, 'read_reviews', 'Read Reviews', 'Read Reviews', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(24, 'delete_reviews', 'Delete Reviews', 'Delete Reviews', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(25, 'read_messages', 'Read Messages', 'Read Messages', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(26, 'delete_messages', 'Delete Messages', 'Delete Messages', '2024-09-15 08:20:46', '2024-09-15 08:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `permission_admin`
--

CREATE TABLE `permission_admin` (
  `permission_id` int UNSIGNED NOT NULL,
  `admin_id` int UNSIGNED NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `film_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `film_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Admin', 'Super Admin', '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(2, 'admin', 'Admin', 'Admin', '2024-09-15 08:20:46', '2024-09-15 08:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `role_admin`
--

CREATE TABLE `role_admin` (
  `role_id` int UNSIGNED NOT NULL,
  `admin_id` int UNSIGNED NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_admin`
--

INSERT INTO `role_admin` (`role_id`, `admin_id`, `user_type`) VALUES
(1, 1, 'App\\Admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'UserName', 'FirstName', 'LastName', 'user@app.com', NULL, NULL, '$2y$10$fjepxU/7PlPw1Eqt3aNE9ukGgcylu8cFZWroptaVRTcPD2/fs4xR6', NULL, '2024-09-15 08:20:46', '2024-09-15 08:20:46'),
(2, 'user2', 'user2', 'user2', 'user2@app.com', NULL, NULL, '$2y$10$sQaCdCNhCLPH1mXoY5UTa.5jKss/hp6bE0.oG.uqB80ErgrFkAiAi', NULL, '2024-09-15 08:20:46', '2024-09-15 08:20:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `actors_name_unique` (`name`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_film_id_unique` (`user_id`,`film_id`),
  ADD KEY `favorites_film_id_foreign` (`film_id`);

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `films_name_unique` (`name`);

--
-- Indexes for table `film_actor`
--
ALTER TABLE `film_actor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `film_actor_film_id_actor_id_unique` (`film_id`,`actor_id`),
  ADD KEY `film_actor_actor_id_foreign` (`actor_id`);

--
-- Indexes for table `film_category`
--
ALTER TABLE `film_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `film_category_film_id_category_id_unique` (`film_id`,`category_id`),
  ADD KEY `film_category_category_id_foreign` (`category_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_admin`
--
ALTER TABLE `permission_admin`
  ADD PRIMARY KEY (`admin_id`,`permission_id`,`user_type`),
  ADD KEY `permission_admin_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ratings_user_id_film_id_unique` (`user_id`,`film_id`),
  ADD KEY `ratings_film_id_foreign` (`film_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_film_id_foreign` (`film_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_admin`
--
ALTER TABLE `role_admin`
  ADD PRIMARY KEY (`admin_id`,`role_id`,`user_type`),
  ADD KEY `role_admin_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `film_actor`
--
ALTER TABLE `film_actor`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `film_category`
--
ALTER TABLE `film_category`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `film_actor`
--
ALTER TABLE `film_actor`
  ADD CONSTRAINT `film_actor_actor_id_foreign` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `film_actor_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `film_category`
--
ALTER TABLE `film_category`
  ADD CONSTRAINT `film_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `film_category_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_admin`
--
ALTER TABLE `permission_admin`
  ADD CONSTRAINT `permission_admin_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_admin`
--
ALTER TABLE `role_admin`
  ADD CONSTRAINT `role_admin_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
