<?php

    // Include the poi DAO
    require_once("../../class/DAO/POIDAO.php");

    $poiID = $_GET['ID'];

    // Start the session so we can access session vars.
    session_start();

    // Check that the session vars for gatekeeper is present.
    if (isset($_SESSION["gatekeeper"])) {    ?>
        <html>

            <head>
                <title>POI: Points of Interest</title>
                <link rel="stylesheet" type="text/css" href="../../style/style.css"/>
            </head>

            <body>
                <!--Centered login form-->
                <div id="center" class="center bordered filled">
                    <!--Top bar for logo in center form-->
                    <div class="topbar">
                        <img class="topbarlogo" src="../../img/poi_logo.png"/>
                    </div>

                    
                    <?php 
                        $poiData = getPOIData($poiID);

                        // Title
                        $name = $poiData['name'];
                        $region = $poiData['region'];
                        echo "<h1>Reviews for " . $name . ", " . $region . "</h1>";

                        // Back to the splash page
                        echo "<a href='/pointsofinterest/splashpage'>Go back</a>";

                        // Display review info
                        getReviews($poiID);
                    ?>

                </div>
            </body>
        </html>

<?php
    } else {
        ?>

            <!-- Redirect to the gatekeeper page if session is invalid. -->
            <script> window.location.replace("../../error_pages/gatekeeper.php") </script>

        <?php
    }

    /**
     * Return a POIs data for a certain ID.
     */
    function getPOIData($poiID) {
        try {
            // Connect to the database
            $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

            // Set up exception handling
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create a new DAO to access the database.
            $poiDAO = new POIDAO($dbConnection);

            $executedStatement = $poiDAO->getPOI($poiID);

            return $executedStatement->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo $e;
        }
    }

    function getReviews($poiID) {
        try {
            // Connect to the database
            $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

            // Set up exception handling
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create a new DAO to access the database.
            $poiDAO = new POIDAO($dbConnection);

            $executedStatement = $poiDAO->getApprovedReviews($poiID);
            
            if ($executedStatement->rowCount() > 0) {

                // Loop through the results
                while($result=$executedStatement->fetch(PDO::FETCH_ASSOC)) {

                    echo "<h2>Review ID: " . $result['id'] . "</h2>";
                    echo "<h3>" . $result['review'] . "</h3><br/>";

                }

            }

        } catch(PDOException $e) {
            echo $e;
        }
    }

?>