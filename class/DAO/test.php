<?php

     try {
          $host = "edward2.solent.ac.uk/phpmyadmin";
          $dbname = "assign236";
          $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",'assign236','aehaizah');
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $userdao = new UserDAO($conn, "poi_users");

          echo $userdao->checkCredentials("blah", "blah");

     } catch(PDOException $e) {
          echo "Error: $e";
     }

?>
