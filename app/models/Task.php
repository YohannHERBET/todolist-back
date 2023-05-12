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
    // Method fetch all tasks
    public function fetchAll() {
        // SQL query to retrieve all tasks from the "tasks" table
        $sql = "SELECT * FROM tasks";

        // Launch the request
        $stmt = $this->connection->query($sql);

        // Return the result of the query
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        return $stmt->execute();
    }
    // Method for update a task
    public function update($id, $date, $name, $description)
    {
        // SQL query to update a task into the "tasks" table
        $sql = "UPDATE tasks SET date = :date, name = :name, description = :description WHERE id = :id";
        
        // Prepare the SQL query using the PDO connection
        $stmt = $this->connection->prepare($sql);

        // Bind the values to the prepared query parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);

        // Execute the prepared query
        return $stmt->execute();
    }

    // Method for delete a task
    public function delete($id)
    {
        // SQL query to delete a task from the "tasks" table
        $sql = "DELETE FROM tasks WHERE id = :id";

        // Prepare the SQL query using the PDO connection
        $stmt = $this->connection->prepare($sql);

        // Bind the values to the prepared query parameters
        $stmt->bindParam(':id', $id);

        // Execute the prepared query
        return $stmt->execute();
    }
}
