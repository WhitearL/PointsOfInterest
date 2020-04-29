<?php

     // Take in an opcode from the request, generate a CSRF token, and return it with the opcode.

     // Start the session
     session_start();

     // Check the gatekeeper session variable. If it isnt present, the CSRF isnt generated and the operations cannot run.
     if (isset($_SESSION["gatekeeper"])) {

          // Opcode to send back, indicating the operation that needs a CSRF token to run
          $opCode = htmlentities($_POST['opCode']);

          // Generate CSRF token.
          $_SESSION['CSRF'] = bin2hex(random_bytes(32));

          // Return a csv line of the opcode and the CSRF token.
          echo $opCode . "," . $_SESSION['CSRF'];

     } else {
        // Bad username
        ?>

          <!-- Redirect to the gatekeeper page if session is invalid. -->
          <!-- A bad gatekeeper var is an urgent cracking attempt, get the user out. -->
          <script> window.location.replace("../../error_pages/gatekeeper.php") </script>

        <?php
     }

?>
