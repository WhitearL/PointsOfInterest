<?php

     // Script for adding a POI to the database. Uses class/DAO/POIDAO.php.
     // class/POI.php is used as a data entity.

     session_start();

     $POIName    = $_POST['POIName'];
     $POIType    = $_POST['POIType'];
     $POICountry = $_POST['POICountry'];
     $POIRegion  = $_POST['POIRegion'];
     $POILat     = $_POST['POILat'];
     $POILong    = $_POST['POILong'];
     $POIDesc    = $_POST['POIDesc'];
     $CSRF = $_POST['CSRF'];

     echo $POIName;
     echo $POIType;
     echo $POICountry;
     echo $POIRegion;
     echo $POILat;
     echo $POILong;
     echo $POIDesc;
     echo $CSRF;
?>
