<!-- Slim setup -->
<?php

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

     // Splash page route.
     $app->get('/splashpage', function(Request $req, Response $res, array $args) {
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
                         echo "NO_RESULTS";

                    }
               } catch (PDOException $e) {
                    // General error reporting
                    echo $e;
               }
          }

          return $res;
     });

     // Add review route.

     $app->run();

?>
