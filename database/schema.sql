-- PetZone Database Schema
-- Run this in phpMyAdmin or MySQL CLI: source /path/to/schema.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS `petzone` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `petzone`;

-- ============================================================
-- USERS
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `ID`          INT(11)      NOT NULL AUTO_INCREMENT,
  `firstname`   VARCHAR(50)  NOT NULL,
  `lastname`    VARCHAR(50)  NOT NULL,
  `Username`    VARCHAR(50)  NOT NULL,
  `Email`       VARCHAR(100) NOT NULL,
  `password`    VARCHAR(255) NOT NULL,
  `accountType` ENUM('Admin','Employee','Client') NOT NULL DEFAULT 'Client',
  `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uq_username` (`Username`),
  UNIQUE KEY `uq_email`    (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- PETS / PATIENTS
-- ============================================================
CREATE TABLE IF NOT EXISTS `patients` (
  `ID`        INT(11)      NOT NULL AUTO_INCREMENT,
  `addedBy`   VARCHAR(50)  NOT NULL,
  `petname`   VARCHAR(50)  NOT NULL,
  `species`   VARCHAR(50)  NOT NULL,
  `breed`     VARCHAR(50)  DEFAULT NULL,
  `gender`    ENUM('Male','Female','Unknown') DEFAULT 'Unknown',
  `age`       INT(11)      NOT NULL DEFAULT 0,
  `weight`    DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `color`     VARCHAR(50)  DEFAULT NULL,
  `notes`     TEXT         DEFAULT NULL,
  `created_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `idx_addedby` (`addedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- APPOINTMENTS
-- ============================================================
CREATE TABLE IF NOT EXISTS `appointments` (
  `ID`           INT(11)       NOT NULL AUTO_INCREMENT,
  `petOwner`     VARCHAR(50)   NOT NULL,
  `EmployeeName` VARCHAR(50)   NOT NULL,
  `petname`      VARCHAR(50)   NOT NULL,
  `service_type` VARCHAR(100)  DEFAULT NULL,
  `aDate`        DATE          NOT NULL,
  `price`        DECIMAL(8,2)  NOT NULL DEFAULT 0.00,
  `status`       ENUM('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  `notes`        TEXT          DEFAULT NULL,
  `created_at`   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `idx_owner`    (`petOwner`),
  KEY `idx_employee` (`EmployeeName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- HEALTH RECORDS
-- ============================================================
CREATE TABLE IF NOT EXISTS `health_records` (
  `ID`             INT(11)      NOT NULL AUTO_INCREMENT,
  `pet_id`         INT(11)      NOT NULL,
  `petname`        VARCHAR(50)  NOT NULL,
  `addedBy`        VARCHAR(50)  NOT NULL,
  `record_type`    ENUM('Vaccination','Checkup','Surgery','Medication','Other') NOT NULL DEFAULT 'Other',
  `title`          VARCHAR(100) NOT NULL,
  `description`    TEXT         DEFAULT NULL,
  `vet_name`       VARCHAR(100) DEFAULT NULL,
  `visit_date`     DATE         NOT NULL,
  `next_visit_date` DATE        DEFAULT NULL,
  `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `idx_pet_id`  (`pet_id`),
  KEY `idx_addedby` (`addedBy`),
  CONSTRAINT `fk_hr_pet` FOREIGN KEY (`pet_id`) REFERENCES `patients`(`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- PRODUCTS (store)
-- ============================================================
CREATE TABLE IF NOT EXISTS `products` (
  `ID`          INT(11)       NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(100)  NOT NULL,
  `description` TEXT          DEFAULT NULL,
  `price`       DECIMAL(8,2)  NOT NULL DEFAULT 0.00,
  `category`    ENUM('Food','Accessories','Medicine','Toys','Other') NOT NULL DEFAULT 'Other',
  `image`       VARCHAR(255)  DEFAULT NULL,
  `stock`       INT(11)       NOT NULL DEFAULT 0,
  `created_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
