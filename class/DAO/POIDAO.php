<?php

	// Include the poi data entity
	require_once __DIR__ . "/../../class/POI.php";

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
			Utlity method to get poi data by ID
		*/
		public function getPOI($poiID) {
			// PDOStatement->bindParam() only allows variables to be passed in by reference, so declare before binding.
			// Parse using htmlentities to ensure no scripting can occur
			$poiID = trim(htmlentities($poiID));

			// Use search field value and field to search db
			$statement = $this->dbConnection->prepare("SELECT * FROM pointsofinterest WHERE ID = ?");
			
			// Execute the statement and return it.
			$statement->execute([$poiID]);

			return $statement;
		}

		/*
			Search the database for POIs using search field and value database
				Parameter $poiID: Field of the database to search on e.g. Region
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

		/*
			Add a recommendation to a poi
				Parameter poiID: ID of poi to recommend
		*/
		public function recommendPOI($poiID) {

			$ID = trim(htmlentities($poiID));

			// Increment recommended on id
			$sql = "UPDATE pointsofinterest SET recommended=recommended + 1 WHERE ID=?";
			$statement = $this->dbConnection->prepare($sql);
			$statement->execute([$ID]);

			return $statement;

		}
		
		/*
			Add a review to a given poi
		*/
		public function reviewPOI($poiID, $reviewText) {
			// Prepared statement
			$sql = "INSERT INTO poi_reviews (poi_id, review, approved)
			VALUES (:poiID, :reviewText, 0);";

			// If statement was successfully prepared, then bind its params.
			if ($statement = $this->dbConnection->prepare($sql)) {

				// PDOStatement->bindParam() only allows variables to be passed in by reference, so declare before binding.
				// Parse using htmlentities to ensure no scripting can occur
				$poiID = trim(htmlentities($poiID));
				$reviewText = trim(htmlentities($reviewText));

				// Bind object properties to the prepared statement as parameters, trimming user input.
				$statement->bindParam(":poiID", $poiID, PDO::PARAM_STR);
				$statement->bindParam(":reviewText", $reviewText, PDO::PARAM_STR);

				// Execute the statement and return the boolean result.
				return $statement->execute();
			} else {
				return "FAILED";
			}

		}

		/**
		 * Get all approved reviews per poi.
		 */
		public function getApprovedReviews($poiID) {


			// PDOStatement->bindParam() only allows variables to be passed in by reference, so declare before binding.
			// Parse using htmlentities to ensure no scripting can occur
			$poiID = trim(htmlentities($poiID));

			// Use id to search db
			$statement = $this->dbConnection->prepare("SELECT * FROM poi_reviews WHERE poi_id=? AND approved = 1;");
			// Execute the statement and return it.
			$statement->execute([$poiID]);	

			return $statement;

		}

		/**
		 * Get all unapproved reviews.
		 */
		public function getUnapprovedReviews() {

			// Use id to search db
			$statement = $this->dbConnection->prepare("SELECT * FROM poi_reviews WHERE approved = 0;");
			// Execute the statement and return it.
			$statement->execute();	

			return $statement;

		}

		/**
		 * Remove a review of a certain ID. Returns a success state boolean.
		 */
		public function removeReview($reviewID) {

			// No scripting here
			$revID = trim(htmlentities($reviewID));

			// Use id to search db
			$statement = $this->dbConnection->prepare("DELETE FROM poi_reviews WHERE id=?");
			// Execute the statement and return it.
			$statement->execute([$revID]);	

			if ($statement->rowCount() > 0) {
				// One row was deleted. Successful
				return True;
			}

			// Nothing was deleted. Unsuccessful.
			return False;

		}

		/**
		 * Approve a review of a certain ID. Returns a success state boolean.
		 * 
		 */
	}
?>
