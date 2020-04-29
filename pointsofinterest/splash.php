<?php

	// Include the POI DAO and utils
	require_once("../class/DAO/POIDAO.php");
	require_once("script/POICommonUtils.php");

	// Include slim dependencies from server autoload
	require('C:\xampp\php\vendor\autoload.php');
	use Psr\Http\Message\ResponseInterface as Response;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Slim\Factory\AppFactory;

	// Start the session
	session_start();

	// Check the gatekeeper session variable
	if (isset($_SESSION["gatekeeper"])) {

		?>

		<!-- Present page if session var is set. -->
		<html>
			<head>
				<title>POI: Points of Interest</title>
				<link rel="stylesheet" type="text/css" href="../style/style.css"/>

				<!-- Import form creation scripts -->
				<script src="../class/java/formhandlers/SearchPOIFormHandler.js" type="text/javascript"></script>
				<script src="../class/java/formhandlers/AddPOIFormHandler.js" type="text/javascript"></script>
			</head>

			<script type='text/javascript'>

				// Status code constants
				const adminControls = "ADMIN_CONTROL";
				const addPOIs       = "ADD_POI";
				const searchPOIs    = "SEARCH";
				const logout        = "LOG_OUT";
				const invalidUser   = "INVALID_USER";

				// --- Event handlers / CSRF methods ---

				/*
					Generate a CSRF token, then run the given sensitive operation using the opCode.
					The opCode indicates the operation to be run that needs a CSRF token.
				*/
				function runSensitiveOperation(opCode) {

					// XML HTTP request object.
					var httpRequest = new XMLHttpRequest();

					// Specify the callback function.
					httpRequest.addEventListener("load", CSRFResponse);

					httpRequest.open('POST', 'script/CSRF.php');

					// Append data to form object, and send using the HTTP Request.
			          let formData = new FormData();
					formData.append("opCode", opCode);

					// Send the request.
					httpRequest.send(formData);

				}

				/*
					Take the response from the CSRF generator and run the given operation.
					responseData is a csv line consisting of: Opcode, CSRFToken.
				*/
				function CSRFResponse(responseData) {
					// Take the CSV response line and split on the comma.
					var responseLine = responseData.target.responseText;

					// CSRF.php returns "INVALID_USER" if the gatekeeper var isnt set.
					if (responseLine != invalidUser) {
						var responseArr = responseLine.split(",");

						// Opcode is the first element, CSRF token is the second.
						var opCode = responseArr[0];
						var CSRFToken = responseArr[1];

						// Call appropriate function based on opcode.
						switch (opCode) {
							case adminControls:
								adminControl(CSRFToken);
								break;
							case addPOIs:
								add(CSRFToken);
								break;
							case searchPOIs:
								search(CSRFToken);
								break;
						}
					} else {
						// Redirect to gatekeeper error page if session is found to be invalid.
						window.location.replace("../error_pages/gatekeeper.php")
					}
				}

				/*
					Handle click events, using the parameter value to decide on action to take
					opCode is passed in from the button onclick events.
				*/
				function sidebarHandler(opCode) {
					// Remove all elements under the content pane div
					document.getElementById("contentPaneInner").textContent = '';

					// All operations except logging out are sensitive.
					if (opCode != logout) {
						runSensitiveOperation(opCode);
					} else {
						exit();
					}
				}


				// --- Operation-specific methods ---

				function adminControl(CSRFToken) {
					document.getElementById('test').innerHTML = "admincontrol";
				}

				// Form to add a POI.
				function add(CSRFToken) {
					if (CSRFToken != null) {
						var contentPane = document.getElementById("contentPaneInner");

					     // Clear content pane by setting the content to empty text
					     contentPane.textContent = '';

						// Generate a CSRF token and create a new add POI form using that token.
						var POIFormHandler = new AddPOIFormHandler(CSRFToken);

						// Create and return a form from the form handler
						var addPOIForm = POIFormHandler.createForm();

						// Append form to content pane
						contentPane.appendChild(addPOIForm);

						// Set event handler once form is appended -- Call the submit data function in the form handler.
						document.getElementById("poiSubmit").addEventListener("click", function() { POIFormHandler.submitData(POIFormHandler.CSRF); });

					}
				}

				// Form to search POIs
				function search(CSRFToken) {
					if (CSRFToken != null) {
						var contentPane = document.getElementById("contentPaneInner");

						// Clear content pane by setting the content to empty text
						contentPane.textContent = '';

						// Generate a CSRF token and create a new add POI form using that token.
						var POISearchFormHandler = new SearchPOIFormHandler(CSRFToken);

						// Create and return a form from the form handler
						var searchPOIForm = POISearchFormHandler.createForm();

						// Append form to content pane
						contentPane.appendChild(searchPOIForm);

						// Set event handler once form is appended -- Call the submit data function in the form handler.
						document.getElementById("poiSearch").addEventListener("click", function() { POISearchFormHandler.submitData(POISearchFormHandler.CSRF); });

						// Set event handler once form is appended -- Call the submit review function in the form handler.
						document.getElementById("poiAddReview").addEventListener("click", function() { POISearchFormHandler.leaveReview(); });
					}
				}

				// Logout back to the login screen.
				function exit() {
					document.getElementById('test').innerHTML = "logout";
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

						<!-- Sidebar buttons, link to event handler with different params on click -->
						<button class="button" type="button" onClick="sidebarHandler('ADMIN_CONTROL')">Admin Controls</button>
						<button class="button" type="button" onClick="sidebarHandler('ADD_POI')">Add POIs</button>
						<button class="button" type="button" onClick="sidebarHandler('SEARCH')">Search POIs</button>
						<button class="button" type="button" onClick="sidebarHandler('LOG_OUT')">Log Out</button>

					</div>
				</div>

				<!-- Content pane outer -->
				<div class="contentPaneContainer">
					<!-- Content pane inner -->
					<div id="contentPaneInner" class="contentPaneInner">

						<!-- Dynamically populated using JavaScript -->

					</div>
				</div>

			</body>
		</html>

		<?php
	} else {
		?>

		<!-- Redirect to the gatekeeper page if session is invalid. -->
		<script> window.location.replace("../error_pages/gatekeeper.php") </script>

		<?php
	}

?>
