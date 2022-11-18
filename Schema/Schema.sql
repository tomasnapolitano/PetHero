CREATE DATABASE PetHero;

USE PetHero;

CREATE TABLE petSpecies
(
    speciesId INT NOT NULL AUTO_INCREMENT,
    speciesName VARCHAR(30) NOT NULL,
    description VARCHAR(50),

    CONSTRAINT pk_species_id PRIMARY KEY (speciesId),
    CONSTRAINT unq_species_name UNIQUE (speciesName)
)Engine=InnoDB;

CREATE TABLE userRole
(
    roleId INT NOT NULL AUTO_INCREMENT,
    roleName VARCHAR(30) NOT NULL,
    description VARCHAR(50),

    CONSTRAINT pk_role_id PRIMARY KEY (roleId),
    CONSTRAINT unq_role_name UNIQUE (roleName)
)Engine=InnoDB;

CREATE TABLE daysOfWeek
(
	dayOfWeekId INT NOT NULL auto_increment,
    dayName VARCHAR(15),
    
    constraint pk_daysOfWeek primary key (dayOfWeekId)
)Engine=InnoDB;

CREATE TABLE owner
(
    ownerId INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    userName VARCHAR(50) NOT NULL,
    password VARCHAR(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    avatar VARCHAR(30),
    userRole INT NOT NULL, 
    
    -- keeperInfoId int default null,
	is_keeper boolean default 0,

    CONSTRAINT pk_owner_id PRIMARY KEY (ownerId),
    CONSTRAINT unq_email UNIQUE (email),
    CONSTRAINT unq_userName UNIQUE (userName),
    CONSTRAINT fk_owner_user_role foreign key (userRole) REFERENCES userRole(roleId)
    -- CONSTRAINT fk_keeper_info foreign key (keeperInfoId) REFERENCES keeperInfo(keeperInfoId)
)Engine=InnoDB;

CREATE TABLE keeperInfo
(
	keeperInfoId INT NOT NULL auto_increment,
    ownerId INT NOT NULL,
	petSize VARCHAR(30) NOT NULL,
    price FLOAT NOT NULL,
    -- availability:
    startDate DATE NOT NULL,
    endDate DATE,
    
    constraint pk_keeperInfo primary key (keeperInfoId),
    constraint fk_keeperInfo_owner_id foreign key (ownerId) references owner(ownerId)
)Engine=InnoDB;

CREATE TABLE keeperInfoXdaysOfWeek
(
	kiXdowId int not null auto_increment,
    keeperInfoId int not null,
    dayOfWeekId int not null,

	constraint pk_kiXdow primary key (kiXdowId),
    constraint fk_ki_id foreign key (keeperInfoId) references keeperInfo(keeperInfoId),
    constraint fk_dow_id foreign key (dayOfWeekId) references daysOfWeek(dayOfWeekId)
)Engine=InnoDB;


CREATE TABLE pet 
(
    petId INT NOT NULL AUTO_INCREMENT,
    ownerId INT NOT NULL,
    name VARCHAR(30) NOT NULL,
    picture VARCHAR(50) DEFAULT NULL,
    petSpecies INT NOT NULL,
    video VARCHAR(50) DEFAULT NULL,
    breed VARCHAR(30) DEFAULT NULL,
    size VARCHAR(30) NOT NULL,
    vacPlan VARCHAR(50) DEFAULT NULL,
    vacObs VARCHAR(50) DEFAULT NULL,

    CONSTRAINT pk_pet_id PRIMARY KEY (petId),
    CONSTRAINT fk_pet_owner_id foreign key (ownerId) REFERENCES owner(ownerId)
)Engine=InnoDB;

CREATE TABLE date
(
    dateId INT NOT NULL AUTO_INCREMENT,
    date date NOT NULL,
    status BOOLEAN DEFAULT NULL,
    keeperId INT NOT NULL, 
    petSpecies INT NOT NULL,

    CONSTRAINT pk_date_id PRIMARY KEY (dateId),
    CONSTRAINT fk_date_keeper_id foreign key (keeperId) REFERENCES owner(ownerId),
    CONSTRAINT fk_date_pet_species foreign key (petSpecies) REFERENCES petSpecies(speciesId)
)Engine=InnoDB;


CREATE TABLE reservation 
(
    reservationId INT NOT NULL AUTO_INCREMENT,
    ownerId INT NOT NULL,
    keeperId INT NOT NULL,
    petId INT NOT NULL,
    dateId date,
    amount FLOAT NOT NULL,
    isAccepted BOOLEAN DEFAULT NULL,

    CONSTRAINT pk_reservation_id PRIMARY KEY (reservationId),    -- (ownerId, keeperId, petId, dateId),
    CONSTRAINT fk_res_owner_id foreign key (ownerId) references owner(ownerId),
    CONSTRAINT fk_res_keeper_id foreign key (keeperId) references owner(ownerId),
    CONSTRAINT fk_res_pet_id foreign key (petId) references pet(petId)
)Engine=InnoDB;


CREATE TABLE reservationXdates
(
	resXdateId int not null auto_increment,
    reservationId int not null,
    dateId int not null,
    
    constraint pk_resXdates primary key (resXdateId),
    constraint fk_resXdates_reservationId foreign key (reservationId) references reservation(reservationId),
    constraint fk_resXdates_dateId foreign key (dateId) references date(dateId)
)Engine=InnoDB;

-- drop database PetHero;