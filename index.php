<html>
	<!--Front page. The user logs in from here.-->
	
	<script type='text/javascript'>

		// Constant strings representing success states that the logon handler uses in its responses
		const correctCredentials = "CORRECT_CREDENTIALS";
		const wrongCredentials = "WRONG_CREDENTIALS";
		const invalidCredentials = "BAD_CREDENTIAL_FORMAT";

		// Submit credentials to logonhandler.php for checking in the DB. Event handler for submit button click.
		function submitCredentials() {

			// XML HTTP request object.
			var httpRequest = new XMLHttpRequest();

			// Read in data.
			var inputUsername = document.getElementById("username").value;
			var inputPassword = document.getElementById("password").value;

			// Specify the callback function.
			httpRequest.addEventListener ("load", handleResponse);

			/* 
				Open the connection to the logon handler.
				Use GET, this script queries the database.
			*/
			httpRequest.open('GET', 'script/logonhandler.php?username=' + inputUsername + '&password=' + inputPassword);

			// Send the request.
			httpRequest.send();
		}

		// Callback function for logon requests.
		function handleResponse(responseData) {
			// Save the logon handler's response.
			var responseText = responseData.target.responseText;
			
			var displayMessage = "";
			
			// Switch on the response message using the constants defined above.
			switch(responseText) { 
			
				case "VALID_CREDENTIAL_FORMAT":
					displayMessage = "yes";
					break;
				case correctCredentials: 
					break;   
					
				case wrongCredentials: 
					displayMessage = "Incorrect credentials.";
					break;
					
				case invalidCredentials:
					displayMessage = "Invalid credential format. Are you an evil cracker?";
					break;
					
				default: 
					break;   
					
			}
			
			document.getElementById('errormessage').innerHTML = displayMessage;   
		}

	</script>
	
	<head>
		<title>POI: Points of Interest</title>
		<link rel="stylesheet" type="text/css" href="style/style.css"/>
	</head>

	<body>

		<!--Centered login form-->
		<div id="center" class="center bordered">
			<!--Top bar for logo-->
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
			<p id="errormessage" class="errorMessage"></p>
		</div>
	</body>
</html>
