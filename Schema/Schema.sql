CREATE DATABASE PetHero;

USE PetHero;

CREATE TABLE owner
(
    ownerID INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    usernName VARCHAR(50) NOT NULL,
    password VARCHAR(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    avatar VARCHAR(30),
    userRole INT NOT NULL, 


    CONSTRAINT pk_owner_id PRIMARY KEY (ownerID),
    CONSTRAINT unq_email UNIQUE (email)
);
