<?php

     // Include the POIDAO for db queries.
	require_once("../class/DAO/POIDAO.php");

	// Include the user DAO for logon checks.
	require_once("../class/DAO/UserDAO.php");

     session_start();

     // Include slim dependencies from server autoload
     require('C:\xampp\php\vendor\autoload.php');
     use Psr\Http\Message\ResponseInterface as Response;
     use Psr\Http\Message\ServerRequestInterface as Request;
     use Slim\Factory\AppFactory;

     // Create slim app and set up middleware
     $app = AppFactory::create();
     $app->addRoutingMiddleware();
     $app->addErrorMiddleware(true, true, true);

     // Move base path to pointsofinterest dir.
     $app->setBasePath('/pointsofinterest');

     // Create our PHP renderer object
     $view = new \Slim\Views\PhpRenderer('views');

     // Splash page route.
     $app->get('/splashpage', function(Request $req, Response $res, array $args) use($view) {
          // Gatekeeper check
          if (isset($_SESSION["gatekeeper"])) {
               $res = $view->render($res, 'splash.php');    
               return $res;
          } else {
               // Gatekeeper
               $res->getBody()->write("You cannot access the site this way.");
               $res->getBody()->write("<a href='../../../index.php'><p>Back to login page<p></a>");
               return $res;
          }
     });

     // Route to generate search result JSON. Returns raw json to javascript which uses it for display and functions.
     $app->get('/search/{field}/{value}', function(Request $req, Response $res, array $args) {

          $outString = "";

          // Check that the session vars for gatekeeper is present.
          if (isset($_SESSION["gatekeeper"])) {
               try {
                    // Connect to the database
                    $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

                    // Set up exception handling
                    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Create a new DAO to access the database.
                    $poiDAO = new POIDAO($dbConnection);

                    // Run the query and get the results.
                    $executedStatement = $poiDAO->searchPOIs($args['field'], $args['value']);

                    // If the search return results.
                    if ($executedStatement->rowCount() > 0) {

                         // Fetch all results, and parse them as an array of JSON objects.
                         $results = $executedStatement->fetchAll(PDO::FETCH_ASSOC);
                         return $res->withJson($results);

                    } else {

                         // No results
                         $res->getBody()->write("NO_RESULTS");
                         return $res;

                    }
               } catch (PDOException $e) {
                    // General error reporting
                    $res->getBody()->write($e);
                    return $res;
               }
          } else {
               // Gatekeeper
               $res->getBody()->write("You cannot access the site this way.");
               $res->getBody()->write("<a href='../../../index.php'><p>Back to login page<p></a>");
               return $res;
          }

          return $res;
     });

     // Route to review an id.
     $app->post('/review/{id}', function(Request $req, Response $res, array $args) {     

          // If the user tried to get into this route without authorisation, 
          // it would throw a '405 method not allowed' error anyway, because they probably wont be using POST from their browser.

          // In case the user attempts to forge a POST request, the gatekeeper and csrf checks are still here.
          if (isset($_SESSION["gatekeeper"]) && isset($_SESSION["CSRF"])) {

               $post = $req->getParsedBody();

               if ($_SESSION["CSRF"] == $post['CSRF']) {

                    try {

                         if ($post['poiID'] != "" && $post['reviewText'] != "") {
                              // Connect to the database
                              $dbConnection = new PDO("mysql:host=localhost;dbname=assign236;", "username", "password");

                              // Set up exception handling
                              $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                              // Create a new DAO to access the database.
                              $poiDAO = new POIDAO($dbConnection);

                              $successState = $poiDAO->reviewPOI($post['poiID'], $post['reviewText']);

                              // If the search return results.
                              if ($successState) {

                                   // Status code handled by JS
                                   $res->getBody()->write("SUCCESS");

                              } else {
                                   // Status code handled by JS
                                   $res->getBody()->write("FAILURE");

                              }
                         } else {
                              // Status code handled by JS
                              $res->getBody()->write("EMPTY_DETAILS");
                         }
                    } catch (PDOException $e) {
                         // General error reporting
                         $res->getBody()->write($e);
                         return $res;
                    }

                    return $res;
               } else {
                    // Bad csrf
                    $res->getBody()->write("You have an invalid auth token.");
                    $res->getBody()->write("<a href='../../../index.php'><p>Back to login page<p></a>");
                    return $res;
               } 
          } else {
               // Bad gatekeeper
               $res->getBody()->write("You cannot access the site this way.");
               $res->getBody()->write("<a href='../../../index.php'><p>Back to login page<p></a>");
               return $res;
          }

     });

     // Run the slim app to create the routes.
     $app->run();

?>
