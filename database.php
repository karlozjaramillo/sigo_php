<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'proyecto_sigo';
//$conexion = mysqli_connect($server,$username,$password,$database) or die(mysqli_error());
$conexion = mysqli_connect("localhost", "root", "", "proyecto_sigo");

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>