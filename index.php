<?php
require_once 'vendor/autoload.php';

use Framework\Router\Router;
use Framework\Database\MySQLDatabase;

$db = new MySQLDatabase();
$db->connect();

$router = new Router($_GET['url']);

$router->get("/", "Default#index");

try {
    $router->run();
} catch (\Framework\Exception\RouterException $e) {
    die("Error: ".$e->getMessage());
}
