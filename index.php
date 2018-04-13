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

$router = new Router($_GET['url']);

if (empty($_SESSION) || empty($_COOKIE['bl_ti']) || !isset($_SESSION['bl_ti']) && !isset($_COOKIE['bl_ti'])) {
    \Framework\Security\Ticket::create();
}

if (isset($_SESSION['bl_ti']) && isset($_COOKIE['bl_ti']) && ($_COOKIE['bl_ti'] == $_SESSION['bl_ti'])) {
    /*################## DEFAULT ROUTES ############################*/
    $router->get("home", "Default#index");
    $router->post("home", "Default#index");

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

    /*################## POSTS ROUTES ############################*/
    $router->get("viewPost", "Post#view")->with(":id", "#[0-9]+#");
    $router->post("viewPost", "Post#view")->with(":id", "#[0-9]+#");
    $router->get("viewAllPosts", "Post#viewAll");

    /*################## ADMIN ROUTES ############################*/
    if ($roles) {
        if ($roles == "ROLE_ADMIN") {
            $router->get("admin", "Admin#index");

            $router->get("createPost", "Post#add");
            $router->post("createPost", "Post#add");

            $router->get("editPost", "Post#edit");
            $router->post("editPost", "Post#edit");

            $router->get("deletePost", "Post#delete");
            $router->post("deletePost", "Post#delete");
        } else {
            $router->get("createPost", "Post#add");
            $router->post("createPost", "Post#add");

            $router->get("editPost", function () use($controller) { $controller->redirectTo('home'); });

            $router->get("deletePost", function () use($controller) { $controller->redirectTo('home'); });

            $router->get("admin", function () use($controller) { $controller->redirectTo('home'); });
        }
    } else {
        $router->get("createPost", function () use($controller) { $controller->redirectTo('home'); });
        $router->get("editPost", function () use($controller) { $controller->redirectTo('home'); });
        $router->get("deletePost", function () use($controller) { $controller->redirectTo('home'); });
        $router->get("admin", function () use($controller) { $controller->redirectTo('home'); });
    }
} else {
    /*################## DEFAULT ROUTES ############################*/
    $router->get("home", "Default#index");
    $router->post("home", "Default#index");

    /*################## POSTS ROUTES ############################*/
    $router->get("viewPost", "Post#view")->with(":id", "#[0-9]+#");
    $router->post("viewPost", "Post#view")->with(":id", "#[0-9]+#");
    $router->get("viewAllPosts", "Post#viewAll");
}







try {
    $router->run();
} catch (\Framework\Exception\RouterException $e) {
    die("Error: ".$e->getMessage());
}
