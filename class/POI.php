<?php

     /*
          Data entity for representing POIs
          See class/DAO/POIDAO.php for database interface implementation.
     */
     class POI
     {
         // Class instance fields.
         private $name;
         private $type;
         private $country;
         private $region;
         private $latitude;
         private $longitude;
         private $description;

         // Public constructor, allow instantiation
         function __construct(
               $name,
               $type,
               $country,
               $region,
               $latitude,
               $longitude,
               $description
         ){
               // Initlialise attributes
               $this->name        = $name;
               $this->type        = $type;
               $this->country     = $country;
               $this->region      = $region;
               $this->latitude    = $latitude;
               $this->longitude   = $longitude;
               $this->description = $description;
         }

         // Getter/Setter for poi name.
         function getName() { return $this->name; }
         function setName($newName) { $this->name = $newName; }

         // Getter/Setter for poi type.
         function getType() { return $this->type; }
         function setType($newType) { $this->type = $newType; }

         // Getter/Setter for poi country
         function getCountry() { return $this->country; }
         function setCountry($newCountry) { $this->country = $newCountry; }

         // Getter/Setter for poi region
         function getRegion() { return $this->region; }
         function setRegion($newRegion) { $this->region = $newRegion; }

         // Getter/Setter for poi latitude
         function getLatitude() { return $this->latitude; }
         function setLatitude($newLatitude) { $this->latitude = $newLatitude; }

         // Getter/Setter for poi longitude
         function getLongitude() { return $this->longitude; }
         function setLongitude($newLongitude) { $this->longitude = $newLongitude; }

         // Getter/Setter for poi description
         function getDescription() { return $this->description; }
         function setDescription($newDescription) { $this->description = $newDescription; }

     };

?>
