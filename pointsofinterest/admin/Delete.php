<?php

    require_once("../../class/DAO/POIDAO.php");

    session_start();

    if (isset($_SESSION["gatekeeper"]) && isset($_SESSION["CSRF"])) {
        
        $CSRF = $_POST['CSRF'];

        if ($CSRF == $_SESSION['CSRF']) {

            if ($_POST['admin'] == "True") {
                $revID = $_POST['revID'];

                // Connect to the database
                $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

                // Set up exception handling
                $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Create a new DAO to access the database.
                $poiDAO = new POIDAO($dbConnection);

                $approvedState = $poiDAO->removeReview($revID);
    
                if ($approvedState) {
                    echo "SUCCESS";
                } else {
                    echo "FAILURE";
                }  
            } else {
                echo "NON-ADMIN";
            }
            
        } else {
            ?>
                <!-- Redirect to the gatekeeper page if session is invalid. -->
                <!-- A bad CSRF is an urgent cracking attempt, get the user out. -->
                <script> window.location.replace("../../error_pages/gatekeeper.php") </script>
            <?php
        }

    } else {
        ?>

            <!-- Redirect to the gatekeeper page if session is invalid. -->
            <!-- A bad gatekeeper var is an urgent cracking attempt, get the user out. -->
            <script> window.location.replace("../../error_pages/gatekeeper.php") </script>

        <?php
    }

?>