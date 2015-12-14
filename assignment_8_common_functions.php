<?php

	function getServer() {
		$server = $_SERVER['SERVER_NAME'];

		$positionFound = strpos($server, 'profperry');

		if ($positionFound === false) {
			$server = 'localhost';
		} else {
			$server = 'Practice Area';
		}

		print "<p>SERVER: $server</p>";
	}

	function getBooklist() {

		$keyword = $_POST['keyword'];

		if ($keyword == "") {
			$keyword = "ALL";
		}

		if ($keyword == "ALL") {
			print "<h3>Current Titles</h3>";

			$sql_statement = "SELECT title, type, pubdate, isbn ";
			$sql_statement .= "FROM book ";
			$sql_statement .= "ORDER BY 1,2,3 ";

		} else {

			print "<h3>Current Titles that match \"$keyword\"</h3>";

			$sql_statement = "SELECT title, type, pubdate, isbn ";
			$sql_statement .= "FROM book ";
			$sql_statement .= "WHERE title LIKE '%".$keyword."%'";

		}

		//connect to MySQL database and set $db
		$db = connectDatabase();

		$result = mysqli_query($db, $sql_statement); //run SELECT

		$outputDisplay = "";
		$myrowcount = 0;

		//test if statement was ran (TO BE REMOVED)
		
		if (!$result) {
			print "<p>Select statement was not run</p>";
		} else {
			print "<p>Select statement was run</p>";
		

			//test if number of rows is correct (TO BE REMOVED)
			$numresults = mysqli_num_rows($result);
			//print "<p>Number of results: ".$numresults."</p>";
		}

		for ($i = 0; $i < $numresults; $i++) {

			//$myrowcount++;

			$row = mysqli_fetch_array($result); //gets a row from resulting table
			$rownum = $i + 1;

			$title = $row['title'];
			$type = $row['type'];
			$pubdate = $row['pubdate'];
			$isbn = $row['isbn'];

			$outputDisplay .= "<p>".$rownum.". ".$title."<br/>";
			$outputDisplay .= "Category: ".$type."<br/>";
			$outputDisplay .= "Publication Date: ".$pubdate."<br/>";
			$outputDisplay .= "ISBN: ".$isbn."<br/></p>";
		}
		print $outputDisplay;
	}

	function populateCityList() {

		//* Connect to MySQL and Database *//
		$db = connectDatabase();

		//check if connected to MySQL (TO BE REMOVED)
		
		if (!$db) {
			print "<h1>Unable to Connect to MySQL</h1>";
		} else {
			print "<h1>Connected to MySQL</h1>";
		}

		// SELECT from city table
		$sql_statement = "SELECT name ";
		$sql_statement .= "FROM city ";

		$result = mysqli_query($db, $sql_statement);
		$numresults = mysqli_num_rows($result);

		for ($i = 0; $i < $numresults; $i++) {

			$row = mysqli_fetch_array($result); //gets a row from resulting table

			//prints city name into option tag
			$cityname = $row['name'];
			print "<option value='".$cityname."'>".$cityname."</option>\n";
		}
	}

	function checkUserId() {

		/*******************************************
		Check if User Id exists
		*******************************************/
		$userIdErrors = false;

		$userid = $_POST['userid'];

		//TO BE REMOVED
		print "<p>function checkUserID run</p>";

		/*
		//connect to MySQL (TO BE REMOVED)
		$db = connectDatabase();

		//check if connected to MySQL (TO BE REMOVED)
		if (!$db) {
			print "<p>Unable to Connect to MySQL</p>";
		} else {
			print "<p>Connected to MySQL</p>";
		}
		*/

		//build select statement
		$check_id_statement = "SELECT userid ";
		$check_id_statement .= "FROM patron ";
		$check_id_statement .= "WHERE userid = '".$userid."' ";

		//runs select statement
		$result = mysqli_query($db, $check_id_statement);

		//view select statement
		//print "<p>select statement: ".$sql_statement."</p>";

		if (!$result) {
			//to be removed
			print "<p>SQL statement to check user id not run</p>";
		} else {

			//remove later			
			print "<p>SQL statement to check user id run</p>";
			print "<p>Check Id Statement: ".$check_id_statement."</p>";

			$numresults = mysqli_num_rows($result);

			if ($numresults > 0) {
				$userIdErrors = true;
				print "<p>User name already exists</p>";
			}
		}
		return $userIdErrors;
		/********************************************/

	}

	function doValidation() {

		/***************************************************/
		//connect to MySQL
		$db = connectDatabase();

		//check if connected to MySQL (TO BE REMOVED)
		
		if (!$db) {
			print "<p>Unable to Connect to MySQL</p>";
		} else {
			print "<p>Connected to MySQL</p>";
		}
		/***************************************************/

		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$birthyear = $_POST['birthyear'];
		$length_of_year = strlen($birthyear);
		$userid = $_POST['userid'];
		$password = $_POST['password'];
		$errors = false;

		$currentyear = date('Y');
		$age = $currentyear - $birthyear;

		$city = $_POST['city'];

		$errmsg = "";

		if (empty($firstname)) {
			$errmsg .= "You must enter a first name.<br/>";
			$errors = true;
		}

		if (empty($lastname)) {
			$errmsg .= "You must enter a last name.<br/>";
			$errors = true;
		}

		if (empty($email)) {
			$errmsg .= "You must enter your email.<br/>";
			$errors = true;
		}

		if (empty($birthyear)) {
			$errmsg .= "You must enter your birth year.<br/>";
			$errors = true;
		} else {
			if (!is_numeric($birthyear)) {
				$errmsg .= "You must enter a numeric birth year.<br/>";
				$errors = true;
			} else {
				if ($birthyear < 0) {
						$errmsg .= "Your birth year cannot be a negative number.<br/>";
						$errors = true;
				} else {
					if ($length_of_year != 4) {
					$errmsg .= "You must enter a 4 digit birth year.<br/>";
					$errors = true;
					}
				}
			}
		}

		if ($city == "-") {
			$errmsg .= "You must choose a city.<br/>";
			$errors = true;
		}

		if (empty($userid)) {
			$errmsg .= "You must enter a user ID.<br/>";
			$errors = true;
		}

		if (empty($password)) {
			$errmsg .= "You must enter a password.<br/>";
			$errors = true;
		}		

		/***********************************************************************/
		//CHECK IF USER ID EXISTS

		//TO BE REMOVED
		//print "<p>function checkUserID run</p>";

		//build select statement
		$check_id_statement = "SELECT userid ";
		$check_id_statement .= "FROM patron ";
		$check_id_statement .= "WHERE userid = '".$userid."' ";

		//runs select statement
		$result = mysqli_query($db, $check_id_statement);

		//view select statement
		//print "<p>select statement: ".$sql_statement."</p>";

		if ($result) {

			$numresults = mysqli_num_rows($result);

			if ($numresults > 0) {
				$errmsg .= "The user name chosen already exists. Please pick another username.<br/>";
				$errors = true;
			}
		} else {
			print "<p>The select statement to check user id not run</p>";
		}	

		/************************************************************************/

		/*
		if (checkUserId()) {
			$errmsg .= "The User Id chosen already exists. Please choose a different User Id.<br/>";
			$errors = true;
		}
		*/

		if ($errors == true) {
			$errmsg .= "<p>Go BACK and make corrections.</p>";
		} else {
			$errmsg .= "<p>Thank you for registering!</p>";
			$errmsg .= "<p>Name: $firstname $lastname</p>";
			$errmsg .= "<p>User ID: $userid</p>";
			$errmsg .= "<p>Password: $password</p>";
			$errmsg .= "<p>Email: $email</p>";
			$errmsg .= "<p>City: $city</p>";
			if ($age < 16) {
				$errmsg .= "<p>Section: Children</p>";
			} elseif ($age >= 16 && $age < 54) {
				$errmsg .= "<p>Section: Adult</p>";
			} else {
				$errmsg .= "<p>Section: Senior</p>";
			}

			/****************************************************/
			//ADD PATRON
			$add_pat_statement = "insert into patron (lastname, firstname, email, birthyear, city, userid, password) ";
			$add_pat_statement .= "values (";
			$add_pat_statement .= "'".$lastname."', '".$firstname."', '".$email."', '".$birthyear."', '".$city."', '".$userid."', '".$password."'";
			$add_pat_statement .= ") ";
			
			$result = mysqli_query($db, $add_pat_statement);
			//$result = mysqli_query($add_pat_statement);

			//check if sql statement ran (TO BE REMOVED)
			if (!$result) {
				print "<p>SQL statement to add patron not run</p>";
			} else {
				print "<p>SQL statement to add patron run</p>";
			}
			
			//view the insert statement
			/*
			print "<p> insert statement: ".$add_pat_statement."</p>";
			*/
			/*****************************************************/
		}

		print "<p>$errmsg</p>";

	}



	function addPatron() {

		//grab variables from form
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$birthyear = $_POST['birthyear'];
		$city = $_POST['city'];
		$userid = $_POST['userid'];
		$password = $_POST['password'];

		//test to see if variables carry over (TO BE REMOVED)
		/*
		print "<p>values gathered from form: $lastname, $firstname, $email, $birthyear, $city</p>";
		*/

		$add_pat_statement = "insert into patron (lastname, firstname, email, birthyear, city, userid, password) ";
		$add_pat_statement .= "values (";
		$add_pat_statement .= "'".$lastname."', '".$firstname."', '".$email."', '".$birthyear."', '".$city."', '".$userid."', '".$password."'";
		$add_pat_statement .= ") ";
		
		$result = mysqli_query($db, $add_pat_statement);
		//$result = mysqli_query($add_pat_statement);

		//check if sql statement ran (TO BE REMOVED)
		if (!$result) {
			print "<p>SQL statement to add patron not run</p>";
		} else {
			print "<p>SQL statement to add patron run</p>";
		}
		

		//view the insert statement
		/*
		print "<p> insert statement: ".$add_pat_statement."</p>";
		*/

	}

	function viewPatron() {

		//connect to MySQL
		$db = connectDatabase();

		//check if MySQL connection established
		if (!$db) {
			print "<p>Unable to Connect to MySQL</p>";
		} else {
			print "<p>Connected to MySQL</p>";
		}

		//compile select statement
		$sql_statement = "SELECT lastname, firstname, email, birthyear, city, userid, password ";
		$sql_statement .= "FROM patron ";
		$sql_statement .= "ORDER BY patron_id, 1, 2, 3, 4, 5, 6, 7";

		//runs select statement
		$result = mysqli_query($db, $sql_statement);

		//view select statement
		//print "<p>select statement: ".$sql_statement."</p>";

		if (!$result) {
			print "<p>SQL statement to add patron not run</p>";
		} else {

			//remove later
			
			print "<p>SQL statement to add patron run</p>";
			

			$outputDisplay = "<h2>Patrons in the Database</h2>";
			$outputDisplay .= "<table border='1'>\n
				<tr>\n
					<th>Last Name</th>\n
					<th>First Name</th>\n
					<th>Email</th>\n
					<th>Birth Year</th>\n
					<th>City</th>\n
					<th>User ID</th>\n
					<th>Password</th>\n
				</tr>\n";

			$numresults = mysqli_num_rows($result);


			for ($i = 0; $i < $numresults; $i++) {
				if (!($i % 2) == 0) {
					$outputDisplay .= "<tr style='background-color:#f5deb3;'>";
				} else {
					$outputDisplay .="<tr style='background-color: #ffffff;'>";
				}

				$row = mysqli_fetch_array($result); //gets a single row from resulting table

				$lastname = $row['lastname'];
				$firstname = $row['firstname'];
				$email = $row['email'];
				$birthyear = $row['birthyear'];
				$city = $row['city'];
				$userid = $row['userid'];
				$password = $row['password'];

				$outputDisplay .= "<td>".$lastname."</td>\n";
				$outputDisplay .= "<td>".$firstname."</td>\n";
				$outputDisplay .= "<td>".$email."</td>\n";
				$outputDisplay .= "<td>".$birthyear."</td>\n";
				$outputDisplay .= "<td>".$city."</td>\n";
				$outputDisplay .= "<td>".$userid."</td>\n";
				$outputDisplay .= "<td>".$password."</td>\n";

				$outputDisplay .= "</tr>\n";
			}

			$outputDisplay .= "</table>\n";
		}

		print $outputDisplay;
		print "<p>Number of Patrons: ".$numresults."</p>";

	}

	function validateLogon() {

		$userid = $_POST['userid'];
		$password = $_POST['password'];

		//check if user ID and password are recieved
		/*
		print "<p>user ID: ".$userid."</p>";
		print "<p>password: ".$password."</p>";
		*/

		//connect to MySQL database and set $db
		$db = connectDatabase();

		//check if MySQL connection established
		if (!$db) {
			print "<p>Unable to Connect to MySQL</p>";
		} else {
			print "<p>Connected to MySQL</p>";
		}

		//compile select statement
		$sql_statement = "SELECT firstname, lastname, email ";
		$sql_statement .= "FROM patron ";
		$sql_statement .= "WHERE userid = '".$userid."' ";
		$sql_statement .= "AND password = '".$password."' ";

		//prints out select statement
		//print "<p>select statement: ".$sql_statement."</p>";

		//run select statement
		$result = mysqli_query($db, $sql_statement);

		$outputDisplay = "";
		$myrowcount = 0;

		if (!$result) {

			//to be removed
			print "<p>SQL statement to check user id and password not run</p>";

			$outputDisplay .= "<p style='color: red;'>MySQL No: ".mysqli_errno($db)."<br>";
			$outputDisplay .= "MySQL Error: ".mysqli_error($db)."<br>";
			$outputDisplay .= "<br>SQL: ".$statement."<br>";
			$outputDisplay .= "<br>MySQL Affected Rows: ".mysqli_affected_rows($db)."</p>";

		} else {

			//to be removed
			print "<p>SQL statement to check user id and password run</p>";

			$numresults = mysqli_num_rows($result);

			if ($numresults == 0) {
				$outputDisplay = "<p>The username and/or password you have entered is invalid<br/>";
				$outputDisplay .= "System cannot log you onto the system.</p>";
				$outputDisplay .= "<p>GO BACK and try again</p>";
			} else {

				//gets a single row from resulting table
				$row = mysqli_fetch_array($result);

				$email = $row['email'];
				$firstname = $row['firstname'];
				$lastname = $row['lastname'];

				$outputDisplay = "<p>Successful Logon for Patron:</p>";
				$outputDisplay .= "<p>Name: ".$firstname." ".$lastname."<br/>";
				$outputDisplay .= "Email: ".$email."</p>";

			}

		}

		print $outputDisplay;

	}

	function connectDatabase() {
			//**********************************************
			//*
			//*  Detect Server
			//*
			//**********************************************

			$server = $_SERVER['SERVER_NAME'];

			$positionFound = strpos($server, 'profperry');

			if ($positionFound === false)
			{
				$server = 'localhost';
			} else {
				$server = 'Practice Area';
			}


			//**********************************************
			//*
			//*  Connect to MySQL and Database
			//*
			//**********************************************

			if ($server == "Practice Area")
			{
					 require('../../DBtest_pptest.php');

					 $host =  'localhost';
					 $userid =  'P31';
					 $password = '7dosql7';
					 $dbname = 'testdb';

					 $db = mysqli_perry_pconnect($host, $userid, $password, $dbname);

					 if (!$db)
					 {
						 print "<h1>Unable to Connect to MySQLi</h1>";
						 exit;
					 }

			} else {

				$db = mysqli_connect('localhost','root','', 'test');

				if (!$db)
				{
					print "<h1>Unable to Connect to MySQL</h1>";
				} else {
					print "<h1>Connected to Database</h1>";
				}
			}

			return $db;
	}

	function selectResults($db, $statement) {

		$output = "ERROR: ";
		$outputArray = array();

		$result = mysqli_query($db, $statement);

		if (!$result) {
			$output .= "<p style='color: red;'>MySQL No: ".mysqli_errno($db)."<br>";
			$output .= "MySQL Error: ".mysqli_error($db)."<br>";
			$output .= "<br>SQL: ".$statement."<br>";
			$output .= "<br>MySQL Affected Rows: ".mysqli_affected_rows($db)."</p>";

			array_push($outputArray, $output);

		} else {

			$numresults = mysqli_num_rows($result);

			array_push($outputArray, $numresults);

			for ($i = 0; $i < $numresults; $i++)
			{
				$row = mysqli_fetch_array($result);

				array_push($outputArray, $row);
			}
		}

		return $outputArray;
	}

?>