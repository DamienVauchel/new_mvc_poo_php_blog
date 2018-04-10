<?php
session_start();
require_once 'vendor/autoload.php';

use Framework\Router\Router;

$root = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$root = explode('/', $root);
$root = $root[0].'/'.$root[1];
define('ROOT', $root);

$controller = new \Framework\Controller\Controller();

$roles = null;
if (isset($_SESSION['loggedUser']) && !empty($_SESSION['loggedUser'])) {
    $roles = $controller->getLoggedUserRoles();
}
//$datas = array(
//    'title'             => 'a',
//    'content'           => 'IT SEEMS to be so good for the moment :D',
//    'author'            => 'Damien'
//);

$router = new Router($_GET['url']);

/*################## SECURITY ROUTES ############################*/
if ($roles) {
    $router->get("signup", function () use($controller) { $controller->redirectTo('home'); });
    $router->get("login", function () use($controller) { $controller->redirectTo('home'); });
} else {
    $router->get("signup", "Security#signUp");
    $router->post("signup", "Security#signUp");

    $router->get("login", "Security#login");
    $router->post("login", "Security#login");
}

$router->get("logout", "Security#logout");

/*################## DEFAULT ROUTES ############################*/
$router->get("home", "Default#index");

/*################## POSTS ROUTES ############################*/
$router->get("viewPost", "Post#view")->with(":id", "#[0-9]+#");
$router->get("viewAllPosts", "Post#viewAll");

/*################## ADMIN ROUTES ############################*/
if ($roles) {
    if ($roles == "ROLE_ADMIN") {
        $router->get("admin", "Admin#index");

        $router->get("createPost", "Post#add");
        $router->post("createPost", "Post#add");
    } else {
        $router->get("createPost", "Post#add");
        $router->post("createPost", "Post#add");

        $router->get("admin", function () use($controller) { $controller->redirectTo('home'); });
    }
} else {
    $router->get("createPost", function () use($controller) { $controller->redirectTo('home'); });
    $router->get("admin", function () use($controller) { $controller->redirectTo('home'); });
}






try {
    $router->run();
} catch (\Framework\Exception\RouterException $e) {
    die("Error: ".$e->getMessage());
}
