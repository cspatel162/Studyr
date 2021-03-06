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
 password VARCHAR(255) NOT NULL,
 admin INT NOT NULL
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
 json VARCHAR(255) NOT NULL,

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

/*
	levenshtein function found http://ask.webatall.com/mysql/10636_how-to-add-levenshtein-function-in-mysql.html - gives an error about a delimeter but still works
*/
DELIMITER $$
CREATE FUNCTION levenshtein( s1 VARCHAR(255), s2 VARCHAR(255) )
RETURNS INT
DETERMINISTIC
BEGIN
DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
DECLARE s1_char CHAR;
-- max strlen=255
DECLARE cv0, cv1 VARBINARY(256);
SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
IF s1 = s2 THEN
RETURN 0;
ELSEIF s1_len = 0 THEN
RETURN s2_len;
ELSEIF s2_len = 0 THEN
RETURN s1_len;
ELSE
WHILE j <= s2_len DO
SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
END WHILE;
WHILE i <= s1_len DO
SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
WHILE j <= s2_len DO
SET c = c + 1;
IF s1_char = SUBSTRING(s2, j, 1) THEN
SET cost = 0; ELSE SET cost = 1;
END IF;
SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
IF c > c_temp THEN SET c = c_temp; END IF;
SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
IF c > c_temp THEN
SET c = c_temp;
END IF;
SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
END WHILE;
SET cv1 = cv0, i = i + 1;
END WHILE;
END IF;
RETURN c;
END$$
DELIMITER ;