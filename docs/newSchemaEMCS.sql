-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema emcsdb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema emcsdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `emcsdb` DEFAULT CHARACTER SET utf8 ;
USE `emcsdb` ;

-- -----------------------------------------------------
-- Table `emcsdb`.`student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`student` (
  `studentID` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `etownID` INT NULL,
  `gradYear` INT NULL,
  `alumni` TINYINT NULL,
  `primaryMajor` VARCHAR(45) NULL,
  `otherMajors` VARCHAR(150) NULL,
  `minors` VARCHAR(200) NULL,
  `concentration` VARCHAR(65) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`studentID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`company` (
  `companyID` INT NOT NULL AUTO_INCREMENT,
  `companyName` VARCHAR(75) NOT NULL,
  `address` VARCHAR(125) NULL,
  `address2` VARCHAR(125) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `zip` INT NULL,
  `phone` VARCHAR(35) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`companyID`))
ENGINE = InnoDB
COMMENT = '	';


-- -----------------------------------------------------
-- Table `emcsdb`.`first_landings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`first_landings` (
  `first_landingsID` INT NOT NULL AUTO_INCREMENT,
  `companyID` INT NULL,
  `studentID` INT NULL,
  `title` VARCHAR(45) NOT NULL,
  `location` VARCHAR(100) NULL,
  `salary` VARCHAR(45) NULL,
  `offerDate` DATE NULL,
  `afterGraduation` VARCHAR(250) NULL,
  `emcsNetwork` TINYINT NULL,
  `internship` TINYINT NULL,
  `relationshipToMajor` VARCHAR(45) NULL,
  `matchForCarrerPath` VARCHAR(150) NULL,
  `department` VARCHAR(45) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`first_landingsID`),
  CONSTRAINT `fk_first_landings_companyID`
    FOREIGN KEY (`companyID`)
    REFERENCES `emcsdb`.`company` (`companyID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_first_landings_studentID`
    FOREIGN KEY (`studentID`)
    REFERENCES `emcsdb`.`student` (`studentID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`survey`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`survey` (
  `surveyID` INT NOT NULL AUTO_INCREMENT,
  `etownID` INT NULL,
  `interests` VARCHAR(200) NULL,
  `careerGoals` VARCHAR(500) NULL,
  PRIMARY KEY (`surveyID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`internship`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`internship` (
  `internshipID` INT NOT NULL AUTO_INCREMENT,
  `studentID` INT NULL,
  `companyID` INT NULL,
  `title` VARCHAR(75) NULL,
  `department` VARCHAR(75) NULL,
  `experientalLearning` TINYINT NULL,
  `term` VARCHAR(45) NULL,
  `sle` VARCHAR(45) NULL,
  `careerPath` VARCHAR(45) NULL,
  `mode` VARCHAR(45) NULL,
  `rating` VARCHAR(45) NULL,
  `wageRange` VARCHAR(45) NULL,
  `emcsNetwork` VARCHAR(45) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`internshipID`),
  CONSTRAINT `fk_internship_studentID`
    FOREIGN KEY (`studentID`)
    REFERENCES `emcsdb`.`student` (`studentID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_internship_companyID`
    FOREIGN KEY (`companyID`)
    REFERENCES `emcsdb`.`company` (`companyID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`contact` (
  `contactID` INT NOT NULL AUTO_INCREMENT,
  `companyID` INT NULL,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `jobTitle` VARCHAR(100) NULL,
  `contactType` VARCHAR(45) NULL,
  `email` VARCHAR(100) NULL,
  `phoneNumber` VARCHAR(35) NULL,
  `primaryContact` VARCHAR(100) NULL,
  `engagementLevel` VARCHAR(45) NULL,
  `etownPriorityPartner` VARCHAR(45) NULL,
  `companyDomain` VARCHAR(45) NULL,
  `industry` VARCHAR(45) NULL,
  `majorConcentrations` VARCHAR(110) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`contactID`),
  CONSTRAINT `fk_contact_companyID`
    FOREIGN KEY (`companyID`)
    REFERENCES `emcsdb`.`company` (`companyID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`coaching`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`coaching` (
  `coachingID` INT NOT NULL,
  `studentID` INT NULL,
  `date` DATE NULL,
  `typeOfVisit` VARCHAR(45) NULL,
  `coursework` VARCHAR(45) NULL,
  `mode` VARCHAR(45) NULL,
  `reason` VARCHAR(45) NULL,
  `positionType` VARCHAR(45) NULL,
  `followUpTasks` VARCHAR(100) NULL,
  `deadline` DATE NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`coachingID`),
  CONSTRAINT `fk_coaching_studentID`
    FOREIGN KEY (`studentID`)
    REFERENCES `emcsdb`.`student` (`studentID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`user` (
  `userID` INT NOT NULL,
  `email` VARCHAR(100) NULL,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `passwordHash` VARCHAR(128) NULL,
  `permissionLevel` INT NULL,
  PRIMARY KEY (`userID`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO user (email, firstName, lastName, passwordHash, permissionLevel) VALUES ("root@root","Root","",md5(CONCAT("SALT14PS",CONCAT("diffPass32768","PSSALT2"))),10);