-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Biblioteka
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Biblioteka
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Biblioteka` DEFAULT CHARACTER SET utf8 ;
USE `Biblioteka` ;

-- -----------------------------------------------------
-- Table `Biblioteka`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`role` (
  `role_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`role_name`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Biblioteka`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_user`),
  INDEX `fk_user_role1_idx` (`role`),
  UNIQUE INDEX `login_UNIQUE` (`login`),
  CONSTRAINT `fk_role`
    FOREIGN KEY (`role`)
    REFERENCES `Biblioteka`.`role` (`role_name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Biblioteka`.`borrower_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`borrower_info` (
  `id_borrower` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `surname` VARCHAR(50) NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `phone_number` VARCHAR(11) NOT NULL,
  `email` VARCHAR(50) NULL,
  PRIMARY KEY (`id_borrower`),
  UNIQUE INDEX `email_UNIQUE` (`email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Biblioteka`.`genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`genre` (
  `genre_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`genre_name`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Biblioteka`.`publisher`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`publisher` (
  `publisher_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`publisher_name`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Biblioteka`.`author_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`author_info` (
  `id_author` CHAR(6) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `surname` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_author`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Biblioteka`.`book_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`book_info` (
  `id_book` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `pages` INT NOT NULL,
  `author` CHAR(6) NOT NULL,
  `genre` VARCHAR(45) NOT NULL,
  `publisher` VARCHAR(100) NOT NULL,
  INDEX `fk_book_info_genre1_idx` (`genre`),
  INDEX `fk_book_info_publisher1_idx` (`publisher`),
  INDEX `fk_book_info_author_info1_idx` (`author`),
  UNIQUE INDEX `title_UNIQUE` (`title`),
  PRIMARY KEY (`id_book`),
  CONSTRAINT `fk_genre`
    FOREIGN KEY (`genre`)
    REFERENCES `Biblioteka`.`genre` (`genre_name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publisher`
    FOREIGN KEY (`publisher`)
    REFERENCES `Biblioteka`.`publisher` (`publisher_name`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_book_info_author_info1`
    FOREIGN KEY (`author`)
    REFERENCES `Biblioteka`.`author_info` (`id_author`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Biblioteka`.`book_stock`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`book_stock` (
  `book_code` INT NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `borrowed` TINYINT NOT NULL,
  PRIMARY KEY (`book_code`),
  INDEX `fk_book_stock_book_info1_idx` (`title`),
  CONSTRAINT `fk_book_info`
    FOREIGN KEY (`title`)
    REFERENCES `Biblioteka`.`book_info` (`title`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Biblioteka`.`borrowed_books`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Biblioteka`.`borrowed_books` (
  `book_code` INT NOT NULL,
  `id_borrower` INT NOT NULL,
  `borrow_date` DATE NOT NULL,
  `return_date` DATE NOT NULL,
  INDEX `fk_borrowed_books_borrower_info1_idx` (`id_borrower`),
  INDEX `fk_borrowed_books_book_stock1_idx` (`book_code`),
  CONSTRAINT `fk_id_borrowe`
    FOREIGN KEY (`id_borrower`)
    REFERENCES `Biblioteka`.`borrower_info` (`id_borrower`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_borrowed_books_book_stock1`
    FOREIGN KEY (`book_code`)
    REFERENCES `Biblioteka`.`book_stock` (`book_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
