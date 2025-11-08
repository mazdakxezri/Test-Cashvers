-- ========================================
-- STEP-BY-STEP MIGRATIONS (Run in phpMyAdmin)
-- Copy each section ONE AT A TIME and execute
-- ========================================

-- ========================================
-- STEP 1: Create achievements table
-- ========================================

CREATE TABLE IF NOT EXISTS `achievements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `badge_image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `tier` varchar(255) NOT NULL DEFAULT 'bronze',
  `points` int(11) NOT NULL DEFAULT 10,
  `reward_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `requirements` json DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_hidden` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `achievements_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- STEP 2: Create user_achievements table (without foreign keys first)
-- ========================================

CREATE TABLE IF NOT EXISTS `user_achievements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `achievement_id` bigint(20) UNSIGNED NOT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `is_unlocked` tinyint(1) NOT NULL DEFAULT 0,
  `unlocked_at` timestamp NULL DEFAULT NULL,
  `is_claimed` tinyint(1) NOT NULL DEFAULT 0,
  `claimed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_achievements_user_achievement_unique` (`user_id`,`achievement_id`),
  KEY `user_achievements_user_id_foreign` (`user_id`),
  KEY `user_achievements_achievement_id_foreign` (`achievement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- STEP 3: Add achievement_points to users table
-- ========================================

ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `achievement_points` int(11) NOT NULL DEFAULT 0 AFTER `level`;

-- ========================================
-- STEP 4: Create events table
-- ========================================

CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `banner_color` varchar(255) NOT NULL DEFAULT '#00B8D4',
  `bonus_multiplier` decimal(4,2) NOT NULL DEFAULT 1.00,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `show_banner` tinyint(1) NOT NULL DEFAULT 1,
  `send_notification` tinyint(1) NOT NULL DEFAULT 0,
  `priority` int(11) NOT NULL DEFAULT 0,
  `target_users` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- STEP 5: Create push_subscriptions table (without foreign key first)
-- ========================================

CREATE TABLE IF NOT EXISTS `push_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `endpoint` varchar(500) NOT NULL,
  `public_key` text NOT NULL,
  `auth_token` text NOT NULL,
  `content_encoding` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  KEY `push_subscriptions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- STEP 6: Seed default achievements (OPTIONAL - can skip if you want to create manually)
-- ========================================

INSERT INTO `achievements` (`key`, `name`, `description`, `icon`, `category`, `tier`, `points`, `reward_amount`, `requirements`, `order`, `is_active`) VALUES
('first_offer', 'First Steps', 'Complete your first offer', '🎯', 'earning', 'bronze', 10, 0.10, '{"type":"offers_completed","count":1}', 0, 1),
('offers_10', 'Getting Started', 'Complete 10 offers', '🚀', 'earning', 'bronze', 25, 0.25, '{"type":"offers_completed","count":10}', 1, 1),
('offers_50', 'Dedicated Earner', 'Complete 50 offers', '💪', 'earning', 'silver', 50, 0.50, '{"type":"offers_completed","count":50}', 2, 1),
('offers_100', 'Centurion', 'Complete 100 offers', '🏆', 'earning', 'gold', 100, 1.00, '{"type":"offers_completed","count":100}', 3, 1),
('offers_500', 'Offer Master', 'Complete 500 offers', '👑', 'earning', 'platinum', 250, 2.50, '{"type":"offers_completed","count":500}', 4, 1),
('offers_1000', 'Legend', 'Complete 1000 offers', '⭐', 'earning', 'diamond', 500, 5.00, '{"type":"offers_completed","count":1000}', 5, 1),
('earned_1', 'First Dollar', 'Earn your first $1', '💵', 'milestone', 'bronze', 10, 0.10, '{"type":"total_earned","count":1}', 10, 1),
('earned_10', 'Dime Bag', 'Earn $10 in total', '💰', 'milestone', 'silver', 30, 0.25, '{"type":"total_earned","count":10}', 11, 1),
('earned_50', 'Half Century', 'Earn $50 in total', '💎', 'milestone', 'gold', 75, 0.50, '{"type":"total_earned","count":50}', 12, 1),
('earned_100', 'Benjamin', 'Earn $100 in total', '🤑', 'milestone', 'platinum', 150, 1.00, '{"type":"total_earned","count":100}', 13, 1),
('earned_500', 'High Roller', 'Earn $500 in total', '💸', 'milestone', 'diamond', 300, 2.50, '{"type":"total_earned","count":500}', 14, 1),
('daily_streak_7', 'Week Warrior', 'Login for 7 days in a row', '🔥', 'social', 'bronze', 20, 0.20, '{"type":"daily_streak","count":7}', 20, 1),
('daily_streak_30', 'Monthly Master', 'Login for 30 days in a row', '🌟', 'social', 'silver', 50, 0.50, '{"type":"daily_streak","count":30}', 21, 1),
('daily_streak_90', 'Unstoppable', 'Login for 90 days in a row', '💫', 'social', 'gold', 150, 1.50, '{"type":"daily_streak","count":90}', 22, 1),
('level_10', 'Rising Star', 'Reach Level 10', '🌠', 'milestone', 'bronze', 25, 0.25, '{"type":"level_reached","count":10}', 30, 1),
('level_20', 'Elite Member', 'Reach Level 20', '👔', 'milestone', 'silver', 50, 0.50, '{"type":"level_reached","count":20}', 31, 1),
('level_25', 'VIP Status', 'Reach Level 25 (Max)', '👑', 'milestone', 'diamond', 250, 2.50, '{"type":"level_reached","count":25}', 32, 1),
('first_withdrawal', 'Cashout King', 'Make your first withdrawal', '💳', 'special', 'gold', 50, 0.50, '{"type":"withdrawals_completed","count":1}', 40, 1),
('referral_1', 'Recruiter', 'Refer your first user', '🤝', 'social', 'bronze', 20, 0.25, '{"type":"referrals","count":1}', 50, 1),
('referral_10', 'Influencer', 'Refer 10 users', '📢', 'social', 'silver', 100, 1.00, '{"type":"referrals","count":10}', 51, 1)
ON DUPLICATE KEY UPDATE `key`=`key`;

-- ========================================
-- DONE! All tables created successfully
-- ========================================

