<?php
	$servername = "localhost";
    $username = "phpuser1";
    $password = "*97BAD3C7F42787ED6270EE7BE634F59E64C23DF2";
    $dbname = "studyr";

    // Create connection
    $conn = new mysqli($servername, $username, $password,$dbname);
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

	//Load test data into DB
	try{
	$passname = password_hash('11',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Captain', 'America', 'ca@rpi.edu', '$passname',1);");
	$passname = password_hash('12',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Black', 'Widow', 'bw@rpi.edu', '$passname',0);");
	$passname = password_hash('13',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Green', 'Verde', 'gv@rpi.edu', '$passname',0);");
	$passname = password_hash('14',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Blue', 'Azul', 'ba@rpi.edu', '$passname',0);");
	$passname = password_hash('15',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Bruce', 'Banner', 'bb@rpi.edu', '$passname',0);");
	$passname = password_hash('16',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Tony', 'Stark', 'ts@rpi.edu', '$passname',0);");
	$passname = password_hash('17',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Red', 'Rojo', 'rr@rpi.edu', '$passname',0);");
	$passname = password_hash('18',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Thor', 'Odinson', 'to@rpi.edu', '$passname',0);");
	$passname = password_hash('19',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Phil', 'Smith', 'ps@rpi.edu', '$passname',0);");
	$passname = password_hash('20',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Jen', 'Lee', 'jl@rpi.edu', '$passname',0);");
	$passname = password_hash('21',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('John', 'Goh', 'jg@rpi.edu', '$passname',0);");
	$passname = password_hash('22',PASSWORD_DEFAULT);
	$conn->query("INSERT INTO studyr.users (fname, lname, email, password, admin) VALUES ('Kevin', 'Shin', 'ks@rpi.edu', '$passname',0);");
	} catch (Exception $e){
		die($e->$e->getMessage());
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
		die($e->getMessage());
	}

	try{
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (96456, 'ASTR', 'Particle Astrophysics', 5, 2961);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (95138, 'CHME', 'Energy, Entropy, & Equilibirum', 10, 2020);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (98523, 'CHME', 'Transport Phenomena I', 4, 4010);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (98924, 'COMM', 'Intro to Visual Communication', 7, 2610);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (96499, 'CSCI', 'Intro to Algorithms', 2, 2300);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (97955, 'LANG', 'Chinese I', 6, 1410);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (95307, 'MATH', 'Intro to Differential Equations', 9, 2400);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (95097, 'PSYC', 'General Psychology', 11, 1200);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (95018, 'MGMT', 'Intro to Management', 8, 1100);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (97984, 'BIOL', 'Intro to Biology', 1, 1010);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (97819, 'ASTR', 'Observation Astronomy', 5, 4120);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (96514, 'BIOL', 'Principles of Ecology', 1, 4850);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (99015, 'COMM', 'Digital Humanities', 7, 2960);");
	$conn->query("INSERT INTO class (crn, courseType, courseTitle, professorID, courseNumber) VALUES (97145, 'PSYC', 'Motivation & Performance', 11, 4110);");
	} catch (Exception $e){
		die($e->getMessage());
	}


	//privacy = 0 is public, privacy = 1 is private
	try{
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (1, '2015-12-01 07:00:00 PM', 1, 3, '../json/studygroup_1.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (0, '2015-12-01 09:00:00 PM', 2, 3, '../json/studygroup_2.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (0, '2015-12-02 06:00:00 PM', 3, 1, '../json/studygroup_3.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (0, '2015-12-03 09:00:00 PM', 4, 12, '../json/studygroup_4.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (0, '2015-12-04 06:00:00 PM', 5, 14, '../json/studygroup_5.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (1, '2015-12-02 10:30:00 AM', 6, 11, '../json/studygroup_6.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (0, '2015-12-01 07:00:00 PM', 7, 7, '../json/studygroup_7.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (1, '2015-12-05 11:00:00 AM', 8, 6, '../json/studygroup_8.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (1, '2015-12-06 07:00:00 PM', 2, 5, '../json/studygroup_9.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (0, '2015-11-30 06:00:00 PM', 4, 4, '../json/studygroup_10.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (0, '2015-12-03 12:00:00 PM', 1, 4, '../json/studygroup_11.json');");
	$conn->query("INSERT INTO study_groups (privacy, meetingTime, founderID, courseID,json) VALUES (0, '2015-12-01 07:00:00 PM', 8, 3, '../json/studygroup_12.json');");
	$empty=array("links"=>array());
	$jsonstart = json_encode($empty);
	for($i=1; $i<13;$i++){
		file_put_contents("../json/studygroup_$i.json", $jsonstart);
	}
	} catch (Exception $e){
		die($e->getMessage());
	}

	try{
	$conn->query("INSERT INTO locations (locationName, openTime, closeTime, locationCity, locationState) VALUES ('Rensselaer Student Union', '12:00:00 AM', '11:59:59 PM','Troy','New York');");
	$conn->query("INSERT INTO locations (locationName, openTime, closeTime, locationCity, locationState) VALUES ('Folsom Library', '07:30:00 AM', '03:00:00 AM','Troy','New York');");

	} catch (Exception $e){
		die($e->getMessage());
	}


	//repeating = 0 is not repeating, repeating = 1 is recurring
	try{
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (1,'Event1', '2015-12-01 07:00:00 PM', '2015-12-01 08:00:00 PM',1,1,1);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (2,'Event2', '2015-12-01 09:00:00 PM', '2015-12-01 10:00:00 PM',2,0,2);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (3,'Event3', '2015-12-02 06:00:00 PM', '2015-12-02 07:30:00 PM',1,0,3);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (4,'Event4', '2015-12-03 09:00:00 PM', '2015-12-03 09:30:00 PM',2,1,4);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (5,'Event5', '2015-12-04 06:00:00 PM', '2015-12-04 07:00:00 PM',2,1,5);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (6,'Event6', '2015-12-02 10:30:00 AM', '2015-12-02 12:00:00 PM',2,0,6);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (7,'Event7', '2015-12-01 07:00:00 PM', '2015-12-01 09:00:00 PM',1,0,7);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (8,'Event8', '2015-12-05 11:00:00 AM', '2015-12-05 11:30:00 AM',1,0,8);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (9,'Event9', '2015-12-06 07:00:00 PM', '2015-12-06 09:00:00 PM',2,0,9);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (10,'Event10', '2015-11-30 06:00:00 PM', '2015-12-01 07:00:00 PM',2,1,10);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (11,'Event11', '2015-12-03 12:00:00 PM', '2015-12-03 1:00:00 PM',1,0,11);");
	$conn->query("INSERT INTO events (userID, eventName, startTime, endTime, locationID, repeating, groupID) 
				VALUES (12,'Event12', '2015-12-01 07:00:00 PM', '2015-12-01 09:00:00 PM',2,0,12);");
	} catch (Exception $e){
		die($e->getMessage());
	}


?>