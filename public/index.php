<?php
// load all the required classes automatically
require_once __DIR__ . '/../vendor/autoload.php';

use App\utils\Database;
use App\Controllers\TaskController;

// define the headers of the HTTP requests
header('Content-Type: application/json');
// allow all cors because in local
//TODO Change cors in prod
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Allow cors in the option request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Prévoler les requêtes CORS
    header("HTTP/1.1 200 OK");
    exit();
}

// catch the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// catch the clean path
$uri = explode('/', $uri);

// if the path is not "taches" stop the script and return a 404 sattus code
if ($uri[1] !== 'taches') {
    header('HTTP/1.1 404 Not Found');
    exit();
}

// Create new instance of the task controller using the obtained database connection
$taskController = new TaskController(Database::getConnection());

switch ($method) {
    case 'GET':
        $taskController->getAllTasks();
        break;
    case 'POST':
        $taskController->createTask();
        break;
    case 'PUT':
        if (isset($uri[2])) {
            $id = $uri[2];
            $taskController->updateTask($id);
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['message' => 'Problem with the task id']);
        }
        break;
    case 'DELETE':
        if (isset($uri[2])) {
            $id = $uri[2];
            $taskController->deleteTask($id); 
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['message' => 'Problem with the task id']);
        }
        break;
    // if we don't have a case, it's a default, the default return a 405 status code, because method not supported
    default:
        header('HTTP/1.1 405 Method Not Allowed');
        break;
}
?>