<?php
session_start();
require_once 'vendor/autoload.php';

use Framework\Router\Router;

$root = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$root = explode('/', $root);
$root = $root[0].'/'.$root[1];
define('ROOT', $root);


$datas = array(
    'title'             => 'a',
    'content'           => 'IT SEEMS to be so good for the moment :D',
    'author'            => 'Damien'
);

$router = new Router($_GET['url']);

$router->get("home", "Default#index");




$router->post("home", function () use($datas) {
    $controller = new \Controller\PostController();
    $controller->addAction($datas);
});






$router->get("viewPost", "Post#view")->with(":id", "#[0-9]+#");
$router->get("viewAllPosts", "Post#viewAll");

$router->get("/admin/post/create", "Post#add");
$router->post("/admin/post/create", "Post#add");

try {
    $router->run();
} catch (\Framework\Exception\RouterException $e) {
    die("Error: ".$e->getMessage());
}
