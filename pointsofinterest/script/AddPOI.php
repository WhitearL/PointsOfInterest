<?php

     // Include the poi data entity and DAO
     require_once("../../class/POI.php");
     require_once("../../class/DAO/POIDAO.php");

     // Script for adding a POI to the database. Uses class/DAO/POIDAO.php.
     // class/POI.php is used as a data entity.

     // Start the session so we can access session vars.
     session_start();

     // Define operation result constants.
     define("OP_SUCCESS", "SUCCESS");
     define("OP_FAILURE", "FAILURE");

     // Check that the session vars for gatekeeper and the csrf token are present.
     if (isset($_SESSION["gatekeeper"]) && isset($_SESSION["CSRF"])) {

          // Read in the CSRF Token, encoding using htmlentities to guard against XSS
          $CSRFToken  = htmlentities($_POST['CSRF']);

          // Check the given CSRF token against the one in the session var.
          if ($_SESSION['CSRF'] == $CSRFToken) {
               // Gatekeeper and CSRF Token are valid, proceed.

               // Read in the POST data, encoding using htmlentities to guard against XSS.
               $POIName    = htmlentities($_POST['POIName']);
               $POIType    = htmlentities($_POST['POIType']);
               $POICountry = htmlentities($_POST['POICountry']);
               $POIRegion  = htmlentities($_POST['POIRegion']);
               $POILat     = htmlentities($_POST['POILat']);
               $POILong    = htmlentities($_POST['POILong']);
               $POIDesc    = htmlentities($_POST['POIDesc']);

               try {
                    // Connect to the database
                    $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

                    // Set up exception handling
                    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Create POI from params
                    $poi = new POI(
                         $POIName,
                         $POIType,
                         $POICountry,
                         $POIRegion,
                         $POILat,
                         $POILong,
                         $POIDesc
                    );

                    // Create a new DAO to access the database.
                    $poiDAO = new POIDAO($dbConnection);

                    // Add the POI to the database using the current logged in user according to the session.
                    if ($poiDAO->addPOI($poi)) {

                         // Add operation was successful.
                         echo OP_SUCCESS;

                    } else {

                         // Add operation failed
                         echo OP_FAILURE;

                    }
               } catch (PDOException $e) {
                    // General error reporting
                    echo $e;
               }

          } else {

               // Invalid CSRF token
               echo "INVALID_CSRF_TOKEN";

          }

     } else {
          // Invalid user detected.
          echo "INVALID_USER";
     }

?>
