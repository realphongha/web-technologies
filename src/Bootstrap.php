<?php

//require_once __DIR__ . '/../src/model/DbManager.php';
//$appConfig = require_once __DIR__ . '/../config/application.config.php';
//$db = new DbManager($appConfig);
//$dbConnection = $db->getConnection();
//echo mysqli_real_escape_string($dbConnection, "blah' and 1 = 1'");

require_once __DIR__ . '/../src/utils/GlobalUtils.php';
require_once __DIR__ . '/../src/controller/BaseController.php';
require_once __DIR__ . '/../src/controller/ErrorController.php';
require_once __DIR__ . '/../src/model/DbManager.php';
require_once __DIR__ . '/../src/model/User.php';

$appConfig = require_once __DIR__ . '/../config/application.config.php';

session_start();
//session_destroy();

removeMagicQuotes();
unregisterGlobals();

$urlArray = explode("/", filter_input(INPUT_SERVER, "REQUEST_URI"));
array_shift($urlArray);
//if ($urlArray[0] == "library-management"){
//    array_shift($urlArray);
//}
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
    case "auth":
        $controllerName = AuthController::class;
        break;
    
    case 'book':
        $controllerName = 'BookController';
        if ($action == null){
            $action = "list";
        }
        break;
        
    case 'bbook':
        $controllerName = 'BorrowBookController';
        if ($action == null){
            $action = "list";
        }
        break;
        
    case 'user':
        $controllerName = 'UserController';
        if ($action == null){
            $action = "list";
        }
        break;
        
    case 'error':
        $controllerName = ErrorController::class;
        break;
        
    default:
        $controllerName = "HomeController";
        $action = "view";
        break;
}

// debug:
//echo "controller: " . $controllerName . ", ";
//echo "action: " . $action . ", ";
//echo "queries: ";
//print_r($queries);
//echo "<br>";

if (!include_once __DIR__ . '/../src/controller/' . $controllerName . '.php'){
    $controllerName = "ErrorController";
    $action = "notFound";
}

if ((int)method_exists($controllerName, $action) == 0){
    $controllerName = "ErrorController";
    $action = "notFound";
}

require_once __DIR__ . '/../src/controller/' . $controllerName . '.php';

$db = new DbManager($appConfig);
$dbConnection = null;
if (is_null($db)){
    $controllerName = ErrorController::class;
    $action = "internal";
} else {
    $dbConnection = $db->getConnection();
}

$controller = new $controllerName($dbConnection);
if (is_null($controller)){
    $controller = new ErrorController(null);
    $controller->notFound($request, $queries);
} else {
    $controller->{$action}($_REQUEST, $queries);
}