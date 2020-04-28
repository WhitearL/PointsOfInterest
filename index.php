<html>

	<!--Front page. The user logs in from here.-->

	<!-- AJAX event handlers -->
	<script type='text/javascript'>

		// Constant strings representing success states that the logon handler uses in its responses
		const correctCredentials = "CORRECT_CREDENTIALS";
		const wrongCredentials   = "WRONG_CREDENTIALS";
		const invalidCredentials = "BAD_CREDENTIAL_FORMAT";

		// Submit credentials to logonhandler.php for checking in the DB. Event handler for submit button click.
		function submitCredentials() {

			// XML HTTP request object.
			var httpRequest = new XMLHttpRequest();

			// Read in data from form.
			var inputUsername = document.getElementById("username").value;
			var inputPassword = document.getElementById("password").value;

			// Specify the callback function.
			httpRequest.addEventListener("load", handleResponse);

			/*
				Open the connection to the logon handler.
				Use POST to hide logon details
			*/
			httpRequest.open('POST', 'script/logonhandler.php');

			// Append data to form object, and send using the HTTP Request.
			let formData = new FormData();
			formData.append("username", inputUsername);
			formData.append("password", inputPassword);

			// Send the request.
			httpRequest.send(formData);
		}

		// Callback function for logon requests.
		function handleResponse(responseData) {
			// Save the logon handler's response.
			var responseText = responseData.target.responseText;

			// Message to display under logon form in case of error.
			var displayMessage = "";

			// Switch on the response message using the constants defined above.
			switch(responseText) {

				case correctCredentials:
					// Credentials are valid and the gatekeeper variable is set, move to the splash page
					window.location.replace("pointsofinterest/splashpage")
					break;

				// Error states. Show an error message underneath the login button
				case wrongCredentials:
					displayMessage = "Incorrect credentials.";
					break;

				case invalidCredentials:
					displayMessage = "Invalid credential format. Are you an evil cracker?";
					break;

				// If the code isn't recognised, just display the whole message. Used for debug.
				default:
					displayMessage = responseText;
					break;

			}

			// Set the response message underneath the logon form
			document.getElementById('errormessage').innerHTML = displayMessage;

		}

	</script>

	<head>
		<title>POI: Points of Interest</title>
		<link rel="stylesheet" type="text/css" href="style/style.css"/>
	</head>

	<body>

		<!--Centered login form-->
		<div id="center" class="center bordered filled">
			<!--Top bar for logo in center form-->
			<div class="topbar">
				<img class="topbarlogo" src="img/poi_logo.png"/>
			</div>

			<h1>Points of Interest</h1>

			<!--Table to align form fields and labels-->
			<table class="logonform">
				<tr>
					<th><label for="username">Username</label></th>
					<th><input id="username"></th>
				</tr>
				<tr>
					<th><label for="password">Password</label></th>
					<th><input type="password" id="password"></th>
				</tr>
			</table>

			<!-- Call AJAX event handler for button click-->
			<input type="submit" value="Log in" onclick="submitCredentials()" />

			<!-- Display errors here -->
			<p id="errormessage" class="errorMessage"></p>
		</div>
	</body>
</html>
