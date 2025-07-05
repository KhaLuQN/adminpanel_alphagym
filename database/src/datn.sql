-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 03, 2025 at 04:46 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datn`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_knowledge_base`
--

CREATE TABLE `ai_knowledge_base` (
  `kb_id` int NOT NULL,
  `intent_name` varchar(100) DEFAULT NULL COMMENT 'Tên ý định (ví dụ: ask_package_price, ask_gym_location)',
  `question_pattern` text COMMENT 'Mẫu câu hỏi người dùng (có thể chứa regex hoặc từ khóa)',
  `answer` text NOT NULL COMMENT 'Câu trả lời của AI',
  `category` varchar(50) DEFAULT NULL COMMENT 'Chủ đề (gói tập, dinh dưỡng, lịch tập, cơ sở vật chất)',
  `keywords` text COMMENT 'Các từ khóa liên quan, cách nhau bởi dấu phẩy',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text,
  `featured_image_url` varchar(255) DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `article_category_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('news','event','blog','promotion') NOT NULL DEFAULT 'blog',
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `event_start_time` datetime DEFAULT NULL,
  `event_end_time` datetime DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `view_count` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `title`, `slug`, `content`, `excerpt`, `featured_image_url`, `user_id`, `article_category_id`, `type`, `status`, `published_at`, `event_start_time`, `event_end_time`, `event_location`, `meta_keywords`, `meta_description`, `view_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Giới thiệu trung tâm Gym mới', 'gioi-thieu-trung-tam-gym-moi', 'Nội dung bài viết chi tiết về trung tâm gym...', 'Trung tâm gym hiện đại...', 'frontend/images/articles/postitem1.jpg', 1, NULL, 'news', 'published', '2024-06-01 08:00:00', NULL, NULL, NULL, 'gym, giới thiệu', 'Giới thiệu trung tâm gym mới', 150, '2025-06-27 12:58:32', '2025-06-28 01:21:50', NULL),
(2, 'Sự kiện tập thử miễn phí', 'su-kien-tap-thu-mien-phi', 'Chi tiết sự kiện tập thử...', 'Tập thử miễn phí...', 'frontend/images/articles/postitem2.jpg', 1, NULL, 'event', 'published', '2024-06-10 08:00:00', '2024-06-15 09:00:00', '2024-06-15 17:00:00', 'Trung tâm AlphaGym', 'sự kiện, tập thử', 'Tham gia tập thử miễn phí', 200, '2025-06-27 12:58:32', '2025-06-28 01:22:04', NULL),
(3, 'Cách giảm cân hiệu quả', 'cach-giam-can-hieu-qua', 'Bài viết chia sẻ kinh nghiệm giảm cân...', 'Giảm cân lành mạnh...', 'frontend/images/articles/postitem3.jpg', 1, NULL, 'blog', 'published', '2024-06-05 08:00:00', NULL, NULL, NULL, 'giảm cân, sức khoẻ', 'Bí quyết giảm cân hiệu quả', 320, '2025-06-27 12:58:32', '2025-06-28 01:22:09', NULL),
(4, 'Khuyến mãi tháng 7', 'khuyen-mai-thang-7', 'Chi tiết chương trình khuyến mãi...', 'Giảm giá tới 30%...', 'frontend/images/articles/postitem4.jpg', 1, NULL, 'promotion', 'draft', NULL, NULL, NULL, NULL, 'khuyến mãi, giảm giá', 'Ưu đãi đặc biệt tháng 7', 50, '2025-06-27 12:58:32', '2025-06-28 01:22:16', NULL),
(5, 'Lịch khai giảng lớp yoga', 'lich-khai-giang-lop-yoga', 'Chi tiết lịch khai giảng lớp Yoga...', 'Khai giảng lớp yoga...', 'frontend/images/articles/postitem5.jpg', 1, NULL, 'event', 'published', '2024-06-20 08:00:00', '2024-07-01 08:00:00', '2024-07-01 10:00:00', 'Phòng số 2', 'yoga, khai giảng', 'Khai giảng lớp yoga', 180, '2025-06-27 12:58:32', '2025-06-28 01:22:21', NULL),
(6, 'Tập gym có lợi cho tim mạch?', 'tap-gym-co-loi-cho-tim-mach', 'Nghiên cứu chỉ ra rằng...', 'Lợi ích tim mạch...', 'frontend/images/articles/postitem6.jpg', 1, NULL, 'blog', 'published', '2024-06-12 08:00:00', NULL, NULL, NULL, 'gym, tim mạch', 'Tập gym và sức khỏe tim', 270, '2025-06-27 12:58:32', '2025-06-28 01:22:26', NULL),
(7, 'Giảm giá cho hội viên mới', 'giam-gia-cho-hoi-vien-moi', 'Ưu đãi hấp dẫn cho người đăng ký mới...', 'Hội viên mới nhận ưu đãi...', 'frontend/images/articles/postitem7.jpg', 1, NULL, 'promotion', 'published', '2024-06-18 08:00:00', NULL, NULL, NULL, 'khuyến mãi, hội viên mới', 'Ưu đãi khi đăng ký lần đầu', 95, '2025-06-27 12:58:32', '2025-06-28 01:22:30', NULL),
(8, 'Sự kiện thi đấu thể hình', 'su-kien-thi-dau-the-hinh', 'Cuộc thi thể hình toàn thành phố...', 'Tham gia thi đấu...', 'frontend/images/articles/postitem8.jpg', 1, NULL, 'event', 'archived', '2024-05-15 08:00:00', '2024-05-20 08:00:00', '2024-05-20 18:00:00', 'Sân vận động A', 'thể hình, thi đấu', 'Sự kiện thể hình 2024', 500, '2025-06-27 12:58:32', '2025-06-28 01:22:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_categories`
--

CREATE TABLE `article_categories` (
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text,
  `cover_image_url` varchar(255) DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Danh mục cha (nếu có)',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `article_categories`
--

INSERT INTO `article_categories` (`category_id`, `name`, `slug`, `description`, `cover_image_url`, `parent_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Thể hình', 'the-hinh', 'Chương trình luyện tập chuyên sâu giúp bạn phát triển cơ bắp, cải thiện thể hình và nâng cao sức mạnh vượt trội.', 'frontend/images/articleCategory/bodybuilding.jpg', NULL, '2025-06-29 02:16:58', '2025-06-29 03:16:33', NULL),
(2, 'Tim mạch', 'tim-mach', 'Các bài tập linh hoạt phù hợp cho nữ giới, tập trung vào eo, mông, đùi và vóc dáng săn chắc, cải thiện sức bền tim mạch.', 'frontend/images/articleCategory/cardio.jpg', NULL, '2025-06-29 02:16:58', '2025-06-29 03:16:59', NULL),
(3, 'Fitness Toàn diện', 'fitness-toan-dien', 'Lộ trình tập luyện được cá nhân hóa, phù hợp với mọi cấp độ – từ người mới đến vận động viên chuyên nghiệp, hướng tới sức khỏe tổng thể.', 'frontend/images/articleCategory/crossfit.jpg', NULL, '2025-06-29 02:16:58', '2025-06-29 03:17:16', NULL),
(4, 'CrossFit', 'crossfit', 'Phương pháp luyện tập kết hợp nhiều kỹ thuật giúp đốt mỡ, tăng sức bền, cải thiện thể lực toàn diện và bứt phá giới hạn.', 'frontend/images/articleCategory/fitness.jpg', NULL, '2025-06-29 02:16:58', '2025-06-29 03:17:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkins`
--

CREATE TABLE `checkins` (
  `checkin_id` int NOT NULL,
  `member_id` int NOT NULL,
  `checkin_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `checkout_time` datetime DEFAULT NULL,
  `rfid_card_id` varchar(50) DEFAULT NULL COMMENT 'Mã thẻ sử dụng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checkins`
--

INSERT INTO `checkins` (`checkin_id`, `member_id`, `checkin_time`, `checkout_time`, `rfid_card_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-05-21 06:15:00', '2025-05-26 11:40:32', '0005181340', NULL, '2025-05-26 04:40:32'),
(2, 2, '2025-05-22 08:00:00', '2025-05-26 11:34:32', '0005181340', NULL, '2025-05-26 04:34:32'),
(3, 3, '2025-05-25 09:30:00', '2025-05-25 10:45:00', '0005181340', NULL, NULL),
(4, 4, '2025-05-25 10:00:00', '2025-05-25 11:00:00', '0005181340', NULL, NULL),
(5, 5, '2025-05-25 11:15:00', '2025-05-25 12:30:00', '0005181340', NULL, NULL),
(6, 4, '2025-05-26 12:35:54', '2025-05-26 12:44:29', '0012735018', '2025-05-26 05:35:54', '2025-05-26 05:44:29'),
(14, 1, '2025-05-26 12:44:33', '2025-05-26 12:44:36', '0013068300', '2025-05-26 05:44:33', '2025-05-26 05:44:36'),
(15, 4, '2025-05-26 12:44:41', '2025-05-26 12:44:45', '0012735018', '2025-05-26 05:44:41', '2025-05-26 05:44:45'),
(16, 1, '2025-05-26 12:44:51', '2025-05-26 12:45:42', '0013068300', '2025-05-26 05:44:51', '2025-05-26 05:45:42'),
(17, 4, '2025-05-26 12:47:50', '2025-05-26 13:01:18', '0012735018', '2025-05-26 05:47:50', '2025-05-26 06:01:18'),
(18, 1, '2025-05-26 12:49:05', '2025-05-26 13:01:20', '0013068300', '2025-05-26 05:49:05', '2025-05-26 06:01:20'),
(19, 1, '2025-05-26 13:01:26', '2025-05-26 13:01:39', '0013068300', '2025-05-26 06:01:26', '2025-05-26 06:01:39'),
(20, 1, '2025-05-26 13:01:43', '2025-05-26 13:02:00', '0013068300', '2025-05-26 06:01:43', '2025-05-26 06:02:00'),
(21, 1, '2025-05-26 13:56:40', '2025-05-26 13:56:41', '0013068300', '2025-05-26 06:56:40', '2025-05-26 06:56:41'),
(22, 1, '2025-05-26 13:56:53', '2025-05-29 13:48:02', '0013068300', '2025-05-26 06:56:53', '2025-05-29 06:48:02'),
(23, 4, '2025-05-26 13:57:09', '2025-05-29 13:48:02', '0012735018', '2025-05-26 06:57:09', '2025-05-29 06:48:02'),
(24, 2, '2025-05-26 14:17:18', '2025-05-26 14:17:39', '0005181340', '2025-05-26 07:17:18', '2025-05-26 07:17:39'),
(25, 3, '2025-05-26 14:17:36', '2025-05-29 13:48:02', '0003625904', '2025-05-26 07:17:36', '2025-05-29 06:48:02'),
(26, 4, '2025-06-15 04:29:46', '2025-06-15 04:29:55', '0012735018', '2025-06-14 21:29:46', '2025-06-14 21:29:55'),
(27, 4, '2025-06-15 04:30:31', '2025-06-15 04:33:17', '0012735018', '2025-06-14 21:30:31', '2025-06-14 21:33:17'),
(28, 4, '2025-06-15 04:33:21', '2025-06-15 04:33:57', '0012735018', '2025-06-14 21:33:21', '2025-06-14 21:33:57'),
(29, 4, '2025-06-15 04:34:05', '2025-06-15 04:34:28', '0012735018', '2025-06-14 21:34:05', '2025-06-14 21:34:28'),
(30, 2, '2025-06-15 13:45:38', '2025-06-15 13:54:44', '0005181340', '2025-06-15 06:45:38', '2025-06-15 06:54:44'),
(31, 1, '2025-06-15 13:50:49', '2025-06-15 13:51:43', '0013068300', '2025-06-15 06:50:49', '2025-06-15 06:51:43'),
(32, 4, '2025-06-15 13:51:09', '2025-06-15 13:51:40', '0012735018', '2025-06-15 06:51:09', '2025-06-15 06:51:40'),
(33, 4, '2025-06-15 13:55:17', '2025-06-15 20:59:43', '0012735018', '2025-06-15 06:55:17', '2025-06-15 13:59:43'),
(34, 4, '2025-06-15 20:59:47', '2025-06-15 21:00:21', '0012735018', '2025-06-15 13:59:47', '2025-06-15 14:00:21'),
(35, 4, '2025-06-22 09:15:11', '2025-06-22 09:17:17', '0012735018', '2025-06-22 02:15:11', '2025-06-22 02:17:17'),
(36, 4, '2025-07-02 21:30:59', '2025-07-02 21:31:03', '0012735018', '2025-07-02 14:30:59', '2025-07-02 14:31:03'),
(37, 4, '2025-07-02 21:31:06', '2025-07-02 21:31:13', '0012735018', '2025-07-02 14:31:06', '2025-07-02 14:31:13');

-- --------------------------------------------------------

--
-- Table structure for table `communication_logs`
--

CREATE TABLE `communication_logs` (
  `log_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `campaign_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên chiến dịch, ví dụ: feedback-3-thang',
  `channel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'email',
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('sent','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `sent_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `communication_logs`
--

INSERT INTO `communication_logs` (`log_id`, `member_id`, `user_id`, `campaign_name`, `channel`, `subject`, `body`, `status`, `sent_at`) VALUES
(1, 4, 1, 'dăd', 'email', 'dâd', 'dăda', 'sent', '2025-06-14 23:22:59'),
(2, 4, 1, 'tháng 4', 'email', 'đánh giád', 'adadâdadadaa', 'sent', '2025-06-14 23:27:17'),
(3, 5, 1, 'tháng 4', 'email', 'đánh giád', 'adadâdadadaa', 'sent', '2025-06-14 23:27:18'),
(4, 4, 1, 'Feed back thang 3', 'email', 'dadada', '[Nguyễn đình kha] cdadadhào bạn', 'sent', '2025-06-15 00:10:52'),
(5, 4, 1, 'adadad', 'email', 'dadada', 'Nguyễn đình kha  cdadadhào bạn', 'sent', '2025-06-15 00:13:02'),
(6, 5, 1, 'adadad', 'email', 'dadada', 'Nguỹen đa  cdadadhào bạn', 'sent', '2025-06-15 00:13:04'),
(7, 4, 1, 'feedback thang 5', 'email', '1', 'chào Nguyễn đình kha, tham gia  24/05/2025', 'sent', '2025-06-15 01:46:16'),
(8, 5, 1, 'feedback thang 5', 'email', '1', 'chào Nguỹen đa, tham gia  25/05/2025', 'sent', '2025-06-15 01:46:17'),
(9, 4, 1, 'thang6', 'email', '22/6', 'Chào  Nguyễn đình kha, đã tham gia phòng tập vào  24/05/2025', 'sent', '2025-06-22 02:05:54'),
(10, 5, 1, 'thang6', 'email', '22/6', 'Chào  Nguỹen đa, đã tham gia phòng tập vào  25/05/2025', 'sent', '2025-06-22 02:05:55'),
(11, 4, 1, 'thang6lan2', 'email', 'Chiến dịch khảo sat thang 6 1111', 'chào Nguyễn đình kha đã tham gia vào ngày 24/05/2025', 'sent', '2025-06-22 05:08:02'),
(12, 5, 1, 'thang6lan2', 'email', 'Chiến dịch khảo sat thang 6 1111', 'chào Nguỹen đa đã tham gia vào ngày 25/05/2025', 'sent', '2025-06-22 05:08:03'),
(13, 5, 1, 'đánh giá huấn luyện viên', 'email', 'Đánh giá', 'bạn hãy đánh giá huấn luyện viên này', 'sent', '2025-06-22 06:52:49'),
(14, 5, 1, '1', 'email', '1', 'adadadad', 'sent', '2025-07-03 07:03:24');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `template_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên mẫu để admin nhận biết',
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nội dung mẫu, chứa các biến như [TEN_HOI_VIEN]',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`template_id`, `name`, `subject`, `body`, `created_at`, `updated_at`) VALUES
(3, 'mẫu mới', '22/6', 'Chào  [TEN_HOI_VIEN], đã tham gia phòng tập vào  [NGAY_THAM_GIA]', '2025-06-22 02:05:11', '2025-06-22 02:05:11'),
(4, 'Chiến dịch khảo sat thang 6', 'Chiến dịch khảo sat thang 6 1111', 'chào [TEN_HOI_VIEN] đã tham gia vào ngày [NGAY_THAM_GIA]', '2025-06-22 05:07:06', '2025-06-22 05:07:06');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `status` enum('working','maintenance','broken') NOT NULL DEFAULT 'working',
  `location` varchar(255) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `img`, `purchase_date`, `status`, `location`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Máy chạy bộ điện TechFitness TF-09AS12', 'admin/images/equipment/1748251344_13.jpg', '2023-01-15', 'working', 'Khu A - Tầng 1', 'Thường dùng cho cardio, còn mới.', '2025-05-26 08:15:05', '2025-07-03 08:48:29', NULL),
(4, 'Ghế tập tạ đa năng Xuki Pro', 'admin/images/equipment/bench_press.jpg', '2023-03-20', 'working', 'Khu A - Gần gương', 'Được sử dụng nhiều, cần bảo dưỡng định kỳ.', '2025-05-26 08:15:05', '2025-07-03 08:48:33', NULL),
(5, 'Xe đạp tập thể dục Air Bike MK981', 'admin/images/equipment/1749221725_vegetable-website-template.jpg', '2024-01-05', 'maintenance', 'Khu Cardio', 'Mới nhập đầu năm 2024, hoạt động tốt.', '2025-05-26 08:15:05', '2025-07-03 09:11:49', '2025-07-03 16:11:49'),
(6, 'mới', 'admin/images/equipment/1748269955_12.jpg', '2025-05-26', 'working', 'adada', 'dâd', '2025-05-26 07:32:35', '2025-06-22 02:47:47', '2025-06-22 09:47:47'),
(7, 'Tạ 20kg', 'admin/images/equipment/1751128811_dumble.png', '2025-06-26', 'working', 'Tầng 2', 'dăd', '2025-06-28 16:40:11', '2025-07-03 08:47:22', '2025-07-03 15:47:22'),
(8, 'dâd', 'admin/images/equipment/1751532486_founder.jpg', '2025-07-09', 'maintenance', 'ưqeq', 'qewqe', '2025-07-03 08:48:06', '2025-07-03 08:48:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rfid_card_id` varchar(50) DEFAULT NULL COMMENT 'Mã thẻ từ',
  `join_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `notes` text,
  `img` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','banned','expired') NOT NULL DEFAULT 'active',
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `full_name`, `phone`, `email`, `rfid_card_id`, `join_date`, `notes`, `img`, `created_at`, `updated_at`, `status`, `deleted_at`) VALUES
(1, 'Nguyễn Văn A11`22', 'ad', 'vana@example.com', NULL, '2024-12-01 08:00:00', '1', 'admin/images/member/1748096237_15.jpg', '2025-05-24 19:59:52', '2025-07-03 17:59:52', 'active', NULL),
(2, 'Trần Thị B1', '0912345678', 'thib@example.com', '0005181340', '2025-01-10 09:00:00', NULL, 'admin/images/member/1748096245_16.jpg', '2025-05-24 19:59:52', '2025-07-03 16:11:05', 'banned', '2025-07-03 16:11:05'),
(3, 'Lê Văn C', '0923456789', 'vanc@example.com', '0003625904', '2025-03-05 10:30:00', NULL, 'admin/images/member/1748096252_23.jpg', '2025-05-24 19:59:52', '2025-07-03 16:37:41', 'active', NULL),
(4, 'Nguyễn đình kha', '0386550651', 'khappp4@gmail.com', NULL, '2025-05-24 21:47:10', NULL, 'admin/images/member/1748098030_24.jpg', '2025-05-24 14:47:10', '2025-07-03 16:40:57', 'active', NULL),
(5, 'Nguỹen đa', '03865523321313', 'khappp45@gmail.com', NULL, '2025-05-25 13:33:20', 'dâdwdwad', 'admin/images/member/1748154800_23.jpg', '2025-05-25 06:33:20', '2025-07-03 16:37:39', 'active', NULL),
(6, 'Nguyễn văn a', '2131333313', 'khaop@gmail.com', '0001845604', '2025-06-15 21:03:17', NULL, 'admin/images/member/1749996197_API.JPG', '2025-06-15 21:03:17', '2025-07-03 15:38:13', 'active', '2025-07-03 15:38:13'),
(7, 'kha', '12313131313', 'khapi@gmail.com', 'dađaâdâd12312313123jgj', '2025-07-02 20:41:04', 'đa', 'admin/images/member/1751463664_founder.jpg', '2025-07-02 20:41:04', '2025-07-02 20:53:29', 'active', '2025-07-02 20:53:29'),
(8, 'đa', '1321232123', 'adadad@gmail.com', NULL, '2025-07-02 20:54:04', NULL, 'admin/images/member/1751464444_founder.jpg', '2025-07-02 20:54:04', '2025-07-03 16:37:36', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `plan_id` int NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `duration_days` int NOT NULL COMMENT 'Số ngày hiệu lực',
  `price` decimal(10,2) NOT NULL,
  `discount_percent` decimal(5,2) DEFAULT NULL COMMENT 'Phần trăm giảm giá',
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`plan_id`, `plan_name`, `duration_days`, `price`, `discount_percent`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tập thử 1 tuần', 7, '0.00', '100.00', 'Trải nghiệm miễn phí toàn bộ các khu vực và thiết bị hiện đại của chúng tôi trong vòng 7 ngày. Dành cho khách hàng mới muốn khám phá không gian luyện tập.', NULL, '2025-06-19 09:18:53', NULL),
(2, 'Gói 1 tháng', 30, '500000.00', '10.00', 'Lựa chọn linh hoạt cho những người muốn bắt đầu hoặc duy trì thói quen tập luyện mà không cần cam kết dài hạn. Toàn quyền truy cập tất cả các thiết bị.', NULL, NULL, NULL),
(3, 'Gói 3 tháng', 90, '1400000.00', '30.00', 'Gói tập tiết kiệm và hiệu quả nhất để bạn thấy được sự thay đổi rõ rệt về vóc dáng và sức khỏe. Phù hợp cho những mục tiêu nghiêm túc.', NULL, '2025-06-22 01:55:30', '2025-06-22 08:55:30'),
(4, 'Gói 6 tháng', 180, '2600000.00', '50.00', 'Cam kết cho một sự lột xác toàn diện! Đây là gói tập có chi phí tối ưu nhất, giúp bạn duy trì động lực và đạt được các mục tiêu thể hình cao nhất.', NULL, '2025-06-22 01:51:34', '2025-06-22 08:51:34'),
(6, 'Gói ngày lể', 1, '20000.00', '10.00', 'Gói tập đặc biệt cho các dịp lễ, giúp bạn duy trì việc tập luyện mà không bị gián đoạn. Phù hợp cho khách vãng lai hoặc hội viên muốn mua thêm ngày lẻ.', '2025-05-25 05:51:05', '2025-07-02 14:24:52', '2025-07-02 21:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `membersubscriptions`
--

CREATE TABLE `membersubscriptions` (
  `subscription_id` int NOT NULL,
  `member_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `actual_price` decimal(10,2) NOT NULL COMMENT 'Giá thực tế sau giảm',
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `payment_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `membersubscriptions`
--

INSERT INTO `membersubscriptions` (`subscription_id`, `member_id`, `plan_id`, `start_date`, `end_date`, `actual_price`, `payment_status`, `payment_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-05-01 00:00:00', '2025-05-31 23:59:59', '500000.00', 'Paid', '2025-05-01 08:00:00', NULL, NULL),
(2, 1, 2, '2025-02-01 00:00:00', '2025-04-30 23:59:59', '1147500.00', 'Paid', '2025-02-01 08:15:00', NULL, NULL),
(3, 2, 3, '2025-05-20 00:00:00', '2025-05-27 23:59:59', '0.00', 'Unpaid', NULL, NULL, NULL),
(4, 3, 1, '2025-01-01 00:00:00', '2025-01-31 23:59:59', '500000.00', 'Paid', '2025-01-01 07:30:00', NULL, NULL),
(5, 4, 2, '2025-05-25 00:00:00', '2025-06-24 00:00:00', '450000.00', 'Paid', '2025-05-25 15:19:52', '2025-05-25 08:19:52', '2025-05-25 08:19:52'),
(6, 5, 1, '2025-05-25 00:00:00', '2025-06-01 00:00:00', '0.00', 'Paid', '2025-05-25 15:20:09', '2025-05-25 08:20:09', '2025-05-25 08:20:09'),
(11, 2, 3, '2026-05-31 00:00:00', '2026-08-29 00:00:00', '980000.00', 'Paid', '2025-06-01 05:50:46', '2025-05-31 22:50:46', '2025-05-31 22:50:46'),
(12, 4, 4, '2025-06-25 00:00:00', '2025-12-22 00:00:00', '1300000.00', 'Paid', '2025-06-15 04:30:54', '2025-06-14 21:30:54', '2025-06-14 21:30:54'),
(13, 3, 3, '2025-06-15 00:00:00', '2025-09-13 00:00:00', '980000.00', 'Paid', '2025-06-15 08:33:51', '2025-06-15 01:33:51', '2025-06-15 01:33:51'),
(14, 2, 3, '2026-08-30 00:00:00', '2026-11-28 00:00:00', '980000.00', 'Paid', '2025-06-15 08:36:07', '2025-06-15 01:36:07', '2025-06-15 01:36:07'),
(15, 6, 2, '2025-06-23 00:00:00', '2025-07-23 00:00:00', '450000.00', 'Paid', '2025-06-22 09:26:18', '2025-06-22 02:26:18', '2025-06-22 02:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_19_115832_create_users_table', 2),
(5, '2025_06_15_055037_create_email_templates_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int NOT NULL,
  `subscription_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `payment_method` enum('Cash','Bank Transfer','Credit Card') NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `subscription_id`, `amount`, `payment_date`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES
(1, 11, '980000.00', '2025-06-01 05:50:46', 'Cash', 'Thanh toán tiền mặt tại quầy', '2025-05-31 22:50:46', '2025-05-31 22:50:46'),
(2, 12, '1300000.00', '2025-06-15 04:30:54', 'Cash', 'Thanh toán tiền mặt tại quầy', '2025-06-14 21:30:55', '2025-06-14 21:30:55'),
(3, 13, '980000.00', '2025-06-15 08:33:51', 'Cash', 'Thanh toán tiền mặt tại quầy', '2025-06-15 01:33:51', '2025-06-15 01:33:51'),
(4, 14, '980000.00', '2025-06-15 08:36:07', 'Cash', 'Thanh toán tiền mặt tại quầy', '2025-06-15 01:36:07', '2025-06-15 01:36:07'),
(5, 15, '450000.00', '2025-06-22 09:26:18', 'Cash', 'Thanh toán tiền mặt tại quầy', '2025-06-22 02:26:18', '2025-06-22 02:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5IcG1aHWQLXvuvBylBbyE8UmnTa3HmMhSfL7Hnpd', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRTVsZVI3QzZEQTlQN2VhYmJHc1R3UGQ2M3Mxd1lrYWFlekVxMVRqNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW5wYW5lbF9hbHBoYWd5bV90ZXN0L3B1YmxpYy9wYWNrYWdlL2luZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1751561016),
('928811zz1GlbkG6yqeg2pScTj9hjfV7kLFGwAkdq', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicXBkeXVwQkJ6a3ViMEljNXNOb1hGUFlXZVl3Y1ZYMGU2eFMzSWRZcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHA6Ly9sb2NhbGhvc3QvYWRtaW5wYW5lbF9hbHBoYWd5bV90ZXN0L3B1YmxpYy9tZW1iZXIvaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1751544656);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `testimonial_id` int NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `testimonial_content` text NOT NULL,
  `rating` tinyint UNSIGNED DEFAULT NULL COMMENT 'Đánh giá sao (1-5)',
  `member_id` int DEFAULT NULL COMMENT 'ID hội viên (FK to members.member_id, nếu là hội viên)',
  `image_url` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Đã được duyệt để hiển thị',
  `display_on_website` tinyint(1) NOT NULL DEFAULT '0',
  `submitted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`testimonial_id`, `customer_name`, `testimonial_content`, `rating`, `member_id`, `image_url`, `is_approved`, `display_on_website`, `submitted_at`, `created_at`, `updated_at`) VALUES
(11, 'Nguyễn Văn A', 'Tôi rất hài lòng với dịch vụ tại phòng gym. HLV rất tận tâm.', 5, 1, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:18'),
(12, 'Trần Thị B', 'Không gian sạch sẽ, máy móc đầy đủ. Rất đáng tiền!', 4, 2, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:19'),
(13, 'Lê Văn C', 'Giá cả hợp lý, nhiều chương trình khuyến mãi hấp dẫn.', 4, NULL, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:21'),
(14, 'Phạm Thị D', 'HLV chuyên nghiệp, hướng dẫn kỹ từng bài tập. 10 điểm.', 5, 3, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:09'),
(15, 'Ngô Minh E', 'Tôi thích không gian yên tĩnh và đầy đủ tiện nghi ở đây.', 4, 4, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:23'),
(16, 'Đỗ Hồng F', 'Ứng dụng đặt lịch tiện lợi, không phải xếp hàng.', 5, NULL, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:24'),
(17, 'Hoàng Văn G', 'Có nhiều lớp tập phù hợp mọi lứa tuổi.', 4, 5, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:29'),
(18, 'Lương Thị H', 'Trang thiết bị mới và hiện đại. Tôi rất thích.', 5, NULL, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:27'),
(19, 'Bùi Quốc I', 'Giờ mở cửa linh hoạt, phù hợp cho người đi làm.', 4, 6, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:31'),
(20, 'Võ Thị J', 'Dịch vụ massage thư giãn rất tuyệt sau khi tập luyện.', 5, 1, 'frontend/images/testimonials/maria.jpg', 1, 1, '2025-06-28 00:23:52', '2025-06-27 17:23:52', '2025-06-28 02:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `trainer_profiles`
--

CREATE TABLE `trainer_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `member_id` int NOT NULL,
  `photo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialty` enum('Tăng cơ','Giảm cân','Yoga','Vật lý trị liệu','Dinh dưỡng thể hình','Calisthenics','Chạy bộ & Sức bền') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tăng cơ',
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `certifications` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_years` int UNSIGNED NOT NULL DEFAULT '0',
  `facebook_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainer_profiles`
--

INSERT INTO `trainer_profiles` (`id`, `member_id`, `photo_url`, `specialty`, `bio`, `certifications`, `experience_years`, `facebook_url`, `instagram_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'frontend/images/trainers/trainer.jpg', 'Tăng cơ', 'Với 8 năm kinh nghiệm trong lĩnh vực thể hình, tôi chuyên về các chương trình tập luyện tăng cường sức mạnh và xây dựng cơ bắp tối ưu.', 'ISSA Certified Personal Trainer, NASM Certified', 8, 'https://facebook.com', 'https://instagram.com', '2025-06-28 09:47:06', '2025-06-28 09:47:06'),
(2, 2, 'frontend/images/trainers/trainer.jpg', 'Yoga', 'Là một HLV Yoga chuyên nghiệp, tôi giúp học viên tìm thấy sự cân bằng giữa cơ thể và tâm trí thông qua các bài tập asana và thiền định.', 'Yoga Alliance 200-Hour RYT', 5, 'https://facebook.com', 'https://instagram.com', '2025-06-28 09:47:06', '2025-06-28 09:47:06'),
(3, 3, 'frontend/images/trainers/trainer.jpg', 'Giảm cân', 'Chuyên gia về các chương trình giảm cân bền vững, kết hợp giữa tập luyện HIIT cường độ cao và chế độ dinh dưỡng khoa học.', 'ACE Certified Health Coach', 6, 'https://facebook.com', 'https://instagram.com', '2025-06-28 09:47:06', '2025-06-28 09:47:06'),
(4, 4, 'frontend/images/trainers/trainer.jpg', 'Calisthenics', 'Đam mê với các bài tập sử dụng trọng lượng cơ thể, tôi sẽ hướng dẫn bạn cách làm chủ các động tác như muscle-up, human flag.', 'WCO Certified Calisthenics Trainer', 4, 'https://facebook.com', 'https://instagram.com', '2025-06-28 09:47:06', '2025-06-28 09:47:06'),
(5, 5, 'frontend/images/trainers/trainer.jpg', 'Dinh dưỡng thể hình', 'Dinh dưỡng là chìa khóa của mọi thành công. Tôi cung cấp các kế hoạch ăn uống cá nhân hóa để hỗ trợ mục tiêu tăng cơ hoặc giảm mỡ của bạn.', 'Precision Nutrition Level 1', 7, 'https://facebook.com', 'https://instagram.com', '2025-06-28 09:47:06', '2025-06-28 09:47:06'),
(6, 6, 'frontend/images/trainers/trainer.jpg', 'Chạy bộ & Sức bền', 'Giúp bạn cải thiện thành tích chạy bộ, tăng sức bền tim mạch và chuẩn bị cho các cuộc thi marathon.', 'RRCA Certified Running Coach', 5, 'https://facebook.com', 'https://instagram.com', '2025-06-28 09:47:06', '2025-06-28 09:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `trial_registrations`
--

CREATE TABLE `trial_registrations` (
  `registration_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `preferred_contact_method` enum('phone','email') DEFAULT 'phone',
  `message` text,
  `registration_source` varchar(50) DEFAULT 'website',
  `status` enum('pending','contacted','scheduled','completed','cancelled') NOT NULL DEFAULT 'pending',
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `registered_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `contacted_at` datetime DEFAULT NULL,
  `trial_date` datetime DEFAULT NULL,
  `notes_staff` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nguyễn Đình Kha', 'admin', '$2y$12$YKQQdOMudknreu7jiyP1YuU4L2mh6BkJR2ueVNl.MJwiVBWXzLDQS', 'admin', NULL, '2025-05-19 05:03:50', '2025-05-19 05:03:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_knowledge_base`
--
ALTER TABLE `ai_knowledge_base`
  ADD PRIMARY KEY (`kb_id`),
  ADD KEY `idx_intent_name` (`intent_name`),
  ADD KEY `idx_category` (`category`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD UNIQUE KEY `slug_unique` (`slug`),
  ADD KEY `user_id_fk` (`user_id`),
  ADD KEY `article_category_id_fk` (`article_category_id`);

--
-- Indexes for table `article_categories`
--
ALTER TABLE `article_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `slug_unique` (`slug`),
  ADD KEY `parent_id_fk` (`parent_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `checkins`
--
ALTER TABLE `checkins`
  ADD PRIMARY KEY (`checkin_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `communication_logs`
--
ALTER TABLE `communication_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `rfid_card_id` (`rfid_card_id`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `membersubscriptions`
--
ALTER TABLE `membersubscriptions`
  ADD PRIMARY KEY (`subscription_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `plan_id` (`plan_id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `subscription_id` (`subscription_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`testimonial_id`),
  ADD KEY `member_id_fk` (`member_id`);

--
-- Indexes for table `trainer_profiles`
--
ALTER TABLE `trainer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trainer_profiles_member_id_unique` (`member_id`);

--
-- Indexes for table `trial_registrations`
--
ALTER TABLE `trial_registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `staff_id_fk` (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_knowledge_base`
--
ALTER TABLE `ai_knowledge_base`
  MODIFY `kb_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_categories`
--
ALTER TABLE `article_categories`
  MODIFY `category_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkins`
--
ALTER TABLE `checkins`
  MODIFY `checkin_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `communication_logs`
--
ALTER TABLE `communication_logs`
  MODIFY `log_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `template_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `plan_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membersubscriptions`
--
ALTER TABLE `membersubscriptions`
  MODIFY `subscription_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `testimonial_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainer_profiles`
--
ALTER TABLE `trainer_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trial_registrations`
--
ALTER TABLE `trial_registrations`
  MODIFY `registration_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`article_category_id`) REFERENCES `article_categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `article_categories`
--
ALTER TABLE `article_categories`
  ADD CONSTRAINT `article_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `article_categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `checkins`
--
ALTER TABLE `checkins`
  ADD CONSTRAINT `checkins_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `membersubscriptions`
--
ALTER TABLE `membersubscriptions`
  ADD CONSTRAINT `membersubscriptions_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `membersubscriptions_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `membership_plans` (`plan_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`subscription_id`) REFERENCES `membersubscriptions` (`subscription_id`);

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE SET NULL;

--
-- Constraints for table `trainer_profiles`
--
ALTER TABLE `trainer_profiles`
  ADD CONSTRAINT `trainer_profiles_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE;

--
-- Constraints for table `trial_registrations`
--
ALTER TABLE `trial_registrations`
  ADD CONSTRAINT `trial_registrations_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
