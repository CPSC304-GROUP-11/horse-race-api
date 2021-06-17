DROP TABLE Product_supplied;
DROP TABLE Employee_management;
DROP TABLE Supplier_managedBy;
DROP TABLE Bets_in_race;
DROP TABLE Rides_in_race;
DROP TABLE Race_heldAt;
DROP TABLE Stadium;
DROP TABLE Place_bets_on;
DROP TABLE Horse_ridden_by;
DROP TABLE Jockey_memberOf;
DROP TABLE HorseClub;
DROP TABLE Employee;
DROP TABLE Salary;
DROP TABLE Customer;
DROP TABLE Membership;
DROP TABLE Users;


CREATE TABLE Users (
    username VARCHAR(20),
    password VARCHAR(60),
    PRIMARY KEY (username));

CREATE TABLE Membership (
    memberID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    fee REAL,
    standing VARCHAR(10),
    type VARCHAR(20),
    PRIMARY KEY (memberID));

CREATE TABLE Customer (
    accountID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 2),
    name VARCHAR(20),
    balance REAL,
    address VARCHAR(50),
    memberID NUMBER,
    username VARCHAR(20) NOT NULL,
    PRIMARY KEY (accountID),
    FOREIGN KEY (memberID) REFERENCES Membership (memberID)
        ON DELETE SET NULL,
    FOREIGN KEY (username) REFERENCES Users (username)
        ON DELETE CASCADE);

CREATE TABLE Salary (
	emp_level VARCHAR(20),
	emp_type VARCHAR(20),
	salary REAL,
	PRIMARY KEY (emp_level, emp_type));

CREATE TABLE Employee (
    accountID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 2 INCREMENT BY 2),
    name VARCHAR(20),
    emp_level VARCHAR(20),
    emp_type VARCHAR(20),
    starting_date DATE,
    managed_by NUMBER,
    username VARCHAR(20) NOT NULL,
    PRIMARY KEY (accountID),
    FOREIGN KEY (managed_by) REFERENCES Employee (accountID)
        ON DELETE SET NULL,
    FOREIGN KEY (username) REFERENCES Users (username)
        ON DELETE CASCADE,
    FOREIGN KEY (emp_level, emp_type) REFERENCES Salary (emp_level, emp_type)
        ON DELETE SET NULL);

CREATE TABLE HorseClub (
	horse_club_ID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
	name VARCHAR(20),
    address VARCHAR(50),
	PRIMARY KEY (horse_club_ID));

CREATE TABLE Jockey_memberOf (
	jockeyID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
	years_of_exp INTEGER,
	name VARCHAR(20),
	horse_club_ID NUMBER NOT NULL,
	PRIMARY KEY (jockeyID),
	FOREIGN KEY (horse_club_ID) REFERENCES HorseClub (horse_club_ID)
        ON DELETE CASCADE);

CREATE TABLE Horse_ridden_by (
	horseID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
	nickname VARCHAR(20),
	odds REAL,
	breed VARCHAR(20),
	number_of_races INTEGER,
	age INTEGER,
	jockeyID NUMBER,
	PRIMARY KEY (horseID),
    FOREIGN KEY (jockeyID) REFERENCES Jockey_memberOf (jockeyID)
	    ON DELETE SET NULL);

CREATE TABLE Place_bets_on (
    betID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    horseID NUMBER NOT NULL,
    accountID NUMBER NOT NULL,
    amount REAL,
    bet_date DATE,
    bet_type VARCHAR(11),
    PRIMARY KEY (betID),
    FOREIGN KEY (horseID) REFERENCES Horse_ridden_by (horseID)
        ON DELETE CASCADE,
    FOREIGN KEY (accountID) REFERENCES Customer (accountID)
        ON DELETE CASCADE);

CREATE TABLE Stadium (
	address VARCHAR(50) PRIMARY KEY,
	name VARCHAR(50),
	capacity INTEGER);

CREATE TABLE Race_heldAt (
	raceID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
	race_type VARCHAR(20),
	race_date DATE,
	stadiumAddr VARCHAR(50) NOT NULL,
	PRIMARY KEY (raceID),
	FOREIGN KEY (stadiumAddr) REFERENCES Stadium (address)
		ON DELETE CASCADE);

CREATE TABLE Rides_in_race (
	raceID NUMBER,
	horseID NUMBER,
	rank INTEGER,
	PRIMARY KEY (raceID, horseID),
	FOREIGN KEY (raceID) REFERENCES Race_heldAt (raceID)
		ON DELETE CASCADE,
    FOREIGN KEY (horseID) REFERENCES Horse_ridden_by (horseID)
        ON DELETE CASCADE);

CREATE TABLE Bets_in_race (
	betID NUMBER PRIMARY KEY,
	raceID NUMBER NOT NULL,
	FOREIGN KEY (betID) REFERENCES Place_bets_on (betID)
		ON DELETE CASCADE,
	FOREIGN KEY (raceID) REFERENCES Race_heldAt (raceID) 
		ON DELETE CASCADE);

CREATE TABLE Supplier_managedBy (
	supplierID NUMBER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
	phoneNumber VARCHAR(13) UNIQUE,
	companyName VARCHAR(40),
	employeeID NUMBER,
	PRIMARY KEY (supplierID),
	FOREIGN KEY (employeeID) REFERENCES Employee (accountID)
		ON DELETE SET NULL);

CREATE TABLE Employee_management (
	employeeID NUMBER,
    supplierType VARCHAR(20),
	PRIMARY KEY (employeeID),
	FOREIGN KEY (employeeID) REFERENCES Employee (accountID)
		ON DELETE CASCADE);

CREATE TABLE Product_supplied (
	supplierID NUMBER,
	productName VARCHAR(20),
	cost REAL,
	quantity VARCHAR(20),
	PRIMARY KEY (supplierID, productName),
	FOREIGN KEY (supplierID ) REFERENCES Supplier_managedBy (supplierID));


INSERT INTO Users (username, password) VALUES ('jsmith123', 'password123');
INSERT INTO Users (username, password) VALUES ('dlee234', 'black34');
INSERT INTO Users (username, password) VALUES ('rfg443', 'sunny432');
INSERT INTO Users (username, password) VALUES ('highroller45', 'hywudkf');
INSERT INTO Users (username, password) VALUES ('horsebae22', 'fjusudhfjw');
INSERT INTO Users (username, password) VALUES ('bigshot1', 'ahdufhf');
INSERT INTO Users (username, password) VALUES ('bdylan2', 'dfuhsdfu');
INSERT INTO Users (username, password) VALUES ('cathy45', 'horsesarebae');
INSERT INTO Users (username, password) VALUES ('horsegirl9', 'iamhorsechamp');
INSERT INTO Users (username, password) VALUES ('ok34', 'ussr381');
INSERT INTO Users (username, password) VALUES ('c_the_great', 'i#hate%ottoman');
INSERT INTO Users (username, password) VALUES ('poorndeaf101', 'snt14sfn7snflwr');

INSERT INTO Membership (fee, standing, type) VALUES (340, 'Valid', 'Tier 1');
INSERT INTO Membership (fee, standing, type) VALUES (1500, 'Valid', 'Tier 2');
INSERT INTO Membership (fee, standing, type) VALUES (7500, 'Valid', 'Tier 3');
INSERT INTO Membership (fee, standing, type) VALUES (10000, 'Valid', 'Tier 4');
INSERT INTO Membership (fee, standing, type) VALUES (10000, 'Valid', 'Tier 4');

INSERT INTO Customer (name, balance, address, memberID, username) VALUES ('John Berger', 2000, '522 West 8th Ave, Vancouver BC, Canada', 1, 'jsmith123');
INSERT INTO Customer (name, balance, address, memberID, username) VALUES ('Don Lee', 3400, '1425 43rd Street, New York NY ,USA', 2, 'dlee234');
INSERT INTO Customer (name, balance, address, memberID, username) VALUES ('Sally Fairweather', 120000, '32 Sunshine Blvd, Toronto, ON, Canada', 3, 'rfg443');
INSERT INTO Customer (name, balance, address, memberID, username) VALUES ('Francesca Yi', 503400, '432 Park Avenue, New York NY, USA', 4, 'highroller45');
INSERT INTO Customer (name, balance, address, memberID, username) VALUES ('Greta Von Trapp', 324000, '672 West 53rd Ave, Vancouver BC, Canada', 5, 'horsebae22');

INSERT INTO Salary (emp_level, emp_type, salary) VALUES ('Staff', 'Betting Manager', 80000);
INSERT INTO Salary (emp_level, emp_type, salary) VALUES ('Staff', 'Race Analyst', 70000);
INSERT INTO Salary (emp_level, emp_type, salary) VALUES ('Staff', 'Camera Man', 70000);
INSERT INTO Salary (emp_level, emp_type, salary) VALUES ('Staff', 'Teller', 50000);
INSERT INTO Salary (emp_level, emp_type, salary) VALUES ('Executive', 'CEO', 150000);
INSERT INTO Salary (emp_level, emp_type, salary) VALUES ('Manager', 'Race Manager', 90000);
INSERT INTO Salary (emp_level, emp_type, salary) VALUES ('Manager', 'Office Manager', 90000);

INSERT INTO Employee (name, emp_level, emp_type, starting_date, managed_by, username) VALUES ('John Froyo', 'Executive', 'CEO', DATE '2017-11-14', NULL, 'bigshot1');
INSERT INTO Employee (name, emp_level, emp_type, starting_date, managed_by, username) VALUES ('Bob Dylan', 'Manager', 'Race Manager', DATE '2018-4-23', 2, 'bdylan2');
INSERT INTO Employee (name, emp_level, emp_type, starting_date, managed_by, username) VALUES ('Catherine Chu', 'Manager', 'Race Manager', DATE '2019-2-21', 2, 'cathy45');
INSERT INTO Employee (name, emp_level, emp_type, starting_date, managed_by, username) VALUES ('Priya Patel', 'Staff', 'Teller', DATE '2020-1-19', 4, 'horsegirl9');
INSERT INTO Employee (name, emp_level, emp_type, starting_date, managed_by, username) VALUES ('Olga Kalashnikov', 'Staff', 'Betting Manager', DATE '2019-2-23', 4, 'ok34');
INSERT INTO Employee (name, emp_level, emp_type, starting_date, managed_by, username) VALUES ('Ekaterina Alexeyevna', 'Staff', 'Race Analyst', DATE '2016-1-12', 6, 'c_the_great');
INSERT INTO Employee (name, emp_level, emp_type, starting_date, managed_by, username) VALUES ('Ludwig van Gogh', 'Staff', 'Camera Man', DATE '2019-8-17', 6, 'poorndeaf101');

INSERT INTO HorseClub (name, address) VALUES ('Run', '111 Pathway, Vancouver, BC, V8V8V8');
INSERT INTO HorseClub (name, address) VALUES ('Run To', '222 Pathway, Vancouver, BC, V8V8V8');
INSERT INTO HorseClub (name, address) VALUES ('Run To The', '333 Pathway, Vancouver, BC, V8V8V8');
INSERT INTO HorseClub (name, address) VALUES ('Run To The End', '444 Pathway, Vancouver, BC, V8V8V8');
INSERT INTO HorseClub (name, address) VALUES ('Win Win Win', '555 Pathway, Vancouver, BC, V8V8V8');

INSERT INTO Jockey_memberOf (years_of_exp, name, horse_club_ID) VALUES (1, 'Albert', 1);
INSERT INTO Jockey_memberOf (years_of_exp, name, horse_club_ID) VALUES (2, 'Bob', 2);
INSERT INTO Jockey_memberOf (years_of_exp, name, horse_club_ID) VALUES (3, 'Carl', 3);
INSERT INTO Jockey_memberOf (years_of_exp, name, horse_club_ID) VALUES (4, 'Don', 4);
INSERT INTO Jockey_memberOf (years_of_exp, name, horse_club_ID) VALUES (5, 'Ella', 5);

INSERT INTO Horse_ridden_by (nickname, odds, breed, number_of_races, age, jockeyID) VALUES ('Lightning', 0.9, 'Arabian', 100, 7, 1);
INSERT INTO Horse_ridden_by (nickname, odds, breed, number_of_races, age, jockeyID) VALUES ('Wind', 0.8, 'Shire', 20, 5, 2);
INSERT INTO Horse_ridden_by (nickname, odds, breed, number_of_races, age, jockeyID) VALUES ('Lightning', 0.77, 'Appaloosa', 80, 6, 2);
INSERT INTO Horse_ridden_by (nickname, odds, breed, number_of_races, age, jockeyID) VALUES ('Number One', 0.1, 'Haflinger', 999, 10, 3);
INSERT INTO Horse_ridden_by (nickname, odds, breed, number_of_races, age, jockeyID) VALUES ('Mist Walker', 1.0, 'Hackney', 1, 4, 4);
INSERT INTO Horse_ridden_by (nickname, odds, breed, number_of_races, age, jockeyID) VALUES ('Sec', 0.06, 'Barb', 123, 30, NULL);
INSERT INTO Horse_ridden_by (nickname, odds, breed, number_of_races, age, jockeyID) VALUES (NULL, 0.0, 'Lusitano', 0, 1, NULL);

INSERT INTO Place_bets_on (horseID, accountID, amount, bet_date, bet_type) VALUES (1, 1, 100.00, DATE '2014-1-23', 'win bet');
INSERT INTO Place_bets_on (horseID, accountID, amount, bet_date, bet_type) VALUES (2, 3, 200.00, DATE '2019-3-26', 'win bet');
INSERT INTO Place_bets_on (horseID, accountID, amount, bet_date, bet_type) VALUES (3, 5, 10.00, DATE '2018-4-23', 'place bet');
INSERT INTO Place_bets_on (horseID, accountID, amount, bet_date, bet_type) VALUES (4, 7, 0.10, DATE '2020-11-11', 'place bet');
INSERT INTO Place_bets_on (horseID, accountID, amount, bet_date, bet_type) VALUES (5, 9, 20.5, DATE '2000-3-6', 'show bet');
INSERT INTO Place_bets_on (horseID, accountID, amount, bet_date, bet_type) VALUES (6, 9, 80.1, DATE '2011-01-01', 'show bet');

INSERT INTO Stadium (address, name, capacity) VALUES ('4444 Victoria Ave., Vancouver', 'Royal Stadium of Vancouver', 97500);
INSERT INTO Stadium (address, name, capacity) VALUES ('828 Cornwall St., Burnaby', 'Metrotown Stadium', 100001);
INSERT INTO Stadium (address, name, capacity) VALUES ('1579 Barbarossa St., Surrey', 'Memorial Stadium', 58800);
INSERT INTO Stadium (address, name, capacity) VALUES ('7603 West Durham St., Vancouver', 'Rolls-Royce Stadium', 65000);
INSERT INTO Stadium (address, name, capacity) VALUES ('118 King Charles Ave., Burnaby', 'BMO Stadium', 73100);

INSERT INTO Race_heldAt (race_type, race_date, stadiumAddr) VALUES ('Flat racing', DATE '2018-11-26', '4444 Victoria Ave., Vancouver');
INSERT INTO Race_heldAt (race_type, race_date, stadiumAddr) VALUES ('Flat racing', DATE '2018-12-9', '828 Cornwall St., Burnaby');
INSERT INTO Race_heldAt (race_type, race_date, stadiumAddr) VALUES ('Jump racing', DATE '2017-3-13', '4444 Victoria Ave., Vancouver');
INSERT INTO Race_heldAt (race_type, race_date, stadiumAddr) VALUES ('Flat racing', DATE '2019-2-5', '828 Cornwall St., Burnaby');
INSERT INTO Race_heldAt (race_type, race_date, stadiumAddr) VALUES ('Harness racing', DATE '2018-7-14', '1579 Barbarossa St., Surrey');

INSERT INTO Rides_in_race (raceID, horseID, rank) VALUES (1, 1, 1);
INSERT INTO RIDES_IN_RACE (RACEID, HORSEID) VALUES (2, 1);
INSERT INTO RIDES_IN_RACE (RACEID, HORSEID) VALUES (3, 1);
INSERT INTO RIDES_IN_RACE (RACEID, HORSEID) VALUES (4, 1);
INSERT INTO Rides_in_race (raceID, horseID, rank) VALUES (1, 2, 2);
INSERT INTO Rides_in_race (raceID, horseID) VALUES (2, 2);
INSERT INTO Rides_in_race (raceID, horseID) VALUES (3, 3);
INSERT INTO Rides_in_race (raceID, horseID, rank) VALUES (4, 4, 1);
INSERT INTO Rides_in_race (raceID, horseID, rank) VALUES (4, 5, 1);

INSERT INTO Bets_in_race (betID, raceID) VALUES (1, 1);
INSERT INTO Bets_in_race (betID, raceID) VALUES (2, 1);
INSERT INTO Bets_in_race (betID, raceID) VALUES (3, 2);
INSERT INTO Bets_in_race (betID, raceID) VALUES (4, 3);
INSERT INTO Bets_in_race (betID, raceID) VALUES (5, 4);

INSERT INTO Supplier_managedBy (phoneNumber, companyName, employeeID) VALUES ('778-010-0101', 'Epic Horse-riding Equipment Co.', 2);
INSERT INTO Supplier_managedBy (phoneNumber, companyName, employeeID) VALUES ('778-987-6543', 'Pet Food Variety Sales', 4);
INSERT INTO Supplier_managedBy (phoneNumber, companyName, employeeID) VALUES ('604-234-2345', 'Best-Clean Company', 6);
INSERT INTO Supplier_managedBy (phoneNumber, companyName, employeeID) VALUES ('778-999-7878', 'HoHo Horse Equip', 8);
INSERT INTO Supplier_managedBy (phoneNumber, companyName, employeeID) VALUES ('604-555-7777', 'Grass is Grass', 10);

INSERT INTO Employee_management (employeeID, supplierType) VALUES (2, 'equipments');
INSERT INTO Employee_management (employeeID, supplierType) VALUES (4, 'horse food');
INSERT INTO Employee_management (employeeID, supplierType) VALUES (6, 'cleaning');
INSERT INTO Employee_management (employeeID, supplierType) VALUES (8, 'human food');
INSERT INTO Employee_management (employeeID, supplierType) VALUES (10, 'emergency');

INSERT INTO Product_supplied (supplierID, productName, cost, quantity) VALUES (1, 'Cotton saddles', 53.49, '1');
INSERT INTO Product_supplied (supplierID, productName, cost, quantity) VALUES (2, 'Riding boots', 124.99, '1');
INSERT INTO Product_supplied (supplierID, productName, cost, quantity) VALUES (3, 'Deep cleaning', 672.38, null);
INSERT INTO Product_supplied (supplierID, productName, cost, quantity) VALUES (4, 'Hay', 224.75, '2 kg');
INSERT INTO Product_supplied (supplierID, productName, cost, quantity) VALUES (5, 'Dried grass', 73.00, '500 g');

