<?php
require_once 'vendor/autoload.php';

use Framework\Router\Router;

$root = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$root = explode('/', $root);
$root = $root[0].'/'.$root[1];
define('ROOT', $root);


$datas = array(
    'title'             => 'test title to check if all Is WORKING',
    'content'           => 'IT SEEMS to be so good for the moment :D',
    'author'            => 'Damien'
);

$router = new Router($_GET['url']);

$router->get("/", "Default#index");




$router->post("/", function () use($datas) {
    $controller = new \Controller\PostController();
    $controller->addAction($datas);
});






$router->get("post/:id", "Post#view")->with(":id", "#[0-9]+#");
$router->get("posts", "Post#viewAll");

$router->get("/admin/post/create", "Post#add");
$router->post("/admin/post/create", "Post#add");

try {
    $router->run();
} catch (\Framework\Exception\RouterException $e) {
    die("Error: ".$e->getMessage());
}
