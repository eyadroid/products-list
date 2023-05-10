<?php 

/**
 * Include the controllers here
 */
include_once(__DIR__.'/../controllers/ProductController.php');


/**
 * Initialize the router insance
 */
$router = new AltoRouter();
$router->setBasePath('/api');
/**
 * Add regex for uuid version 4
 */

/**
 * Map the routes with controller methods here
 */
$router->map( 'GET', '/', '\Controllers\ProductController@index');
/**
 * Match the route and return appropriate response
 */
$match = $router->match();
$response = NULL;

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] ); 
} elseif($match !== false && strpos($match['target'], "@") !== false) {
    list($controller, $action) = explode("@", $match['target']);
    $controller = new $controller;
    $response = $controller->$action($match["params"]);
} else {
    // no route was matched
    header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}

if($response)
    echo json_encode($response)

?>