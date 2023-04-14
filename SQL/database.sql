CREATE DATABASE IF NOT EXISTS ProjektNumer6;


use projektnumer6;

CREATE TABLE `klienci` (
  `klient_id` integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `imie` varchar(30),
  `nazwisko` varchar(30),
  `login` varchar(20) UNIQUE NOT NULL,
  `haslo` varchar(30) NOT NULL,
  `mail` varchar(30),
  `telefon` integer(9) NOT NULL,
  `uprawnienia` integer NOT NULL,
  `dodano` CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE `lider` (
  `lider_id` integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(20) NOT NULL,
  `wiek` integer(3) NOT NULL
);

CREATE TABLE `nocleg` (
  `nocleg_id` integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) NOT NULL,
  `adres_wycieczki` varchar(90) NOT NULL
);

CREATE TABLE `organizatorzy` (
  `organizatorzy_id` integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nazwa_organizatora` varchar(50) NOT NULL,
  `adres` varchar(200) NOT NULL,
  `mail` varchar(30),
  `telefon` integer(20) NOT NULL
);

CREATE TABLE `platnosc` (
  `platnosc_id` integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `zaliczka` integer(50) NOT NULL DEFAULT 0,
  `oplacone` integer(90) NOT NULL DEFAULT 0
);

CREATE TABLE `wycieczka` (
  `wycieczka_id` integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `organizatorzy_id` integer(20) NOT NULL,
  `nocleg_id` integer(20) NOT NULL,
  `lider_id` integer(20) NOT NULL,
  `nazwa_wycieczki` varchar(200) NOT NULL,
  `cena` integer(20) NOT NULL DEFAULT 0,
  `data_od` date NOT NULL DEFAULT 0,
  `data_do` date NOT NULL DEFAULT 0
);

CREATE TABLE `zamowienia` (
  `zamowienie_id` integer PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `klient_id` integer(20) NOT NULL,
  `wycieczka_id` integer(20) NOT NULL,
  `dodano` CURRENT_TIMESTAMP DEFAULT null
);

ALTER TABLE `wycieczka` ADD FOREIGN KEY (`nocleg_id`) REFERENCES `nocleg` (`nocleg_id`);

ALTER TABLE `wycieczka` ADD FOREIGN KEY (`organizatorzy_id`) REFERENCES `organizatorzy` (`organizatorzy_id`);

ALTER TABLE `wycieczka` ADD FOREIGN KEY (`lider_id`) REFERENCES `lider` (`lider_id`);

ALTER TABLE `zamowienia` ADD FOREIGN KEY (`wycieczka_id`) REFERENCES `wycieczka` (`wycieczka_id`);

ALTER TABLE `zamowienia` ADD FOREIGN KEY (`klient_id`) REFERENCES `klienci` (`klient_id`);
