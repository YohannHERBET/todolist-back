<?php
require_once 'connection.php';

$createDatabase = "CREATE DATABASE IF NOT EXISTS $database";
if ($mysql->query($createDatabase)) {
    echo "The '$database' database has been created successfully." . PHP_EOL;
} else {
    echo "Error creating database: " . $mysql->error . PHP_EOL;
}

$mysql->select_db($database);

$createTable = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(500)
)";
if ($mysql->query($createTable)) {
    echo "The 'tasks' table has been created successfully." . PHP_EOL;
} else {
    echo "Error creating table: " . $mysql->error . PHP_EOL;
}

$mysql->close();
?>
