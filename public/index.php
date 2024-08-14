<?php
session_start();

// Include Composer's autoload file
require_once '../vendor/autoload.php';

use Database\Database;

// Parse the URL
$requestUri = $_SERVER['REQUEST_URI'];
$urlComponents = parse_url($requestUri);
$requestUri = $urlComponents['path'];
$requestUri = trim($requestUri, '/');
$requestParts = explode('/', $requestUri);

$controller = !empty($requestParts[0]) ? $requestParts[0] : 'survey';
$action = !empty($requestParts[1]) ? $requestParts[1] : 'index';
$id = isset($requestParts[2]) ? $requestParts[2] : null;

$controllerClass = 'App\\Controllers\\' . ucfirst($controller) . 'Controller';

// Get the PDO connection via the Database class
$db = new Database();
$pdo = $db->getConnection();


// Check if the class exists and then instantiate it
if (class_exists($controllerClass)) {
    $controllerInstance = new $controllerClass($pdo);

    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action($id);
    } else {
        echo "Action not found!";
    }
} else {
    echo "Controller class not found!";
}
