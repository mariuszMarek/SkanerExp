SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `expkarty` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `expkarty` ;

-- -----------------------------------------------------
-- Table `expkarty`.`rodzajeLinkow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`rodzajeLinkow` (
  `idrodzajeLinkow` INT NOT NULL,
  `opisCHAR` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idrodzajeLinkow`),
  UNIQUE INDEX `opisCHAR_UNIQUE` (`opisCHAR` ASC),
  UNIQUE INDEX `idrodzajeLinkow_UNIQUE` (`idrodzajeLinkow` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`linki`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`linki` (
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
    REFERENCES `expkarty`.`rodzajeLinkow` (`idrodzajeLinkow`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`poziomy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`poziomy` (
  `idKlienta` INT NOT NULL,
  `poziom` INT NOT NULL DEFAULT 1,
  `mnoznik` DECIMAL NOT NULL DEFAULT 1,
  PRIMARY KEY (`idKlienta`),
  INDEX `poPoziomach` (`poziom` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`rachunki`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`rachunki` (
  `idrachunki` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `statusRachunku` TINYINT(1) NOT NULL DEFAULT false,
  PRIMARY KEY (`idrachunki`),
  UNIQUE INDEX `idrachunki_UNIQUE` (`idrachunki` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`nrKart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`nrKart` (
  `idnrKart` INT UNSIGNED NOT NULL,
  `nick` VARCHAR(45) NOT NULL,
  `linki_idlinki` INT NOT NULL,
  `dataDodatania` TIMESTAMP NOT NULL DEFAULT now(),
  `poziomy_idKlienta` INT NOT NULL,
  `rachunki_idrachunki` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idnrKart`, `linki_idlinki`, `poziomy_idKlienta`, `rachunki_idrachunki`),
  UNIQUE INDEX `idnrKart_UNIQUE` (`idnrKart` ASC),
  INDEX `nickIndex` (`nick` ASC),
  INDEX `fk_nrKart_linki_idx` (`linki_idlinki` ASC),
  INDEX `fk_nrKart_poziomy1_idx` (`poziomy_idKlienta` ASC),
  INDEX `fk_nrKart_rachunki1_idx` (`rachunki_idrachunki` ASC),
  CONSTRAINT `fk_nrKart_linki`
    FOREIGN KEY (`linki_idlinki`)
    REFERENCES `expkarty`.`linki` (`idlinki`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_nrKart_poziomy1`
    FOREIGN KEY (`poziomy_idKlienta`)
    REFERENCES `expkarty`.`poziomy` (`idKlienta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_nrKart_rachunki1`
    FOREIGN KEY (`rachunki_idrachunki`)
    REFERENCES `expkarty`.`rachunki` (`idrachunki`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`nazwyStatusow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`nazwyStatusow` (
  `idnazwyStatusow` INT NOT NULL AUTO_INCREMENT,
  `nazwyStatusow` VARCHAR(455) NULL,
  PRIMARY KEY (`idnazwyStatusow`),
  UNIQUE INDEX `idnazwyStatusow_UNIQUE` (`idnazwyStatusow` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`Loginy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`Loginy` (
  `idLoginy` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `lvlOfAcces` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (`idLoginy`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`elementyRachunku`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`elementyRachunku` (
  `idKolejnegoElementu` INT NOT NULL AUTO_INCREMENT,
  `elementyRachunkucol` VARCHAR(45) NULL,
  `cenaElementu` VARCHAR(45) NULL,
  PRIMARY KEY (`idKolejnegoElementu`),
  UNIQUE INDEX `idKolejnegoElementu_UNIQUE` (`idKolejnegoElementu` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`rachunki_has_elementyRachunku`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`rachunki_has_elementyRachunku` (
  `idKolejnejKombinacji` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `rachunki_idrachunki` INT UNSIGNED NOT NULL,
  `elementyRachunku_idKolejnegoElementu` INT NOT NULL,
  INDEX `fk_rachunki_has_elementyRachunku_elementyRachunku1_idx` (`elementyRachunku_idKolejnegoElementu` ASC),
  INDEX `fk_rachunki_has_elementyRachunku_rachunki1_idx` (`rachunki_idrachunki` ASC),
  PRIMARY KEY (`idKolejnejKombinacji`),
  UNIQUE INDEX `idKolejnejKombinacji_UNIQUE` (`idKolejnejKombinacji` ASC),
  CONSTRAINT `fk_rachunki_has_elementyRachunku_rachunki1`
    FOREIGN KEY (`rachunki_idrachunki`)
    REFERENCES `expkarty`.`rachunki` (`idrachunki`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rachunki_has_elementyRachunku_elementyRachunku1`
    FOREIGN KEY (`elementyRachunku_idKolejnegoElementu`)
    REFERENCES `expkarty`.`elementyRachunku` (`idKolejnegoElementu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`RodzajeStatosow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`RodzajeStatosow` (
  `idRodzajeStatosow` INT NOT NULL AUTO_INCREMENT,
  `typy` VARCHAR(255) NULL,
  `nazwyStatusow_idnazwyStatusow` INT NOT NULL,
  PRIMARY KEY (`idRodzajeStatosow`, `nazwyStatusow_idnazwyStatusow`),
  INDEX `fk_RodzajeStatosow_nazwyStatusow1_idx` (`nazwyStatusow_idnazwyStatusow` ASC),
  CONSTRAINT `fk_RodzajeStatosow_nazwyStatusow1`
    FOREIGN KEY (`nazwyStatusow_idnazwyStatusow`)
    REFERENCES `expkarty`.`nazwyStatusow` (`idnazwyStatusow`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expkarty`.`nrKart_has_RodzajeStatosow`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expkarty`.`nrKart_has_RodzajeStatosow` (
  `nrKart_idnrKart` INT UNSIGNED NOT NULL,
  `RodzajeStatosow_idRodzajeStatosow` INT NOT NULL,
  PRIMARY KEY (`nrKart_idnrKart`, `RodzajeStatosow_idRodzajeStatosow`),
  INDEX `fk_nrKart_has_RodzajeStatosow_RodzajeStatosow1_idx` (`RodzajeStatosow_idRodzajeStatosow` ASC),
  INDEX `fk_nrKart_has_RodzajeStatosow_nrKart1_idx` (`nrKart_idnrKart` ASC),
  CONSTRAINT `fk_nrKart_has_RodzajeStatosow_nrKart1`
    FOREIGN KEY (`nrKart_idnrKart`)
    REFERENCES `expkarty`.`nrKart` (`idnrKart`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_nrKart_has_RodzajeStatosow_RodzajeStatosow1`
    FOREIGN KEY (`RodzajeStatosow_idRodzajeStatosow`)
    REFERENCES `expkarty`.`RodzajeStatosow` (`idRodzajeStatosow`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
