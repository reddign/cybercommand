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
-- Table `emcsdb`.`student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`student` (
  `studentID` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `gender` VARCHAR(45) NULL,
  `URM` TINYINT NULL,
  `etownID` INT NULL,
  `gradYear` INT NULL,
  `alumni` TINYINT NULL,
  `firstGen` TINYINT NULL,
  `department` VARCHAR(55) NULL,
  `primaryMajor` VARCHAR(45) NULL,
  `concentration` VARCHAR(65) NULL,
  `otherMajors` VARCHAR(150) NULL,
  `minors` VARCHAR(200) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`studentID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`company` (
  `companyID` INT NOT NULL AUTO_INCREMENT,
  `companyName` VARCHAR(75) NOT NULL,
  `etown_companyID` INT NULL,
  `address` VARCHAR(125) NULL,
  `address2` VARCHAR(125) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `zip` INT NULL,
  `phone` VARCHAR(35) NULL,
  `companyDomain` VARCHAR(250) NULL,
  `majorConcentrations` VARCHAR(120) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`companyID`))
ENGINE = InnoDB
COMMENT = '	';


-- -----------------------------------------------------
-- Table `emcsdb`.`first_destination`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`first_destination` (
  `first_destinationID` INT NOT NULL AUTO_INCREMENT,
  `companyID` INT NULL,
  `studentID` INT NULL,
  `title` VARCHAR(45) NOT NULL,
  `location` VARCHAR(100) NULL,
  `salaryRange` VARCHAR(45) NULL,
  `offerDate` DATE NULL,
  `afterGraduation` VARCHAR(250) NULL,
  `emcsNetwork` TINYINT NULL,
  `internship` TINYINT NULL,
  `relationshipToMajor` INT NULL,
  `matchForCarrerPath` INT NULL,
  `department` VARCHAR(45) NULL,
  `notes` VARCHAR(500) NULL,
  PRIMARY KEY (`first_destinationID`),
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
  `workBasedLearning` VARCHAR(45) NULL,
  `term` VARCHAR(45) NULL,
  `sle` VARCHAR(45) NULL,
  `careerPath` VARCHAR(45) NULL,
  `mode` VARCHAR(45) NULL,
  `rating` INT NULL,
  `wageRange` VARCHAR(45) NULL,
  `emcsNetwork` TINYINT NULL,
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
  `alumni` TINYINT NULL,
  `jobTitle` VARCHAR(100) NULL,
  `contactType` VARCHAR(45) NULL,
  `email` VARCHAR(100) NULL,
  `phoneNumber` VARCHAR(35) NULL,
  `primaryContact` TINYINT NULL,
  `engagementLevel` VARCHAR(45) NULL,
  `etownPriorityPartner` TINYINT NULL,
  `companyDomain` VARCHAR(45) NULL,
  `industry` VARCHAR(45) NULL,
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
  `coachingID` INT NOT NULL AUTO_INCREMENT,
  `studentID` INT NULL,
  `date` DATE NULL,
  `typeOfVisit` VARCHAR(45) NULL,
  `coursework` TINYINT NULL,
  `mode` VARCHAR(45) NULL,
  `reason` VARCHAR(65) NULL,
  `positionType` VARCHAR(45) NULL,
  `followUpTasks` VARCHAR(400) NULL,
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
  `userID` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NULL,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `passwordHash` VARCHAR(128) NULL,
  `permissionLevel` INT NULL,
  PRIMARY KEY (`userID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcsdb`.`meeting`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcsdb`.`meeting` (
  `meetingID` INT NOT NULL AUTO_INCREMENT,
  `meetingType` VARCHAR(55) NULL,
  `date` DATE NULL,
  `companyID` INT NULL,
  `contactID` INT NULL,
  `etownContact` VARCHAR(90) NULL,
  `notes` VARCHAR(500) NULL,
  `tasks` VARCHAR(400) NULL,
  PRIMARY KEY (`meetingID`),
  CONSTRAINT `fk_meeting_companyID`
    FOREIGN KEY (`companyID`)
    REFERENCES `emcsdb`.`company` (`companyID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_meeting_contactID`
    FOREIGN KEY (`contactID`)
    REFERENCES `emcsdb`.`contact` (`contactID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO user (email, firstName, lastName, passwordHash, permissionLevel) VALUES ("root@root","Root","",md5(CONCAT("SALT14PS",CONCAT("diffPass32768","PSSALT2"))),10);
