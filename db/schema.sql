-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema homex
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema homex
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `homex` DEFAULT CHARACTER SET utf8 ;
USE `homex` ;

-- -----------------------------------------------------
-- Table `homex`.`homes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homex`.`homes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `home_name` VARCHAR(45) NULL DEFAULT NULL,
  `home_type` VARCHAR(45) NULL DEFAULT NULL,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  `home_owner_username` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `homex`.`payment_ack`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homex`.`payment_ack` (
  `payment_ack_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL DEFAULT NULL,
  `payment_type` VARCHAR(45) NULL DEFAULT NULL,
  `payment_amount` VARCHAR(45) NULL DEFAULT NULL,
  `remarks` VARCHAR(1000) NULL DEFAULT NULL,
  `payment_dt` DATE NULL DEFAULT NULL,
  `created_dt` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  `ack_username` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`payment_ack_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `homex`.`service_request`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homex`.`service_request` (
  `sr_id` INT NOT NULL AUTO_INCREMENT,
  `summary` VARCHAR(256) NULL DEFAULT NULL,
  `description` VARCHAR(1000) NULL DEFAULT NULL,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  `created_dt` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `closed_dt` DATETIME NULL DEFAULT NULL,
  `username` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`sr_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 39
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `homex`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homex`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NULL DEFAULT NULL,
  `password` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `admin_flag` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
