-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2026 at 10:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `wishlist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `total_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_by_admin` tinyint(1) NOT NULL DEFAULT 0,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `price_per_night` decimal(12,2) NOT NULL,
  `nights` int(11) NOT NULL,
  `subtotal` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_02_000001_add_fields_to_users_table', 1),
(5, '2024_01_02_000002_create_room_types_table', 1),
(6, '2024_01_02_000003_create_rooms_table', 1),
(7, '2024_01_02_000004_create_wishlists_table', 1),
(8, '2024_01_02_000005_create_wishlist_items_table', 1),
(9, '2024_01_02_000006_create_bookings_table', 1),
(10, '2024_01_02_000007_create_booking_details_table', 1),
(11, '2024_01_02_000008_create_service_numbers_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `view_type` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_type_id`, `room_number`, `view_type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'N1', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(2, 1, 'N2', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(3, 1, 'N3', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(4, 1, 'N4', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(5, 1, 'N5', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(6, 1, 'N6', 'sea', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(7, 1, 'N7', 'sea', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(8, 1, 'N8', 'sea', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(9, 1, 'N9', 'pool', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(10, 1, 'N10', 'pool', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(11, 2, 'D1', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(12, 2, 'D2', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(13, 2, 'D3', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(14, 2, 'D4', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(15, 2, 'D5', 'sea', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(16, 2, 'D6', 'sea', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(17, 2, 'D7', 'pool', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(18, 2, 'D8', 'pool', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(19, 3, 'S1', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(20, 3, 'S2', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(21, 3, 'S3', 'city', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(22, 3, 'S4', 'sea', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(23, 3, 'S5', 'sea', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(24, 3, 'S6', 'pool', 1, '2026-06-16 00:59:54', '2026-06-16 00:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short_description` text DEFAULT NULL,
  `price_per_night` decimal(12,2) NOT NULL,
  `max_capacity` int(11) NOT NULL DEFAULT 2,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `slug`, `description`, `short_description`, `price_per_night`, `max_capacity`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Standard Room', 'standard', 'Our Standard Room offers a serene retreat with plush bedding, a work desk, flat-screen TV, and a private en-suite bathroom with rainfall shower. Thoughtfully designed to blend comfort with elegance, it\'s the perfect base for both business and leisure travelers. Room size: 28 sqm.', 'A comfortable and elegantly designed room with all essential amenities for a relaxing stay.', 850000.00, 2, 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80', '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(2, 'Deluxe Room', 'deluxe', 'Step into refined luxury with our Deluxe Room, featuring premium furnishings, a king-size bed with premium linens, a separate soaking tub, and a panoramic city or sea view. Includes complimentary minibar, Nespresso machine, and dedicated concierge service. Room size: 42 sqm.', 'Elevated luxury with premium furnishings, superior views, and exclusive in-room amenities.', 1500000.00, 2, 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80', '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(3, 'Suite Room', 'suite', 'Experience the ultimate in luxury with our Suite Room — a lavish sanctuary featuring a separate living room, walk-in closet, premium Jacuzzi, and a private balcony with breathtaking views. Enjoy bespoke butler service, curated welcome amenities, and exclusive lounge access. Room size: 75 sqm.', 'The pinnacle of luxury — a spacious suite with a private living area and bespoke butler service.', 3200000.00, 3, 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80', '2026-06-16 00:59:54', '2026-06-16 00:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `service_numbers`
--

CREATE TABLE `service_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `extension` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_easter_egg` tinyint(1) NOT NULL DEFAULT 0,
  `easter_egg_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_numbers`
--

INSERT INTO `service_numbers` (`id`, `extension`, `department`, `description`, `is_easter_egg`, `easter_egg_url`, `created_at`, `updated_at`) VALUES
(1, '1', 'Front Desk', 'Check-in, check-out, and general inquiries', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(2, '2', 'Restaurant', 'Reservations, room service, and dining', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(3, '3', 'Customer Service', 'Complaints, feedback, and special requests', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(4, '4', 'Housekeeping', 'Room cleaning, extra towels, and laundry', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(5, '5', 'Security', '24/7 security and emergency assistance', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(6, '6', 'Concierge', 'Transportation, tickets, and local recommendations', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(7, '7', 'Spa & Wellness', 'Appointments, treatments, and wellness packages', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(8, '8', 'Business Center', 'Printing, meetings, and corporate services', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(9, '9', 'Pool & Recreation', 'Pool hours, gym access, and activity bookings', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(10, '10', 'Maintenance', 'Technical issues, repairs, and utilities', 0, NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(11, '666', '???', 'Do not call this number...', 1, 'https://www.youtube.com/watch?v=6VMRAGxjOoA&pp=ygUDNjY2', '2026-06-16 00:59:54', '2026-06-16 00:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('WkOyGxMonQ1oWGBMKtKInaQ9pOXW9pZlBCi12dxn', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN3NSaVo2RUJBY2RWTmt3NFNRRVl1TkR0VzNxN3dqOEFnYXpVMTlhNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1781597426);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `date_of_birth`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', '1990-01-01', 'admin@lunarity.com', NULL, '$2y$12$2ypA2dXMhC1tl3cDi5Z1NuSKsgfQQEuOixZfB8cEkMP2CIstr5Mzi', NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(2, 'John Doe', 'user', '1995-06-15', 'john@example.com', NULL, '$2y$12$AqGAcIehhRkdF6HdfMl4bOmXoifllFKFk2MDqmqAiCSy0CdOmFmKG', NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54'),
(3, 'Jane Smith', 'user', '1998-03-22', 'jane@example.com', NULL, '$2y$12$NAUTyee/ULG88P6UlC5m4OMRic3TUObjZX1IonLWNUXBieI.k/6Gq', NULL, '2026-06-16 00:59:54', '2026-06-16 00:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wishlist_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_wishlist_id_foreign` (`wishlist_id`),
  ADD KEY `bookings_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_details_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_details_room_id_foreign` (`room_id`),
  ADD KEY `booking_details_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_types_slug_unique` (`slug`);

--
-- Indexes for table `service_numbers`
--
ALTER TABLE `service_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlist_items_wishlist_id_room_type_id_unique` (`wishlist_id`,`room_type_id`),
  ADD KEY `wishlist_items_room_type_id_foreign` (`room_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_numbers`
--
ALTER TABLE `service_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_wishlist_id_foreign` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlists` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_wishlist_id_foreign` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlists` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
