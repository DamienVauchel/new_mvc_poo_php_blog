<?php
require_once 'vendor/autoload.php';

use Framework\Router\Router;

$router = new Router($_GET['url']);

$router->get("/", "Default#goToHome");

try {
    $router->run();
} catch (\Framework\Exception\RouterException $e) {
    die("Error: ".$e->getMessage());
}
