CREATE DATABASE PetHero;

USE PetHero;

CREATE TABLE 'petSpecies'
(
    'speciesId' INT NOT NULL AUTO_INCREMENT,
    'speciesName' VARCHAR(30) NOT NULL,
    description VARCHAR(50),

    CONSTRAINT pk_species_id PRIMARY KEY ('speciesId'),
    CONSTRAINT unq_species_name UNIQUE ('speciesName')
);

CREATE TABLE 'userRole'
(
    'roleID' INT NOT NULL AUTO_INCREMENT,
    'roleName' VARCHAR(30) NOT NULL,
    description VARCHAR(50),

    CONSTRAINT pk_role_id PRIMARY KEY ('roleID'),
    CONSTRAINT unq_role_name UNIQUE ('roleName')
);

CREATE TABLE 'owner'
(
    'ownerID' INT NOT NULL AUTO_INCREMENT,
    'email' VARCHAR(50) NOT NULL,
    'usernName' VARCHAR(50) NOT NULL,
    'password' VARCHAR(30) NOT NULL,
    'name' VARCHAR(30) NOT NULL,
    'lastName' VARCHAR(30) NOT NULL,
    'avatar' VARCHAR(30),
    'userRole' INT NOT NULL, 


    CONSTRAINT pk_owner_id PRIMARY KEY ('ownerID'),
    CONSTRAINT unq_email UNIQUE ('email'),
--    CONSTRAINT fk_user_role 
);

CREATE TABLE 'pet' 
(
    'petID' INT NOT NULL AUTO_INCREMENT,
    'ownerID' INT NOT NULL,
    'name' VARCHAR(30) NOT NULL,
    'picture' VARCHAR(50) DEFAULT NULL,
    'petSpecies' INT NOT NULL,
    'video' VARCHAR(50) DEFAULT NULL,
    'breed' VARCHAR(30) DEFAULT NULL,
    'size' VARCHAR(30) NOT NULL,
    'vacPlan' VARCHAR(50) DEFAULT NULL,
    'vacObs' VARCHAR(50) DEFAULT NULL,

    CONSTRAINT pk_pet_id PRIMARY KEY ('petID'),
--    CONSTRAINT fk_owner_id
);

CREATE TABLE 'date'
(
    'dateID' INT NOT NULL AUTO_INCREMENT,
    'date' date NOT NULL,
    'status' BOOLEAN DEFAULT NULL,
    'keeperID' INT NOT NULL, 
    'petSpecies' INT NOT NULL,

    CONSTRAINT pk_date_id PRIMARY KEY ('dateID'),
--    CONSTRAINT fk_keeper_id
--    CONSTRAINT fk_pet_species
)


CREATE TABLE 'reservation' 
(
    'reservationID' INT NOT NULL AUTO_INCREMENT,
    'ownerID' INT NOT NULL,
    'keeperID' INT NOT NULL,
    'petID' INT NOT NULL,
    'dateID' date,
    'amount' FLOAT NOT NULL,
    'isAccepted' BOOLEAN DEFAULT NULL,

    CONSTRAINT pk_reservation_id PRIMARY KEY ('ownerID', 'keeperID', 'petID', 'dateID'),
--    CONSTRAINT fk_owner_id
--    CONSTRAINT fk_keeper_id
--    CONSTRAINT fk_pet_id
--    CONSTRAINT fk_date_id
);