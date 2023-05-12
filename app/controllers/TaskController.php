<?php
namespace App\Controllers;

use App\Models\Task;
use PDO;
use InvalidArgumentException;

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

        // validation and sanitize the data
        $data = $this->validateAndSanitizeTaskData($data);
        if (!$data) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['message' => 'Invalid input data']);
            exit();
        }

        if ($task->create($data->date, $data->name, $data->description)) {
            echo json_encode(['message' => 'Task created']);
        } else {
            echo json_encode(['message' => 'Error while creating the task']);
        }
    }
    // Update a task
    public function updateTask($id)
    {
        // Update the Task object, passing the database connection to the constructor
        $task = new Task($this->db);

        // Retrieve the data from the request body and decode it as JSON
        $data = json_decode(file_get_contents("php://input"));

        // validation and sanitize the data
        $data = $this->validateAndSanitizeTaskData($data);
        if (!$data) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['message' => 'Invalid input data']);
            exit();
        }

        if ($task->update($id, $data->date, $data->name, $data->description)) {
            echo json_encode(['message' => 'Task updated']);
        } else {
            echo json_encode(['message' => 'Error while updating the task']);
        }
    }

    // Delete a task
    public function deleteTask($id)
    {
        // Delete the task object, passing the database connection to the constructor
        $task = new Task($this->db);
        
        // Validation and sanitize for id
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (empty($id)) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['message' => 'Invalid task ID']);
            exit();
        }
    
        if ($task->delete($id)) {
            echo json_encode(['message' => 'Task deleted']);
        } else {
            echo json_encode(['message' => 'Error while deleting the task']);
        }
    }

    // Validate and sanitize the data
    private function validateAndSanitizeTaskData($data)
    {
        $date = filter_var($data->date, FILTER_SANITIZE_STRING);
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new InvalidArgumentException("Date format is invalid");
        }
    
        $name = filter_var($data->name, FILTER_SANITIZE_STRING);
        if (empty($name)) {
            throw new InvalidArgumentException("Task name is required");
        }
        
        // Check if the description property exists and is not an empty string, sanitize it, or set it to an empty string
        $description = (isset($data->description) && $data->description !== "") ? filter_var($data->description, FILTER_SANITIZE_STRING) : "";
    
        // Here return a table convert in object
        // If it's need for the futur, we can create a class for this
        return (object) [
            'date' => $date,
            'name' => $name,
            'description' => $description
        ];
    }
    
}
?>