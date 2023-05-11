<?php
namespace App\Models;

use PDO;

class Task
{
    private $connection;

    public function __construct($db)
    {
        // The constructor takes a PDO connection as a parameter and assigns it to the $connection variable
        $this->connection = $db;
    }

    // Method for create a task
    public function create($date, $name, $description)
    {
        // SQL query to insert a new task into the "tasks" table
        $sql = "INSERT INTO tasks (date, name, description) VALUES (:date, :name, :description)";
      
        // Prepare the SQL query using the PDO connection
        $stmt = $this->connection->prepare($sql);

        // Bind the values to the prepared query parameters
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        // Execute the prepared query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
