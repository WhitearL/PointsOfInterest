<?php

     // Take in an opcode from the request, generate a CSRF token, and return it with the opcode.

     // Start the session
     session_start();

     // Opcode to send back, indicating the operation that needs a CSRF token to run
     $opCode = $_POST['opCode'];

     // Check the gatekeeper session variable. If it isnt present, the CSRF isnt generated and the operations cannot run.
     if (isset($_SESSION["gatekeeper"])) {

          // Generate CSRF token.
          $_SESSION['CSRF'] = bin2hex(random_bytes(32));

          // Return a csv line of the opcode and the CSRF token.
          echo $opCode . "," . $_SESSION['CSRF'];

     } else {
          // Invalid user detected.
          echo "INVALID_USER";
     }

?>
