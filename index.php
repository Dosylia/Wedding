<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Instantiate models and controllers
use controllers\GuestbookController;

function loadClass($class)
{
    $classe = str_replace('\\', '/', $class);      
    require_once $classe . '.php'; 
}

spl_autoload_register('loadClass');


// Action map for routing
$actionMap = [
    'home' => [GuestbookController::class, 'homePage'],
    'submitEntry' => [GuestbookController::class, 'submitEntry'],
    'gallery' => [GuestbookController::class, 'gallery'],
    'notFound' => [GuestbookController::class, 'notFound'],
];

$action = "home";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $delimiter = "&";
    $URL = $_SERVER['REQUEST_URI'];
    $parsedURL = parse_url($URL);
    $path = $parsedURL['path'] ?? '';
    $query = $parsedURL['query'] ?? '';
    
    if ($path == '/' || $path == '') {
    } else {
        if (strpos($path, $delimiter) === false) {
            $result = str_replace(['/', '?'], '', $path);
            $action = htmlspecialchars($result);
        } else {
            $pos = strpos($path, $delimiter);
            $action = substr($path, 0, $pos);
            $action = str_replace(['/', '?'], '', $action);
            $action = htmlspecialchars($action);
        }
    }
}

if (isset($actionMap[$action])) {
    [$controllerClass, $method] = $actionMap[$action];
    $controller = new $controllerClass();
    $controller->$method();
} else {
    http_response_code(404);
    [$controllerClass, $method] = $actionMap['notFound'];
    $controller = new $controllerClass();
    $controller->$method();
}
