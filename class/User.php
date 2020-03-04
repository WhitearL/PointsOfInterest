<?php

     /*
          Data entity for checking login credentials in the database.
          See class/DAO/UserDAO.php for database interface implementation.
     */
     class User
     {
         // Credentials for Points of Interest.
         private $username;
         private $password;

         // Public constructor, allow instantiation
         function __construct($username, $password)
         {
             // Initlialise attributes
             $this->username = $nameIn;
             $this->password = $password;
         }

         // Getter for username.
         function getUsername() { return $this->username; }

         // Getter for password.
         function getPassword() { return $this->password; }

     };

?>
