<?php 

    require_once("../../class/DAO/POIDAO.php");

    session_start();

    // One more security check...
    if (isset($_SESSION["gatekeeper"]) && isset($_SESSION["CSRF"])) {
    
        $CSRF = $_POST['CSRF'];

        if ($CSRF == $_SESSION['CSRF']) {

            ?>

                <html>
                    <head>
                        <title>POI Admin Controls</title>
                        <link rel="stylesheet" type="text/css" href="../../style/style.css"/>
                    </head>

                    <script type='text/javascript'>

                        // Click handler to approve review
                        function approveReview(reviewID) {
                            console.log(reviewID);
                            console.log("approve");
                        }

                        function deleteReview(reviewID) {
                            console.log(reviewID);
                            console.log("delete");

                            removeElement(reviewID);
                        }

                        // Remove a div container of a specific review ID.
                        function removeElement(elemID) {
                            document.getElementById("container" + elemID).remove();
                        }

                    </script>

                    <body>
                        <!-- Link back to main -->
                        <a href="../../pointsofinterest/splashpage">Go Back</a>

                        <h1>Outstanding reviews:</h1>

                        <?php

                            printUnapprovedReviews();

                        ?>

                    </body>
                </html>               

            <?php
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

    // Print the unapproved reviews and the buttons to interact with them.
    function printUnapprovedReviews() {
        try {
            // Connect to the database
            $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

            // Set up exception handling
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create a new DAO to access the database.
            $poiDAO = new POIDAO($dbConnection);

            $executedStatement = $poiDAO->getUnapprovedReviews();

            // If the search return results.
            if ($executedStatement->rowCount() > 0) {

                // Loop through the results
                while($row = $executedStatement->fetch(PDO::FETCH_ASSOC)) {

                    // Loop through the results
                    while($result=$executedStatement->fetch(PDO::FETCH_ASSOC)) {

                        // Get poi data from id.
                        $poiStatement = $poiDAO->getPOI($result['poi_id']);
                        $row = $poiStatement->fetch();

                        //<button class="button" type="button" onClick="sidebarHandler('ADMIN_CONTROL')">Admin Controls</button>
                        // Print the unapproved reviews
                        
                        // Create a unique div per review, that JS can use to remove the divs when the reviews are deleted or approved.
                        $stringID = strval($result['id']);
                        $specificContainerID = "'container" . $stringID . "'";
                        echo $specificContainerID;

                        // Give the div the specific ID, so it can be removed later if necessary.
                        echo "<div id=" . $specificContainerID . ">";
                            // Info text
                            echo "<h2 class='large'>Review ID: " . $result['id'] . ", for " . $row['name'] . ", ". $row['region'] . "</h2>";
                            echo "<h3 class='large'>" . "User's comment: ". $result['review'] . "</h3>";

                            // Approve and delete buttons
                            echo "<button class='button small' type='button' onClick='approveReview(" . $result['id'] . ")'>Approve</button>";
                            echo "<button class='button small' type='button' onClick='deleteReview(" . $result['id'] . ")'>Delete</button> <br/>";
                        echo "</div>";

                        echo "<br/>";
                    }

                }

            } else {

                 // No results
                 echo "NO_RESULTS";

            }
       } catch (PDOException $e) {
            // General error reporting
            echo $e;
       }
    }

?>