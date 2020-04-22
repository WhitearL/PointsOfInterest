<?php

     require_once("../../class/POI.php");

     /*
          Convert a POI object into a JSON string that JS can read.
     */
     function poi_to_json(POI $poi) {
          $typecastedPOI = (array) $poi;
          $JSON = json_encode($typecastedPOI);

          // Clean up the resulting JSON
          $JSON = str_replace('\\u0000', "", $JSON); // Remove nul chars
          $JSON = str_replace('POI', "", $JSON); // Remove POI strings it added during typecast

          return $JSON;
     }

?>
