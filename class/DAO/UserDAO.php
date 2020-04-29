<?php

	/*
		Data Access Object for User objects.
		Provides a DB interface for logging in.
	*/
	class UserDAO {

		// Active connection to database, passed in through constructor. Used to run queries.
		private $dbConnection;

		// Public constructor, allow instantiation.
		public function __construct($dbConnection) {
			// Initlialise attributes
			$this->dbConnection = $dbConnection;
		}

		/*
			Check if a given username/password combo is valid.

			Returns a boolean based on credential validity

			1. The SQL query will instigate a search the in database for the given username and password.
			2. It will count the number of matches it finds.
			3. It will return the number of records that match the given username and password.
			4. Only the count is returned, thereby hiding away the correct credentials from the script.
			5. If the count is 1, then the user is allowed in. Else, they are not allowed in.
	   */
		public function checkCredentials($inputUsername, $inputPassword) {
			// Prepare check statement with given user and password.
			$sql = "SELECT id, username, password FROM poi_users WHERE username = :username AND password = :password";

	   		// If statement was successfully prepared, then bind its params.
			if ($statement = $this->dbConnection->prepare($sql)){
				// Trim and set parameters for the prepared statement
				$userParam = trim($inputUsername);
				$passParam = trim($inputPassword);

				// Bind variables to the prepared statement as parameters
				$statement->bindParam(":username", $userParam, PDO::PARAM_STR);
				$statement->bindParam(":password", $passParam, PDO::PARAM_STR);

				// Execute query, with username and password as placeholders.
				if ($statement->execute()) {

					// Check the number of matches.
					if ($statement->rowCount() == 1) {
						// One match, credentials are correct.
						return True;
					}

				}

				// 0 or multiple matches, deny access.
				return False;
			}
		}
	}
?>
