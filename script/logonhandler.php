<?php

	// Start session for logon handling
	session_start();
	
	// Include the user DAO for logon checks.
	include("../class/DAO/UserDAO.php");

	/*
	  This script will validate and check the entered details from the login form
	  If they are correct, they will be redirected to the splash page.
	  The Gatekeeper session variable and the CSRF token are also generated upon successful login.
	*/

	/*Regular Expression constants for input validation*/
	define("USERNAME_REGEX", "#([a-z]|[A-Z]){3,15}#");
	define("PASSWORD_REGEX", "#([a-z]|[A-Z]){3,15}([0-9]){3}#");

	// Constant strings representing success states that the logon handler uses in its responses
	define("CORRECT_CREDENTIALS", "CORRECT_CREDENTIALS");
	define("WRONG_CREDENTIALS", "WRONG_CREDENTIALS");
	define("BAD_CREDENTIAL_FORMAT", "BAD_CREDENTIAL_FORMAT");

	/*Get params from query string, encoding using htmlentities*/
	$inputUsername = htmlentities($_POST["username"]);
	$inputPassword = htmlentities($_POST["password"]);

	/*
	  Attempt to match the username and password to their regexes defined above
	  Sanitising the input will work to prevent SQL Injection
	*/
	if (preg_match(USERNAME_REGEX, $inputUsername) && preg_match(PASSWORD_REGEX, $inputPassword)) {
		/*Credentials are valid, check the database*/
		
		try {
			// Connect to the database
			$dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");
			
			// Set up exception handling
			$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			// Create a new DAO to access the database.
			$userDAO = new UserDAO($dbConnection);
			
			// Call the checkCredentials method in the DAO to check the user credentials.
			if ($userDAO->checkCredentials($inputUsername, $inputPassword)) {
			
				// Correct credentials
				echo CORRECT_CREDENTIALS;
				
				// Set gatekeeper session var.
				$_SESSION["gatekeeper"] = $inputUsername;
			
			} else {
				
				// Credentials are of a valid format, but they are wrong.
				echo WRONG_CREDENTIALS;
				
				// Destroy session if login invalid
				session_destroy();
				
			}
		} catch (PDOException $e) {
			// General error reporting
			echo $e;
			
			// Destroy session if login invalid
			session_destroy();
		}
		
	} else {
		/*Credentials are invalid, send an error message back*/
		echo BAD_CREDENTIAL_FORMAT;
		
		// Destroy session if login invalid
		session_destroy();
	}
	
?>
