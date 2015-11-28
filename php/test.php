<?php
$servername = "localhost";
    $username = "phpuser1";
    $password = "*97BAD3C7F42787ED6270EE7BE634F59E64C23DF2";
    $dbname = "studyr";

    // Create connection
    $conn = new mysqli($servername, $username, $password,$dbname);

	//Load test data into DB
	try{
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password) VALUES ('Captain', 'America', 'ca@e.com', '11');");
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password) VALUES ('Black', 'Widow', 'bw@e.com', '12');");
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password) VALUES ('Green', 'Verde', 'gv@e.com', '13');");
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password) VALUES ('Blue', 'Azul', 'ba@e.com', '14');");
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password) VALUES ('Bruce', 'Banner', 'bb@e.com', '15');");
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password) VALUES ('Tony', 'Stark', 'ts@e.com', '16');");
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password) VALUES ('Red', 'Rojo', 'rr@e.com', '17');");
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password) VALUES ('Thor', 'Odinson', 'to@e.com', '18');");

	} catch (Exception $e){
		die($e->errorMessage());
	}

	try{
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Snow', 'White');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Prince', 'Charming');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Evil', 'Queen');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Wendy', 'Darling');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Peter', 'Pan');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Donald', 'Duck');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Mickey', 'Mouse');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Minnie', 'Mouse');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Baloo', 'Bear');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Captain', 'Hook');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Cheshire', 'Cat');");
	$conn->query("INSERT INTO professors (fname, lname) VALUES ('Daisy', 'Duck');");
	} catch (Exception $e){
		die($e->errorMessage());
	}

	try{
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (96456, 'ASTR', 'Particle Astrophysics', 5);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (95138, 'CHME', 'Energy, Entropy, & Equilibirum', 10);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (98523, 'CHME', 'Transport Phenomena I', 4);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (98924, 'COMM', 'Intro to Visual Communication', 7);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (96499, 'CSCI', 'Intro to Algorithms', 2);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (97955, 'LANG', 'Chinese I', 6);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (95307, 'MATH', 'Intro to Differential Equations', 9);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (95097, 'PSYC', 'General Psychology', 11);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (95018, 'MGMT', 'Intro to Management', 8);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (97984, 'BIOL', 'Intro to Biology', 1);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (97819, 'ASTR', 'Observation Astronomy', 5);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (96514, 'BIOL', 'Principles of Ecology', 1);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (99015, 'COMM', 'Digital Humanities', 7);");
	$conn->query("INSERT INTO class (crn, courseType, description, professorID) VALUES (97145, 'PSYC', 'Motivation & Performance', 11);");
	} catch (Exception $e){
		die($e->errorMessage());
	}


	//privacy = 0 is public, privacy = 1 is private
	try{
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (1, '2015-12-01 07:00:00 PM', 1, 3);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (0, '2015-12-01 09:00:00 PM', 2, 3);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (0, '2015-12-02 06:00:00 PM', 3, 1);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (0, '2015-12-03 09:00:00 PM', 4, 12);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (0, '2015-12-04 06:00:00 PM', 5, 14);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (1, '2015-12-02 10:30:00 AM', 6, 11);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (0, '2015-12-01 07:00:00 PM', 7, 7);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (1, '2015-12-05 11:00:00 AM', 8, 6);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (1, '2015-12-06 07:00:00 PM', 9, 5);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (0, '2015-11-30 06:00:00 PM', 10, 4);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (0, '2015-12-03 12:00:00 PM', 11, 4);");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID) VALUES (0, '2015-12-01 07:00:00 PM', 12, 3);");
	} catch (Exception $e){
		die($e->errorMessage());
	}

	try{
	$conn->query("INSERT INTO locations (locationName, openTime, closeTime) VALUES ('Rensselaer Student Union', '12:00:00 AM', '11:59:59 PM');");
	$conn->query("INSERT INTO locations (locationName, openTime, closeTime) VALUES ('Folsom Library', '07:30:00 AM', '03:00:00 AM');");
	} catch (Exception $e){
		die($e->errorMessage());
	}


	//repeating = 0 is not repeating, repeating = 1 is recurring
	try{
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (1,'Event1', '07:00:00 PM', '08:00:00 PM',1,1,1);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (2,'Event2', '09:00:00 PM', '10:00:00 PM',2,0,2);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (3,'Event3', '06:00:00 PM', '07:30:00 PM',1,0,3);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (4,'Event4', '09:00:00 PM', '09:30:00 PM',2,1,4);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (5,'Event5', '06:00:00 PM', '07:00:00 PM',2,1,5);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (6,'Event6', '10:30:00 AM', '12:00:00 PM',2,0,6);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (7,'Event7', '07:00:00 PM', '09:00:00 PM',1,0,7);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (8,'Event8', '11:00:00 AM', '11:30:00 AM',1,0,8);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (9,'Event9', '07:00:00 PM', '09:00:00 PM',2,0,9);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (10,'Event10', '06:00:00 PM', '07:00:00 PM',2,1,10);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (11,'Event11', '12:00:00 PM', '1:00:00 PM',1,0,11);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (12,'Event12', '07:00:00 PM', '09:00:00 PM',2,0,12);");
	} catch (Exception $e){
		die($e->errorMessage());
	}


?>