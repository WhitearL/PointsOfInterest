<?php

	require('C:\xampp\php\vendor\autoload.php');
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	// Start the session
	session_start();

	// Check the gatekeeper session variable
	if (isset($_SESSION["gatekeeper"])) {

		?>

		<!-- Slim setup -->
		<?php

			// Create slim app and set up middleware
			$app = AppFactory::create();
			$app->addRoutingMiddleware();
			$app->addErrorMiddleware(true, true, true);

			// Move base path to pointsofinterest dir.
			$app->setBasePath('/pointsofinterest');

			// Splash page route.
			$app->get('/splashpage', function(Request $req, Response $res, array $args) {
				return $res;
			});

			$app->run();

		?>

		<!-- Present page if session var is set. -->
		<html>
			<head>
				<title>POI: Points of Interest</title>
				<link rel="stylesheet" type="text/css" href="../style/style.css"/>

				<!-- Import form creation scripts -->
				<script src="script/addpoiform.js" type="text/javascript"></script>
			</head>

			<script type='text/javascript'>

				// Status code constants
				const adminControls = "ADMIN_CONTROL";
				const addPOIs = "ADD_POI";
				const removePOIs = "REMOVE_POI";
				const searchPOIs = "SEARCH";
				const logout = "LOG_OUT";

				function adminControl() {
					document.getElementById('test').innerHTML = "admincontrol";
				}

				function add() {
					var x = document.getElementById("contentPaneInner");

				     // Clear content pane by setting the content to empty text
				     x.textContent = '';



					x.appendChild(createAddPOIForm());
				}

				function remove() {
					document.getElementById('test').innerHTML = "remove";
				}

				function search() {
					document.getElementById('test').innerHTML = "search";
				}

				function exit() {
					document.getElementById('test').innerHTML = "logout";
				}

				// Handle click events, using the parameter value to decide on action to take.
				function sidebarHandler(value) {
					// Remove all elements under the content pane div
					document.getElementById("contentPaneInner").textContent = '';

					switch(value) {
						case adminControls:
							adminControl();
							break;
						case addPOIs:
							add();
							break;
						case removePOIs:
							remove();
							break;
						case searchPOIs:
							search();
							break;
						case logout:
							exit();
							break;
					}
				}



			</script>

			<body>
				<!--Top bar for logo in center form-->
				<div class="topbar">
					<img class="topbarlogo" src="../img/poi_logo.png"/>
				</div>

				<!-- Sidebar outer -->
				<div class="sidebarContainer">
					<!-- Sidebar inner -->
					<div class="sidebarInner">

						<p id="test"></p>

						<!-- Sidebar buttons -->
						<button class="button" type="button" onClick="sidebarHandler('ADMIN_CONTROL')">Admin Controls</button>
						<button class="button" type="button" onClick="sidebarHandler('ADD_POI')">Add POIs</button>
						<button class="button" type="button" onClick="sidebarHandler('REMOVE_POI')">Remove POIs</button>
						<button class="button" type="button" onClick="sidebarHandler('SEARCH')">Search POIs</button>
						<button class="button" type="button" onClick="sidebarHandler('LOG_OUT')">Log Out</button>

					</div>
				</div>

				<!-- Content pane outer -->
				<div class="contentPaneContainer">
					<!-- Content pane inner -->
					<div id="contentPaneInner" class="contentPaneInner">


					</div>
				</div>

			</body>
		</html>

		<?php
	} else {
		?>
		// Redirect to the gatekeeper page if session is invalid.
		<script> window.location.replace("../error_pages/gatekeeper.php") </script>

		<?php
	}

?>
