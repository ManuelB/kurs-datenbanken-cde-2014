CREATE DATABASE kurs04;
USE kurs04;
CREATE TABLE  `kurs04`.`adressbuch` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`anrede` VARCHAR( 255 ) NULL ,
`vorname` VARCHAR( 255 ) NULL ,
`nachname` VARCHAR( 255 ) NULL ,
`geschlecht` enum('Frau','Mann') DEFAULT NULL,
`strasse` VARCHAR( 255 ) NULL ,
`postleitzahl` VARCHAR( 255 ) NULL ,
`ort` VARCHAR( 255 ) NULL ,
`land` VARCHAR( 255 ) NULL ,
`telefonnummer` VARCHAR( 255 ) NOT NULL,
INDEX(telefonnummer)
) ENGINE = INNODB;

CREATE TABLE  `kurs04`.`telefonat` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`von_telefonnummer` VARCHAR( 255 ) NOT NULL ,
`zu_telefonnummer` VARCHAR( 255 ) NOT NULL ,
`laenge` INT NOT NULL COMMENT  'Länge in Sekunden',
INDEX(von_telefonnummer),
FOREIGN KEY (von_telefonnummer)
      REFERENCES adressbuch(telefonnummer),
INDEX(zu_telefonnummer),
FOREIGN KEY (zu_telefonnummer)
      REFERENCES adressbuch(telefonnummer)
) ENGINE = INNODB;
