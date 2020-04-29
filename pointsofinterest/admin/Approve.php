<?php

    require_once("../../class/DAO/POIDAO.php");

    session_start();

    if (isset($_SESSION["gatekeeper"]) && isset($_SESSION["CSRF"])) {
        
        $CSRF = $_POST['CSRF'];

        if ($CSRF == $_SESSION['CSRF']) {

            

        } else {
            echo "BAD_CSRF";
        }

    } else {
        echo "BAD_USER";
    }

?>