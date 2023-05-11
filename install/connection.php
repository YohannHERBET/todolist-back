<?php

$configData = parse_ini_file(__DIR__.'/../config.ini');

$servername = $configData['servername'];
$user = $configData['user'];
$password = $configData['password'];
$port = $configData['port'];
$database = $configData['database'];

// connection of the user to mysql before create DB
$mysql = new mysqli($servername, $user, $password, null, $port);
if ($mysql->connect_error) {
  die("Connection error: " . $mysql->connect_error);
}
?>
