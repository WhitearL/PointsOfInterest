<?php 

	// Include the user DAO for logon checks.
	require_once("../../class/DAO/UserDAO.php");

    session_start();

    // Security check for admin access,

    if (isset($_SESSION["gatekeeper"]) && isset($_SESSION["CSRF"])) {
    
        $CSRF = $_POST['CSRF'];

        if ($CSRF == $_SESSION['CSRF']) {

            try {
                // Connect to the database
                $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

                // Set up exception handling
                $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Create a new DAO to access the database.
                $userDAO = new UserDAO($dbConnection);

                // Call the checkCredentials method in the DAO to check the user credentials.
                if ($userDAO->isUserAdmin($_SESSION['gatekeeper'])) {

                    // Correct credentials, allow access
                    echo "ADMIN_OK";

                } else {

                    // User isnt admin, return to main and give warning.
                    echo "NON-ADMIN_USER";

                }
            } catch (PDOException $e) {
                echo $e;
            }

        } else {
            // Bad csrf token
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