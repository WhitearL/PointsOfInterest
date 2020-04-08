<?php

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

	}
?>
