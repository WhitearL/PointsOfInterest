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

		/*
			Add a POI to the database using a POI Data Entity parameter
				Parameter $poi: POI Data Entity to be added
		*/
		public function addPOI(POI $poi) {

			// Prepared statement
			$sql = "INSERT INTO pointsofinterest (name, type, country, region, lon, lat, description, recommended, username)
			VALUES (:name, :type, :country, :region, :lon, :lat, :description, :recommended, :username);";

			// If statement was successfully prepared, then bind its params.
			if ($statement = $this->dbConnection->prepare($sql)) {

				// PDOStatement->bindParam() only allows variables to be passed in by reference, so declare before binding.
				// Parse using htmlentities to ensure no scripting can occur
 				$name        = trim(htmlentities($poi->getName()));
				$type        = trim(htmlentities($poi->getType()));
				$country     = trim(htmlentities($poi->getCountry()));
				$region      = trim(htmlentities($poi->getRegion()));
				$longitude   = trim(htmlentities($poi->getLongitude()));
				$latitude    = trim(htmlentities($poi->getLatitude()));
				$description = trim(htmlentities($poi->getDescription()));

				// Set recommendations to 0 by default
				$recommendations = 0;

				// Set username to the gatekeeper var-- this is set to the username on login.
				$username    = trim(htmlentities($_SESSION['gatekeeper']));

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

		/*
			Remove a POI from the database using a POI Data Entity parameter
				Parameter $poi: POI Data Entity to be removed
		*/
		public function removePOI(POI $poi) {

		}

		/*
			Search the database for POIs using search field and value database
				Parameter $searchField: Field of the database to search on e.g. Region
				Parameter $searchValue: Value to be searched for using the given field e.g. Normandy
		*/
		public function searchPOIs($searchField, $searchValue) {

			// PDOStatement->bindParam() only allows variables to be passed in by reference, so declare before binding.
			// Parse using htmlentities to ensure no scripting can occur
			$searchField = trim(htmlentities($searchField));
			$searchValue = trim(htmlentities($searchValue));

			// All the field names in the database are lower case except for ID. Ensure compatibility.
			if ($searchField != "ID") {
				$searchField = strtolower($searchField);
			}

			// Use search field value and field to search db
			$statement = $this->dbConnection->prepare("SELECT * FROM pointsofinterest WHERE $searchField = ?");
			// Execute the statement and return it.
			$statement->execute([$searchValue]);

			return $statement;

		}

	}
?>
