<?php
session_start();

require_once '../database.php';
require_once '../app/controllers/SurveyController.php';
require_once '../app/controllers/TwilioController.php';

// Parse the URL
$requestUri = $_SERVER['REQUEST_URI'];
$urlComponents = parse_url($requestUri);
$requestUri = $urlComponents['path'];
$requestUri = trim($requestUri, '/');
$requestParts = explode('/', $requestUri);

$controller = !empty($requestParts[0]) ? $requestParts[0] : 'survey';
$action = !empty($requestParts[1]) ? $requestParts[1] : 'index';
$id = isset($requestParts[2]) ? $requestParts[2] : null;

$controllerClass = ucfirst($controller) . 'Controller';

// Initialize the PDO instance
$pdo = require '../database.php';

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
