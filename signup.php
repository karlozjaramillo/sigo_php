<?php

require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
  $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':email', $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $stmt->bindParam(':password', $password);

  if ($stmt->execute()) {
    $message = 'Te has registrado satisfactoriamente';
  } else {
    $message = 'Lo siento, hemos tenido problemas creando tu cuenta';
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>SIGO</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload">

  <?php require 'partials/header.php' ?>

  <?php if (!empty($message)) : ?>
    <p> <?= $message ?></p>
  <?php endif; ?>

  <h1>Regístrate</h1>
  <span>o <a href="index.php">Ingresa</a></span>

  <form action="signup.php" method="POST">
    <div id="signup-form">
      <input name="email" type="text" placeholder="Ingresa tu correo">
      <input name="password" type="password" placeholder="Ingresa tu contraseña">
      <input name="confirm_password" type="password" placeholder="Confirma tu contraseña">
      <input type="submit" value="Registrar">
    </div>
  </form>

</body>

</html>