<?php
namespace App\Controllers;

use App\Models\Task;
use PDO;

class TaskController {
    private $db;

    public function __construct(PDO $db) {
      // The constructor takes a PDO object as a parameter and assigns it to the $db variable
        $this->db = $db;
    }

    // Get all tasks
    public function getAllTasks() {
      // Create a new Task object, passing the database connection to the constructor
        $task = new Task($this->db);
        // Call the getAllTasks method of the Task object
        $tasks = $task->fetchAll();
        // If the getAllTasks method returns false, return a 500 status code
        if (!$tasks) {
            header('HTTP/1.1 500 Internal Server Error');
            exit();
        }
        // If the getAllTasks method returns true, return the tasks in JSON format
        echo json_encode($tasks);
    }

    // Create task
    public function createTask() {
      // Create a new Task object, passing the database connection to the constructor
        $task = new Task($this->db);
        // Retrieve the data from the request body and decode it as JSON
        $data = json_decode(file_get_contents("php://input"));

        // Validation and sanitize the data
        $date = filter_var($data->date, FILTER_SANITIZE_STRING);
        // preg_match for search with regex expression
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }
        $data->date = $date;
    
        $name = filter_var($data->name, FILTER_SANITIZE_STRING);
        if (empty($name)) {
            return false;
        }
        $data->name = $name;
    
        $description = filter_var($data->description, FILTER_SANITIZE_STRING);
        if (empty($description)) {
            return false;
        }
        $data->description = $description;

        if ($task->create($data->date, $data->name, $data->description)) {
            echo json_encode(['message' => 'Task created']);
        } else {
            echo json_encode(['message' => 'Error while creating the task']);
        }
    }
}
?>