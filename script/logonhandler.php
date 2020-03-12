<?php
	/*
	  This script will validate and check the entered details from the login form
	  If they are correct, they will be redirected to the splash page.
	  The Gatekeeper session variable and the CSRF token are also generated upon successful login.
	*/

	/*Regular Expression constants for input validation*/
	define("USERNAME_REGEX", "#([a-z]|[A-Z]){3,15}([0-9]){3}#");
	define("PASSWORD_REGEX", "#([a-z]|[A-Z]){3,15}([0-9]){3}#");

	/*Get params from query string*/
	$inputUsername = $_GET["username"];
	$inputPassword = $_GET["password"];

	/*
	  Attempt to match the username and password to their regexes defined above
	  Sanitising the input will work to prevent SQL Injection
	*/
	if (preg_match(USERNAME_REGEX, $inputUsername) && preg_match(PASSWORD_REGEX, $inputPassword)) {
		/*Credentials are valid, check the database*/
		echo "VALID_CREDENTIAL_FORMAT";
	} else {
		/*Credentials are invalid, send an error message back*/
		echo "BAD_CREDENTIAL_FORMAT";
	}

?>
