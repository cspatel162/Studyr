DROP DATABASE IF EXISTS studyr;

CREATE DATABASE studyr;

use studyr;

DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS locations CASCADE;
DROP TABLE IF EXISTS study_groups CASCADE;
DROP TABLE IF EXISTS events CASCADE;
DROP TABLE IF EXISTS class CASCADE;
DROP TABLE IF EXISTS professors CASCADE;

CREATE TABLE users (

 userID INT PRIMARY KEY AUTO_INCREMENT,
 fname VARCHAR(255)  NOT NULL,
 lname VARCHAR(255)  NOT NULL,
 email VARCHAR(255) UNIQUE NOT NULL,
 password VARCHAR(255) NOT NULL
);

CREATE TABLE professors (

 professorID INT PRIMARY KEY AUTO_INCREMENT,
 fname VARCHAR(255)  NOT NULL,
 lname VARCHAR(255)  NOT NULL
);

CREATE TABLE class (

 courseID INT PRIMARY KEY AUTO_INCREMENT,
 crn INT UNIQUE NOT NULL,
 courseType VARCHAR(6) NOT NULL,
 courseTitle VARCHAR(255) NOT NULL,
 courseNumber int NOT NULL,
 description BLOB,
 professorID INT NOT NULL,

 FOREIGN KEY (professorID) REFERENCES professors(professorID) ON DELETE CASCADE
);

CREATE TABLE study_groups (

 groupID INT PRIMARY KEY AUTO_INCREMENT,
 privacy INT NOT NULL,
 meetingTime DATETIME NOT NULL,
 founderID INT NOT NULL,
 courseID INT NOT NULL,

 FOREIGN KEY (founderID) REFERENCES users(userID) ON DELETE CASCADE,
 FOREIGN KEY (courseID) REFERENCES class(courseID) ON DELETE CASCADE
);

CREATE TABLE locations (

 locationID INT PRIMARY KEY AUTO_INCREMENT,
 locationName VARCHAR(255) NOT NULL,
 locationCity VARCHAR (255) NOT NULL,
 locationState VARCHAR (100) NOT NULL,
 openTime TIME NOT NULL,
 closeTime TIME NOT NULL

);

CREATE TABLE events (

 eventID INT PRIMARY KEY AUTO_INCREMENT,
 userID INT NOT NULL,
 eventName VARCHAR(128) NOT NULL,
 startTime DATETIME NOT NULL,
 endTime DATETIME NOT NULL,
 locationID INT NOT NULL,
 repeating INT NOT NULL,
 groupID INT,

 FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE,
 FOREIGN KEY (locationID) REFERENCES locations(locationID) ON DELETE CASCADE,
 FOREIGN KEY (groupID) REFERENCES study_groups(groupID) ON DELETE CASCADE
);

CREATE USER 'phpuser1'@'localhost' IDENTIFIED BY '*97BAD3C7F42787ED6270EE7BE634F59E64C23DF2';
GRANT ALL ON studyr.* to 'phpuser1'@'localhost';

