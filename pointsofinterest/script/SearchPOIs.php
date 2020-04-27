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
     if (isset($_SESSION["gatekeeper"])) {

          // Get params from query string, using htmlentities to prevent XSS
          $searchField = trim(htmlentities($_GET['searchField']));
          $searchValue = trim(htmlentities($_GET['searchValue']));

          try {
               // Connect to the database
               $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

               // Set up exception handling
               $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               // Create a new DAO to access the database.
               $poiDAO = new POIDAO($dbConnection);

               $executedStatement = $poiDAO->searchPOIs($searchField, $searchValue);

               // If the search return results.
               if ($executedStatement->rowCount() > 0) {

                    // Loop through the results
                    while($row = $executedStatement->fetch(PDO::FETCH_ASSOC)) {

                         // Data is trusted -- Comes from database. We dont need to use htmlentities
                         $poi = new POI(
                              $row['name'],
                              $row['type'],
                              $row['country'],
                              $row['region'],
                              $row['lat'],
                              $row['lon'],
                              $row['description']
                         );
                         $poi->setID($row['ID']);

                         // Encode as JSON so JavaScript can interpret it, and write it on the response.
                         // BREAK is used by javascript to split the json string.
                         echo poi_to_json($poi) . "BREAK";
                    }

               } else {

                    // No results
                    echo "NO_RESULTS";

               }
          } catch (PDOException $e) {
               // General error reporting
               echo $e;
          }

     } else {
          // Invalid user detected.
          echo "INVALID_USER";
     }

     /*
          Convert a POI object to an accociative array of field names to their values.
               Parameter $data: Object to convert
     */
     function convertToArray($data) {
          if (is_array($data) || is_object($data)) {
               $result = array();

               foreach($data as $key => $value) {
                    $result[$key] = $this->convertToArray($value);
               }

               return $result;
          }
          return $data;
     }

?>
