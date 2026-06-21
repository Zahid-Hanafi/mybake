-- PMH Application System - Database Migration
-- Run this in phpMyAdmin or MySQL CLI

-- 1. Update applications table with new columns
ALTER TABLE `applications` 
ADD COLUMN `semester` INT NOT NULL AFTER `cgpa`,
ADD COLUMN `gender` VARCHAR(10) NOT NULL AFTER `semester`,
ADD COLUMN `home_address` TEXT NOT NULL AFTER `gender`,
ADD COLUMN `relative_experience` TEXT NULL AFTER `achievement`,
ADD COLUMN `interview_slot_id` INT NULL AFTER `relative_experience`,
ADD COLUMN `rejection_reason` VARCHAR(255) NULL AFTER `status`;

-- 2. Create interview_slots table for admin-managed slots
CREATE TABLE IF NOT EXISTS `interview_slots` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `interview_date` DATE NOT NULL,
    `slot_time` VARCHAR(20) NOT NULL COMMENT '8pm-9pm or 9pm-10pm',
    `is_booked` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `modified_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `unique_date_slot` (`interview_date`, `slot_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Add foreign key for interview_slot_id
ALTER TABLE `applications`
ADD CONSTRAINT `fk_applications_interview_slots` 
FOREIGN KEY (`interview_slot_id`) REFERENCES `interview_slots`(`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;
