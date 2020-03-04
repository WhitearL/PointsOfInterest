<?php

// Include the user object-- this is an interface for it.
include("../User.php");

/*
     Data Access Object for User objects.
     Provides a DB interface for logging in.
*/
class UserDAO {

    // Users table in phpMyAdmin, passed in through constructor. Accessed to check credentials.
    private $usersTable;

    // Active connection to database, passed in through constructor. Used to run queries.
    private $dbConnection;

    // Public constructor, allow instantiation.
    public function __construct($dbConnection, $usersTable) {
        // Initlialise attributes
        $this->dbConnection = $dbConnection;
        $this->usersTable = $usersTable;
    }

    /*
          Check if a given username/password combo is valid.

        1. The SQL query will instigate a search the in database for the given username and password.
        2. It will count the number of matches it finds.
        3. It will return the number of records that match the given username and password.
        4. Only the count is returned, thereby hiding away the correct credentials from the script.
        5. If the count is 1, then the user is allowed in. Else, they are not allowed in.
   */
    public function checkCredentials($inputUsername, $inputPassword) {
         // Prepare check statement with given user and password.
         $userCheckStatement = $this->dbConnection->prepare("SELECT COUNT(*) FROM $usersTable WHERE username=? AND password=?");

         // Execute query, with username and password as placeholders.
         $userCheckStatement->execute([$inputUsername, $inputPassword]);

         // Fetch the number of matches from the statement.
         $rowMatches = $userCheckStatement->fetch();

         // Check the number of matches.
         if ($rowMatches == 1) {
              // One match, credentials are correct.
              return True;
         } else {
              // 0 or multiple matches, deny access.
              return False;
         }
    }

?>
