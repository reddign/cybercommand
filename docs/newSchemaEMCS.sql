-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema emcsdb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `emcsdb` ;

-- -----------------------------------------------------
-- Schema emcsdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `emcsdb` DEFAULT CHARACTER SET utf8 ;
USE `emcsdb` ;

-- -----------------------------------------------------
-- Table `emcsdb`.`company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`company` (
  `companyID` INT NOT NULL AUTO_INCREMENT,
  `companyName` VARCHAR(45) NOT NULL,
  `address` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `zip` VARCHAR(45) NULL,
  `phone` VARCHAR(45) NULL,
  PRIMARY KEY (`companyID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`first_landings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`first_landings` (
  `first_landingsID` INT NOT NULL AUTO_INCREMENT,
  `companyID` INT NOT NULL,
  `location` VARCHAR(45) NULL,
  `salary` VARCHAR(45) NULL,
  `offerDate` VARCHAR(45) NULL,
  `internship` VARCHAR(45) NULL,
  `carrerPath` VARCHAR(45) NULL,
  `emcsNetwork` VARCHAR(45) NULL,
  `afterGraduation` VARCHAR(45) NULL,
  PRIMARY KEY (`first_landingsID`),
  INDEX `companyID_idx` (`companyID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`student` (
  `studentID` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `gradYear` VARCHAR(45) NOT NULL,
  `alumni` VARCHAR(45) NULL,
  `primaryMajor` VARCHAR(45) NULL,
  `otherMajors` VARCHAR(45) NULL,
  `minors` VARCHAR(45) NULL,
  `concentration` VARCHAR(45) NULL,
  `first_landingsID` INT NOT NULL,
  PRIMARY KEY (`studentID`),
  INDEX `fk_student_first_landings1_idx` (`first_landingsID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`student_survey`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`student_survey` (
  `surveyID` INT NOT NULL AUTO_INCREMENT,
  `studentID` INT NOT NULL,
  `interests` VARCHAR(45) NULL,
  `careerGoals` VARCHAR(45) NULL,
  PRIMARY KEY (`surveyID`),
  INDEX `fk_student_survey_student_idx` (`studentID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`internship`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`internship` (
  `internshipID` INT NOT NULL AUTO_INCREMENT,
  `studentID` INT NULL,
  `department` VARCHAR(45) NULL,
  `primanyMajor` VARCHAR(45) NULL,
  `experimentalLearning` VARCHAR(45) NULL,
  `term` VARCHAR(45) NULL,
  `company` VARCHAR(45) NULL,
  `positionOfStudy` VARCHAR(45) NULL,
  `sle` VARCHAR(45) NULL,
  `careerPath` VARCHAR(45) NULL,
  `mode` VARCHAR(45) NULL,
  `rating` VARCHAR(45) NULL,
  `wageRange` VARCHAR(45) NULL,
  `emcsNetwork` VARCHAR(45) NULL,
  `internshipcol` VARCHAR(45) NULL,
  PRIMARY KEY (`internshipID`),
  INDEX `studentID_idx` (`studentID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`contact` (
  `contactID` INT NOT NULL AUTO_INCREMENT,
  `companyID` INT NULL,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `jobTitle` VARCHAR(45) NULL,
  `contactType` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `phoneNumber` VARCHAR(45) NULL,
  `primaryContact` VARCHAR(45) NULL,
  PRIMARY KEY (`contactID`),
  INDEX `companyID_idx` (`companyID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`coaching`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`coaching` (
  `coachingID` INT NOT NULL,
  `studentID` INT NOT NULL,
  `date` DATE NULL,
  `typeOfVisit` VARCHAR(45) NULL,
  `coursework` VARCHAR(45) NULL,
  `mode` VARCHAR(45) NULL,
  `reason` VARCHAR(45) NULL,
  `positionType` VARCHAR(45) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`coachingID`),
  INDEX `fk_coaching_student1_idx` (`studentID` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
