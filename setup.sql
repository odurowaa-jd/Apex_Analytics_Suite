-- Import this ONCE in phpMyAdmin (select your database first, then Import tab).
CREATE TABLE IF NOT EXISTS `monthly_data` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `month_name` VARCHAR(30) NOT NULL,
  `loans_issued` INT UNSIGNED NOT NULL,
  `repayments` INT UNSIGNED NOT NULL,
  `defaults` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Starter data (same figures as Version 1)
INSERT INTO `monthly_data` (`month_name`, `loans_issued`, `repayments`, `defaults`) VALUES
('Jan', 45000, 38000, 1200),
('Feb', 52000, 41000, 1500),
('Mar', 48000, 45000, 1100),
('Apr', 61000, 49000, 2100),
('May', 55000, 52000, 1800),
('Jun', 67000, 58000, 2300);
