<?php
namespace App\utils;

use PDO;
use PDOException;

class Database {
    private static $connection;

    private function __construct() {}

    public static function getConnection() {
        if (self::$connection === null) {

            // fetch de connection informations in config.ini
            $configData = parse_ini_file(__DIR__.'../../../config.ini');

            $host = $configData['servername'];
            $username = $configData['user'];
            $password = $configData['password'];
            $dbname = $configData['database'];
            $port = $configData['port'];

            try {
                // Etablish the database connection with PDO, take exceptions
                self::$connection = new PDO("mysql:host=$host:$port;dbname=$dbname;charset=utf8mb4", $username, $password,);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                echo "An error has occurred";
                exit();
            }
        }

        return self::$connection;
    }
}
