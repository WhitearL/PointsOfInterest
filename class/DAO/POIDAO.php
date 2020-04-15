<?php

	// Include the poi data entity
	require_once("../../class/POI.php");

	/*
		Data Access Object for Point of Interest objects.
		Provides a DB interface for Points of Interest.
	*/
	class POIDAO {

		// Active connection to database, passed in through constructor. Used to run queries.
		private $dbConnection;

		// Public constructor, allow instantiation.
		public function __construct($dbConnection) {
			// Initlialise attributes
			$this->dbConnection = $dbConnection;
		}

		// Add a POI to the database using the POI data entity
		public function addPOI(POI $poi) {

			// Prepared statement
			$sql = "INSERT INTO pointsofinterest (name, type, country, region, lon, lat, description, recommended, username)
			VALUES (:name, :type, :country, :region, :lon, :lat, :description, :recommended, :username);";

			// If statement was successfully prepared, then bind its params.
			if ($statement = $this->dbConnection->prepare($sql)) {

				// PDOStatement->bindParam() only allows variables to be passed in by reference, so declare before binding.
 				$name        = trim($poi->getName());
				$type        = trim($poi->getType());
				$country     = trim($poi->getCountry());
				$region      = trim($poi->getRegion());
				$longitude   = trim($poi->getLongitude());
				$latitude    = trim($poi->getLatitude());
				$description = trim($poi->getDescription());

				// Set recommendations to 0 by default
				$recommendations = 0;

				// Set username to the gatekeeper var-- this is set to the username on login.
				$username        = trim($_SESSION['gatekeeper']);

				// Bind object properties to the prepared statement as parameters, trimming user input.
				$statement->bindParam(":name",        $name,            PDO::PARAM_STR);
				$statement->bindParam(":type",        $type,            PDO::PARAM_STR);
				$statement->bindParam(":country",     $country,         PDO::PARAM_STR);
				$statement->bindParam(":region",      $region,          PDO::PARAM_STR);
				$statement->bindParam(":lon",         $longitude,       PDO::PARAM_STR);
				$statement->bindParam(":lat",         $latitude,        PDO::PARAM_STR);
				$statement->bindParam(":description", $description,     PDO::PARAM_STR);
				$statement->bindParam(":recommended", $recommendations, PDO::PARAM_INT);
				$statement->bindParam(":username",    $username,        PDO::PARAM_STR);
			}

			// Execute the statement and return the boolean result.
			return $statement->execute();
		}

		public function removePOI(POI $poi) {

		}

	}
?>
