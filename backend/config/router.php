<?php 

/**
 * Initialize the router insance
 */
$router = new AltoRouter();
$router->setBasePath('/api');


/**
 * Map the routes with controller methods here
 */
$router->map('GET', '/products/[a:sku]', '\Controllers\ProductController@show');
$router->map('GET', '/products', '\Controllers\ProductController@index');
$router->map('POST', '/products', '\Controllers\ProductController@store');
$router->map('DELETE', '/products', '\Controllers\ProductController@bulkDelete');
/**
 * Match the route and return appropriate response
 */
$match = $router->match();
$response = null;

// call closure or throw 404 status
if(is_array($match) && is_callable($match['target']) ) {
    call_user_func_array($match['target'], $match['params']); 
} elseif($match !== false && strpos($match['target'], "@") !== false) {
    list($controller, $action) = explode("@", $match['target']);
    $controller = new $controller;
    $response = $controller->$action($match["params"]);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}

if($response) {
    header('Content-Type: application/json');
    echo json_encode($response); 
}

?>