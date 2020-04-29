<?php

     // Include the poi data entity and DAO
     require_once("../../class/POI.php");
     require_once("../../class/DAO/POIDAO.php");
     require_once("POICommonUtils.php");

     // Script for searching database for POIs. Uses class/DAO/POIDAO.php.
     // class/POI.php is used as a data entity.

     // Start the session so we can access session vars.
     session_start();


     // Check that the session vars for gatekeeper is present.
     if (isset($_SESSION["gatekeeper"]) && isset($_SESSION["CSRF"])) {

          $CSRFToken = $_POST["CSRF"];

          if ($_SESSION['CSRF'] == $CSRFToken) {
               // Get params from query string, using htmlentities to prevent XSS
               $poiID = trim(htmlentities($_POST['ID']));

               try {
                    // Connect to the database
                    $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

                    // Set up exception handling
                    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Create a new DAO to access the database.
                    $poiDAO = new POIDAO($dbConnection);

                    $executedStatement = $poiDAO->recommendPOI($poiID);

                    // If the update affected a row.
                    if ($executedStatement->rowCount() > 0) {

                         echo "SUCCESS";

                    } else {

                         // No results
                         echo "FAILURE";

                    }

               } catch (PDOException $e) {
                    // General error reporting
                    echo $e;
               }

          } else {

               ?>
                    <!-- Redirect to the gatekeeper page if session is invalid. -->
                    <!-- A bad CSRF is an urgent cracking attempt, get the user out. -->
                    <script> window.location.replace("../../error_pages/gatekeeper.php") </script>
               <?php
          }

     } else {
        // Bad username
        ?>

          <!-- Redirect to the gatekeeper page if session is invalid. -->
          <!-- A bad gatekeeper var is an urgent cracking attempt, get the user out. -->
          <script> window.location.replace("../../error_pages/gatekeeper.php") </script>

        <?php
     }

?>
