<?php

/**
 * Front Controller
 */

define( 'APP_PATH', dirname(__DIR__) . '/app' );
define( 'BASE_PATH', dirname(__DIR__) );
ini_set('display_error', 1);
// require router class
require_once BASE_PATH . '/core/Router.php';

use Zarten\Core\Router;

$router = new Router();

// add some routes to router
$router->add('', ['controller' => 'IndexController', 'action' => 'indexAction']);
$router->add('/', ['controller' => 'IndexController', 'action' => 'indexAction']);
$router->add('posts', ['controller' => 'PostsController', 'action' => 'indexAction']);
$router->add('posts/create', ['controller' => 'PostsController', 'action' => 'createAction']);

// match route
$url = $_SERVER['QUERY_STRING'];

if( $router->match($url) ){
    echo '<pre>';
    print_r($router->getParams());
    echo '</pre>';
}else{
    echo 'No matching route found';
}