<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

include ('../bd.php');

if (isset($_POST['guardarReserva'])) {
  $nombre = $_POST['nombre'];
  $trayecto = $_POST['trayecto'];
  $fecha = $_POST['fecha'];

  $query = "INSERT INTO reserva(nombre, trayecto, fecha) VALUES ('$nombre', '$trayecto', '$fecha')";
  $result = mysqli_query($conn, $query);
  
  if(!$result) {
    die("Query Failed.");
  }

  $_SESSION['message'] = 'Task Saved Successfully';
  $_SESSION['message_type'] = 'success';

  header("Location: ../reservas.php");
}

  ?>
  
