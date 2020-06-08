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

  <!-- Header -->
  <header id="header">
    <div class="content">
      <div class="inner">
        <img src="images/logoSigo_blanco.png" alt="" style="width: 20%; height: 20%;" />
        <p>Bienvenido a tu Sistema Inteligente de Gestión Online</p>
      </div>
    </div>
  </header>

  <h6>Regístrate</h6>

  <form action="signup.php" method="POST">
    <div id="signup-form">
      <div class="fields">
        <div class="field-half">
          <input name="name" type="text" placeholder="Ingresa tu nombre">
        </div>
        <div class="field-half">
          <input name="document" type="text" placeholder="Ingresa tu documento">
        </div>
        <div class="field-half">
          <input name="phone" type="text" placeholder="Ingresa tu teléfono">
        </div>
        <div class="field-half">
          <input name="adress" type="text" placeholder="Ingresa tu dirección">
        </div>
        <div class="field-half">
          <input name="email" type="text" placeholder="Ingresa tu correo">
        </div>
        <div class="field-half">
          <input name="password" type="password" placeholder="Ingresa tu contraseña">
        </div>
        <div class="field-half">
          <input name="confirm_password" type="password" placeholder="Confirma tu contraseña">
        </div>
        <div class="field-half">
          <input type="submit" value="Registrar">
        </div>
      </div>
    </div>
  </form>
  <span><a href="index.php">Ingresa</a></span>

  <!-- Footer -->
  <footer id="footer">
    <ul class="icons">
      <li>
        <a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a>
      </li>
      <li>
        <a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a>
      </li>
      <li>
        <a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a>
      </li>
      <li>
        <a href="#" class="icon brands fa-whatsapp"><span class="label">WhatsApp</span></a>
      </li>
    </ul>
    <ul class="copyright">
      <li>&copy; Infinity Corp 2020.</li>
      <li>Créditos: <a href="#">INFINITY CORP - SIGO</a></li>
    </ul>
  </footer>

  <!-- Scripts -->
  <script src="assets/js/main.js"></script>
</body>

</html>