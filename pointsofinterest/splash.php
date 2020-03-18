<?php

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
			</head>
			
			<body>
				<!--Top bar for logo in center form-->
				<div class="topbar">
					<img class="topbarlogo" src="../img/poi_logo.png"/>
				</div>			

				<!-- Sidebar outer -->
				<div class="sidebarContainer">
					<!-- Sidebar inner -->
					<div class="sidebarInner">

						Left content. Add your main body of content to this side.

					</div>
				</div>

				<!-- Content pane outer -->
				<div class="contentPaneContainer">
					<!-- Content pane inner -->
					<div class="contentPaneInner">

						Right content. Add your images or sidebar text to this side.

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