<?php

include ('../bd.php');

if(isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "DELETE FROM reserva WHERE id = $id";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    die("Query Failed.");
  }

  $_SESSION['message'] = 'Task Removed Successfully';
  $_SESSION['message_type'] = 'danger';
  header('Location: ../reservas.php#reports');
}

?>