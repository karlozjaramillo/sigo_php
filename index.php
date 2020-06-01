<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header('Location: reservas.html');
}
require 'database.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
  $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
  $records->bindParam(':email', $_POST['email']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;
  if (is_array($results)) {
    if (count($results) > 0) {
      $user = $results;
    }
    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: reservas.php");
    } else {
      $message = 'Los datos no son válidos, intenta nuevamente.';
    }
  } else {
    $message = 'Los datos no son válidos, intenta nuevamente.';
  }
}
?>

<!-- Signup Form -->
<?php require 'partials/header.php' ?>

<?php if (!empty($message)) : ?>
  <p> <?= $message ?></p>
<?php endif; ?>

<!DOCTYPE html>
<!--
	Eventually by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
  <title>SIGO</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload">
  <?php if (!empty($user)) : ?>
    <br> Bienvenido. <?= $user['email']; ?>
    <br>You are Successfully Logged In
    <?php require 'reservas.php' ?>
  <?php else : ?>
    <!-- <h1>Please Login or SignUp</h1> -->

    <!-- <a href="signup.php">SignUp</a> -->
  <?php endif; ?>

  <!-- Header -->
  <header id="header">
    <div class="content">
      <div class="inner">
        <img src="images/logoSigo_blanco.png" alt="" style="width: 20%; height: 20%;" />
        <p>Bienvenido a tu Sistema Inteligente de Gestión Online</p>
      </div>
    </div>
    <h6>Identifícate</h6>
  </header>

  <!-- Signup Form id="signup-form"-->
  <form method="post" action="index.php">
    <div id="signup-form">
      <input type="text" name="email" placeholder="Correo Electrónico" />
      <input type="password" name="password" placeholder="Contraseña" />
      <input type="submit" value="Ingresar" />
    </div>
  </form>
  <p><a href="signup.php">Regístrate</a></p>

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
        <a href="#" class="icon brands fa-whatsapp"><span class="label">GitHub</span></a>
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