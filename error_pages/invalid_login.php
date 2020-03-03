<html>
     <!--This is the page the user will come to if their details are in an invalid format, or if they are wrong-->

     <?php
          /*Get the error message from the query string provided by the sender page.*/
          $errorMsg = $_GET["errorMsg"];
     ?>

	<head>
		<title>Invalid login credentials</title>
		<link rel="stylesheet" type="text/css" href="../style/style.css"/>
	</head>

	<body>

		<!--Top bar for logo-->
		<div class="topbar">
               <!--Link back to login page on the logo-->
			<a href="../index.php">
                    <img class="topbarlogo" src="../img/poi_logo.png" />
               </a>
		</div>

		<!--Centered content box-->
		<div class="center bordered">
               <?php echo "<p>$errorMsg</p>"; ?>
               <a href="../index.php"><p>Back to login page<p></a>
		</div>

	</body>
</html>
