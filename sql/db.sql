-- create database

DROP DATABASE IF EXISTS LostAndFound;
CREATE DATABASE IF NOT EXISTS LostAndFound;
USE LostAndFound;



-- create table
DROP TABLE IF EXISTS SecurityGuardLogin;
CREATE TABLE IF NOT EXISTS SecurityGuardLogin(
    Id bigint(11) NOT NULL AUTO_INCREMENT,
    Email varchar(50) UNIQUE NOT NULL ,
    password varchar(255) NOT NULL DEFAULT '',
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(Id)

);

-- create table
DROP TABLE IF EXISTS StudentLogin;
CREATE TABLE IF NOT EXISTS StudentLogin(
    Id bigint(11) NOT NULL AUTO_INCREMENT,
    Email varchar(50) UNIQUE NOT NULL ,
    password varchar(255) NOT NULL DEFAULT '',
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(Id)

);
-- create table
DROP TABLE IF EXISTS LostItems;
CREATE TABLE IF NOT EXISTS LostItems(
    Id bigint(11) NOT NULL AUTO_INCREMENT,
    ItemName varchar(100) NOT NULL,
    Category varchar(50) NOT NULL,
    Description text NOT NULL,
    LocationLost varchar(100) NOT NULL,
    DateLost DATETIME DEFAULT CURRENT_TIMESTAMP,
    itemImage varchar(255) DEFAULT NULL,
    Email varchar(50) UNIQUE NOT NULL ,
    PRIMARY KEY(Id),
    FOREIGN KEY (Email) REFERENCES StudentLogin(Email) 
);
-- create table
CREATE TABLE Records (
    Id BIGINT AUTO_INCREMENT ,
    ItemName VARCHAR(100) NOT NULL,
    LocationFound VARCHAR(100) NOT NULL,
    LocationLost VARCHAR(100) NOT NULL,
    DateFound DATETIME NOT NULL,
    DateLost DATETIME NOT NULL,
    Description TEXT,
    Email VARCHAR(100) NOT NULL,
    DateClaimed DATETIME DEFAULT NULL,
    Status ENUM('Unclaimed', 'Claimed') NOT NULL DEFAULT 'Unclaimed',
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(Id),
    FOREIGN KEY (Email) REFERENCES StudentLogin(Email) 
);

