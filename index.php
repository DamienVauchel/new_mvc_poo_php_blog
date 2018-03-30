<?php
require_once 'vendor/autoload.php';

use Framework\Router\Router;

$root = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$root = explode('/', $root);
$root = $root[0].'/'.$root[1];
define('ROOT', $root);

$router = new Router($_GET['url']);

$router->get("/", "Default#index");

$router->get("post/:id", "Post#view")->with(":id", "#[0-9]+#");
$router->get("posts", "Post#viewAll");

try {
    $router->run();
} catch (\Framework\Exception\RouterException $e) {
    die("Error: ".$e->getMessage());
}
