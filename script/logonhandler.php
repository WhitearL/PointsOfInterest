<?php
     /*
          This script will validate and check the entered details from the login form
          If they are correct, they will be redirected to the splash page.
          The Gatekeeper session variable and the CSRF token are also generated upon successful login.
     */

     /*Regular Expression constants for input validation*/
     define("USERNAME_REGEX", "");
     define("PASSWORD_REGEX", "");

     /*Get params from query string*/
     $inputUsername = $_GET["username"];
     $inputPassword = $_GET["password"];

     /*
          Attempt to match the username and password to their regexes defined above
          Sanitising the input will work to prevent SQL Injection
     */
     if (preg_match(USERNAME_REGEX, $inputUsername) && preg_match(PASSWORD_REGEX, $inputPassword)) {
          /*Credentials are valid, check the database*/
          echo "haha yes";
     } else {
          /*Credentials are invalid, send to a page with an error message*/
          $errorMsg = "Your details use an invalid format.</br>Are you an evil cracker?";

          /*Use JS to link to the invalid login page, passing the error message in the query string*/
          echo "<script>location.href='../error_pages/invalid_login.php?errorMsg=$errorMsg';</script>";
     }

?>
