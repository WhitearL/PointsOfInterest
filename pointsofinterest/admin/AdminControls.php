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

                        /*
                            Generate a CSRF token, then run the given sensitive operation using the opCode.
                            The opCode indicates the operation to be run that needs a CSRF token.
                        */
                        function runSensitiveOperation(reviewID, opCode) {

                            // Declare to access from callback
                            var revID = reviewID;
                            var operationCode = opCode; 

                            // XML HTTP request object.
                            var httpRequest = new XMLHttpRequest();

                            var CSRFResponse = function csrfResponse(responseData) {
                                // Take the CSV response line and split on the comma.
                                var responseLine = responseData.target.responseText;

                                // CSRF.php redirects if the gatekeeper var isnt set.
                                var responseArr = responseLine.split(",");

                                // Opcode is the first element, CSRF token is the second.
                                var opCode = responseArr[0];
                                var CSRFToken = responseArr[1];

                                // Call appropriate function based on opcode.
                                switch (opCode) {
                                    case "APPROVE":
                                        approveReview(revID, CSRFToken);
                                        break;
                                    case "DELETE":
                                        deleteReview(revID, CSRFToken);
                                        break;
                                    default:
                                        break;
                                }

                            }

                            // Specify the callback function.
                            httpRequest.addEventListener("load", CSRFResponse);

                            httpRequest.open('POST', '../script/CSRF.php');

                            // Append data to form object, and send using the HTTP Request.
                            let formData = new FormData();
                            formData.append("opCode", opCode);

                            // Send the request.
                            httpRequest.send(formData);

                        }

                        // Click handler to approve review
                        function approveReview(reviewID, CSRF) {

                            // Access the review ID from the callback
                            var revID = reviewID;

                            // XML HTTP request object.
                            var httpRequest = new XMLHttpRequest();

                            var approveResponse = function approveResponseCallback(responseData) {

                                responseText = responseData.target.responseText;

                                if (responseText == "SUCCESS") {
                                    alert("You have approved review " + revID + "!");

                                    removeElement(revID);
                                } else if (resonseText == "NON-ADMIN") {
                                    alert("You cannot access this area, you must be an admin");
                                } else {
                                    alert(responseText);
                                }

                            }

                            // Specify the callback function.
                            httpRequest.addEventListener("load", approveResponse);

                            httpRequest.open('POST', 'Approve.php');

                            // Append data to form object, and send using the HTTP Request.
                            let formData = new FormData();
                            formData.append("revID", reviewID);
                            formData.append("admin", "True");
                            formData.append("CSRF", CSRF);

                            // Send the request.
                            httpRequest.send(formData);

                        }

                        function deleteReview(reviewID, CSRF) {
                            
                            // Access the review ID from the callback
                            var revID = reviewID;

                            // XML HTTP request object.
                            var httpRequest = new XMLHttpRequest();

                            var deleteResponse = function deleteResponseCallback(responseData) {

                                responseText = responseData.target.responseText;

                                if (responseText == "SUCCESS") {
                                    alert("You have deleted review " + revID + "!");

                                    removeElement(revID);
                                } else if (resonseText == "NON-ADMIN") {
                                    alert("You cannot access this area, you must be an admin");
                                } else {
                                    alert(responseText);
                                }

                            }

                            // Specify the callback function.
                            httpRequest.addEventListener("load", deleteResponse);

                            httpRequest.open('POST', 'Delete.php');

                            // Append data to form object, and send using the HTTP Request.
                            let formData = new FormData();
                            formData.append("revID", reviewID);
                            formData.append("admin", "True");
                            formData.append("CSRF", CSRF);

                            // Send the request.
                            httpRequest.send(formData);
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

                        // Give the div the specific ID, so it can be removed later if necessary.
                        echo "<div id=" . $specificContainerID . ">";
                            // Info text
                            echo "<h2 class='large'>Review ID: " . $result['id'] . ", for " . $row['name'] . ", ". $row['region'] . "</h2>";
                            echo "<h3 class='large'>" . "User's comment: ". $result['review'] . "</h3>";

                            // Approve and delete buttons. Very finnicky string ops to get both params into the method call.
                            ?>                       
                                <button class='button small' type='button' onClick='runSensitiveOperation(<?php echo $result['id'] ?>, "APPROVE")'>Approve</button>
                                <button class='button small' type='button' onClick='runSensitiveOperation(<?php echo $result['id'] ?>, "DELETE")'>Delete</button>
                                <br/>
                            <?php
                        echo "</div>";
                        echo "<br/>";
                    }

                }

            } else {

                // No results
                echo "<h2>There are no reviews to be approved.</h1>";

            }
        } catch (PDOException $e) {
            // General error reporting
            echo $e;
        }
    }

?>