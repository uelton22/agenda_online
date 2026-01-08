-- =============================================
-- Script para criar tabelas de Profissionais
-- Agenda Online - XAMPP/MariaDB
-- =============================================

USE agenda_online;

-- 1. Criar tabela de profissionais
CREATE TABLE IF NOT EXISTS `professionals` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `phone` VARCHAR(20) NULL,
    `specialty` VARCHAR(255) NULL,
    `bio` TEXT NULL,
    `color` VARCHAR(7) DEFAULT '#6366f1',
    `avatar` VARCHAR(255) NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    INDEX `professionals_email_index` (`email`),
    INDEX `professionals_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Criar tabela pivot professional_service
CREATE TABLE IF NOT EXISTS `professional_service` (
    `professional_id` BIGINT UNSIGNED NOT NULL,
    `service_id` BIGINT UNSIGNED NOT NULL,
    `price` DECIMAL(10,2) NULL,
    `duration` INT NULL,
    `available_slots` JSON NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`professional_id`, `service_id`),
    CONSTRAINT `professional_service_professional_id_foreign` 
        FOREIGN KEY (`professional_id`) REFERENCES `professionals` (`id`) ON DELETE CASCADE,
    CONSTRAINT `professional_service_service_id_foreign` 
        FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Adicionar coluna professional_id na tabela appointments (se não existir)
SET @column_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'agenda_online' 
    AND TABLE_NAME = 'appointments' 
    AND COLUMN_NAME = 'professional_id'
);

SET @sql = IF(@column_exists = 0, 
    'ALTER TABLE `appointments` ADD COLUMN `professional_id` BIGINT UNSIGNED NULL AFTER `service_id`',
    'SELECT "Column professional_id already exists"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 4. Adicionar foreign key para professional_id (se não existir)
SET @fk_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
    WHERE TABLE_SCHEMA = 'agenda_online' 
    AND TABLE_NAME = 'appointments' 
    AND CONSTRAINT_NAME = 'appointments_professional_id_foreign'
);

SET @sql = IF(@fk_exists = 0, 
    'ALTER TABLE `appointments` ADD CONSTRAINT `appointments_professional_id_foreign` FOREIGN KEY (`professional_id`) REFERENCES `professionals` (`id`) ON DELETE SET NULL',
    'SELECT "Foreign key already exists"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 5. Adicionar campos de autenticação na tabela clients (se não existirem)
SET @password_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'agenda_online' 
    AND TABLE_NAME = 'clients' 
    AND COLUMN_NAME = 'password'
);

SET @sql = IF(@password_exists = 0, 
    'ALTER TABLE `clients` ADD COLUMN `password` VARCHAR(255) NULL AFTER `email`',
    'SELECT "Column password already exists"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @remember_token_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'agenda_online' 
    AND TABLE_NAME = 'clients' 
    AND COLUMN_NAME = 'remember_token'
);

SET @sql = IF(@remember_token_exists = 0, 
    'ALTER TABLE `clients` ADD COLUMN `remember_token` VARCHAR(100) NULL AFTER `password`',
    'SELECT "Column remember_token already exists"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @email_verified_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'agenda_online' 
    AND TABLE_NAME = 'clients' 
    AND COLUMN_NAME = 'email_verified_at'
);

SET @sql = IF(@email_verified_exists = 0, 
    'ALTER TABLE `clients` ADD COLUMN `email_verified_at` TIMESTAMP NULL AFTER `remember_token`',
    'SELECT "Column email_verified_at already exists"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 6. Registrar migrations como executadas (para evitar conflitos futuros)
INSERT IGNORE INTO `migrations` (`migration`, `batch`) VALUES 
('2026_01_07_180000_add_auth_fields_to_clients_table', 99),
('2026_01_07_190000_make_user_id_nullable_in_appointments', 99),
('2026_01_07_200000_create_professionals_table', 99),
('2026_01_07_200001_create_professional_service_table', 99),
('2026_01_07_200002_add_professional_id_to_appointments', 99),
('2026_01_07_200003_add_extra_fields_to_professionals_table', 99),
('2026_01_07_200004_add_extra_fields_to_professional_service_table', 99);

SELECT 'Tabelas criadas com sucesso!' AS resultado;

