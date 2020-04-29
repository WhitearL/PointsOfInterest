<?php

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
          
          $res = $view->render($res, 'splash.php');    
          return $res;
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

                    $executedStatement = $poiDAO->searchPOIs($args['field'], $args['value']);

                    // If the search return results.
                    if ($executedStatement->rowCount() > 0) {

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
          }

          return $res;
     });

     $app->post('/review/{id}', function(Request $req, Response $res, array $args) {     

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

                                   $res->getBody()->write("SUCCESS");

                              } else {

                                   $res->getBody()->write("FAILURE");

                              }
                         } else {
                              $res->getBody()->write("EMPTY_DETAILS");
                         }
                    } catch (PDOException $e) {
                         // General error reporting
                         $res->getBody()->write($e);
                         return $res;
                    }

                    return $res;
               } else {
                    $res->getBody()->write("BAD_CSRF");
                    return $res;
               } 
          } else {
               $res->getBody()->write("BAD_GATEKEEPER");
               return $res;
          }

     });

    // Security check for admin access

     // Add review route.
     $app->run();

?>
