<?php

require_once __DIR__ . '/../src/utils/GlobalUtils.php';
require_once __DIR__ . '/../src/controller/BaseController.php';
require_once __DIR__ . '/../src/model/DbManager.php';

$appConfig = require __DIR__ . '/../config/application.config.php';

removeMagicQuotes();
unregisterGlobals();

$urlArray = explode("/", filter_input(INPUT_SERVER, "REQUEST_URI"));
array_shift($urlArray);
if ($urlArray[0] == "library-management"){
    array_shift($urlArray);
}
if (count($urlArray) == 1){
    $action = null;
    $actionArray = explode("?", $urlArray[0]);
    $controller = $actionArray[0];
    
} else if (count($urlArray) == 2){
    $controller = $urlArray[0];
    $actionArray = explode("?", $urlArray[1]);
    $action = $actionArray[0];
}
$queries = array();
if (count($actionArray) == 2){
    $queryArray = explode("&", $actionArray[1]);
    foreach ($queryArray as $q){
        $query = explode("=", $q);
        $queries[$query[0]] = $query[1];
    }
}

// router
$controllerName = null;
switch ($controller) {
    case "login":
        $controllerName = AuthController::class;
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $action = "login";
        } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $action = "view";
        }
        break;
    case "logout":
        $controllerName = AuthController::class;
        $action = "logout";
        break;
    
    case 'book':
        $controllerName = 'BookController';
        if ($action == null){
            $action = "getList";
        }
        break;

    default:
        break;
}

// debug:
//echo "controller: " . $controllerName . ", ";
//echo "action: " . $action . ", ";
//echo "queries: ";
//print_r($queries);
//echo "<br>";

if (!@include_once __DIR__ . '/../src/controller/' . $controllerName . '.php'){
    die("URL not found!");
}
if ((int)method_exists($controllerName, $action)) {
    require_once __DIR__ . '/../src/controller/' . $controllerName . '.php';
    $db = new DbManager($appConfig);
    $dbConnection = null;
    if ($db) {
        $dbConnection = $db->getConnection();
        $controller = new $controllerName($dbConnection);
        $controller->{$action}($_REQUEST, $queries);
    }
} else {
    echo "Method ", $action, " does not exist in class ",  $controller, "!\n";
}