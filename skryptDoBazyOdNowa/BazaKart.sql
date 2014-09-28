SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`rodzajeLinkow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`rodzajeLinkow` (
  `idrodzajeLinkow` INT NOT NULL,
  `opisCHAR` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idrodzajeLinkow`),
  UNIQUE INDEX `opisCHAR_UNIQUE` (`opisCHAR` ASC),
  UNIQUE INDEX `idrodzajeLinkow_UNIQUE` (`idrodzajeLinkow` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`linki`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`linki` (
  `idlinki` INT NOT NULL AUTO_INCREMENT,
  `sciezkaDoLokalizacji` VARCHAR(500) NOT NULL,
  `kartaID` INT NOT NULL,
  `idRodzaju` INT NOT NULL,
  `rodzajeLinkow_idrodzajeLinkow` INT NOT NULL,
  PRIMARY KEY (`idlinki`, `rodzajeLinkow_idrodzajeLinkow`),
  INDEX `poIdKarty` (`kartaID` ASC),
  INDEX `idRodzaju` (`idRodzaju` ASC),
  INDEX `fk_linki_rodzajeLinkow1_idx` (`rodzajeLinkow_idrodzajeLinkow` ASC),
  CONSTRAINT `fk_linki_rodzajeLinkow1`
    FOREIGN KEY (`rodzajeLinkow_idrodzajeLinkow`)
    REFERENCES `mydb`.`rodzajeLinkow` (`idrodzajeLinkow`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`poziomy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`poziomy` (
  `idKlienta` INT NOT NULL,
  `poziom` INT NOT NULL DEFAULT 1,
  `mnoznik` DECIMAL NOT NULL DEFAULT 1,
  PRIMARY KEY (`idKlienta`),
  INDEX `poPoziomach` (`poziom` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`nrKart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`nrKart` (
  `idnrKart` INT UNSIGNED NOT NULL,
  `nick` VARCHAR(45) NOT NULL,
  `linki_idlinki` INT NOT NULL,
  `dataDodatania` TIMESTAMP NOT NULL DEFAULT now(),
  `poziomy_idKlienta` INT NOT NULL,
  PRIMARY KEY (`idnrKart`, `linki_idlinki`, `poziomy_idKlienta`),
  UNIQUE INDEX `idnrKart_UNIQUE` (`idnrKart` ASC),
  INDEX `nickIndex` (`nick` ASC),
  INDEX `fk_nrKart_linki_idx` (`linki_idlinki` ASC),
  INDEX `fk_nrKart_poziomy1_idx` (`poziomy_idKlienta` ASC),
  CONSTRAINT `fk_nrKart_linki`
    FOREIGN KEY (`linki_idlinki`)
    REFERENCES `mydb`.`linki` (`idlinki`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_nrKart_poziomy1`
    FOREIGN KEY (`poziomy_idKlienta`)
    REFERENCES `mydb`.`poziomy` (`idKlienta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`statusy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`statusy` (
  `idStatusu` INT NOT NULL,
  `opisStatusu` VARCHAR(255) NOT NULL,
  `idRodzaju` INT NOT NULL,
  PRIMARY KEY (`idStatusu`),
  UNIQUE INDEX `idStatusu_UNIQUE` (`idStatusu` ASC),
  INDEX `indexStatusow` (`idRodzaju` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`nazwyStatusow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`nazwyStatusow` (
  `idnazwyStatusow` INT NOT NULL,
  `nazwyStatusow` VARCHAR(455) NULL,
  PRIMARY KEY (`idnazwyStatusow`),
  UNIQUE INDEX `idnazwyStatusow_UNIQUE` (`idnazwyStatusow` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`rdzajeStatusow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`rdzajeStatusow` (
  `idrdzajeStatusow` INT NOT NULL AUTO_INCREMENT,
  `typCHAR` VARCHAR(455) NOT NULL,
  `nazwyStatusow_idnazwyStatusow` INT NOT NULL,
  PRIMARY KEY (`idrdzajeStatusow`, `nazwyStatusow_idnazwyStatusow`),
  UNIQUE INDEX `typ_UNIQUE` (`typCHAR` ASC),
  INDEX `fk_rdzajeStatusow_nazwyStatusow1_idx` (`nazwyStatusow_idnazwyStatusow` ASC),
  CONSTRAINT `fk_rdzajeStatusow_nazwyStatusow1`
    FOREIGN KEY (`nazwyStatusow_idnazwyStatusow`)
    REFERENCES `mydb`.`nazwyStatusow` (`idnazwyStatusow`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`statusy_has_nrKart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`statusy_has_nrKart` (
  `statusy_idStatusu` INT NOT NULL,
  `nrKart_idnrKart` INT UNSIGNED NOT NULL,
  `nrKart_linki_idlinki` INT NOT NULL,
  `nrKart_poziomy_idKlienta` INT NOT NULL,
  PRIMARY KEY (`statusy_idStatusu`, `nrKart_idnrKart`, `nrKart_linki_idlinki`, `nrKart_poziomy_idKlienta`),
  INDEX `fk_statusy_has_nrKart_nrKart1_idx` (`nrKart_idnrKart` ASC, `nrKart_linki_idlinki` ASC, `nrKart_poziomy_idKlienta` ASC),
  INDEX `fk_statusy_has_nrKart_statusy1_idx` (`statusy_idStatusu` ASC),
  CONSTRAINT `fk_statusy_has_nrKart_statusy1`
    FOREIGN KEY (`statusy_idStatusu`)
    REFERENCES `mydb`.`statusy` (`idStatusu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_statusy_has_nrKart_nrKart1`
    FOREIGN KEY (`nrKart_idnrKart` , `nrKart_linki_idlinki` , `nrKart_poziomy_idKlienta`)
    REFERENCES `mydb`.`nrKart` (`idnrKart` , `linki_idlinki` , `poziomy_idKlienta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`statusy_has_rdzajeStatusow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`statusy_has_rdzajeStatusow` (
  `statusy_idStatusu` INT NOT NULL,
  `rdzajeStatusow_idrdzajeStatusow` INT NOT NULL,
  `rdzajeStatusow_nazwyStatusow_idnazwyStatusow` INT NOT NULL,
  PRIMARY KEY (`statusy_idStatusu`, `rdzajeStatusow_idrdzajeStatusow`, `rdzajeStatusow_nazwyStatusow_idnazwyStatusow`),
  INDEX `fk_statusy_has_rdzajeStatusow_rdzajeStatusow1_idx` (`rdzajeStatusow_idrdzajeStatusow` ASC, `rdzajeStatusow_nazwyStatusow_idnazwyStatusow` ASC),
  INDEX `fk_statusy_has_rdzajeStatusow_statusy1_idx` (`statusy_idStatusu` ASC),
  CONSTRAINT `fk_statusy_has_rdzajeStatusow_statusy1`
    FOREIGN KEY (`statusy_idStatusu`)
    REFERENCES `mydb`.`statusy` (`idStatusu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_statusy_has_rdzajeStatusow_rdzajeStatusow1`
    FOREIGN KEY (`rdzajeStatusow_idrdzajeStatusow` , `rdzajeStatusow_nazwyStatusow_idnazwyStatusow`)
    REFERENCES `mydb`.`rdzajeStatusow` (`idrdzajeStatusow` , `nazwyStatusow_idnazwyStatusow`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Loginy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Loginy` (
  `idLoginy` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `lvlOfAcces` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (`idLoginy`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
