<html>
	<!--Front page. The user logs in from here.-->
	<head>
		<title>POI: Points of Interest</title>
		<link rel="stylesheet" type="text/css" href="style/style.css"/>
	</head>

	<body>

		<!--Top bar for logo-->
		<div class="topbar">
			<img src="img/poi_logo.png" height=77.5 width=146.5/>
		</div>

		<!--Centered login form-->
		<div class="center bordered">
			<h1>Points of Interest</h1>

			<!--Querying database. Use GET-->
			<form action="\script\logonhandler.php" method="get">

				<!--Table to align form fields and labels-->
				<table class="logonform">
					<tr>
						<th><label for="username">Username</label></th>
						<th><input name="username"></th>
					</tr>
					<tr>
						<th><label for="password">Password</label></th>
						<th><input type="password" name="password"></th>
					</tr>
				</table>

				<input type="submit" value="Log in">

			</form>
		</div>

	</body>
</html>
