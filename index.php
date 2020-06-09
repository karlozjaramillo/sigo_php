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

// define variables and set to empty values
$emailErr = $passwordErr = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["email"])) {
    $emailErr = "Correo es obligatorio";
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Contraseña es obligatorio";
  } else {
    $password = test_input($_POST["password"]);
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!-- Signup Form -->
<?php require 'partials/header.php' ?>

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
      <div>
        <input type="text" name="email" placeholder="Correo Electrónico" />
        <span class="error"><?php echo $emailErr; ?></span>
      </div>
      <div>
        <input type="password" name="password" placeholder="Contraseña" />
        <span class="error"><?php echo $passwordErr; ?></span>
      </div>
      <div>
        <input type="submit" value="Ingresar" />
      </div>
      <?php if (!empty($message)) : ?>
        <p class="error"> <?= $message ?></p>
      <?php endif; ?>
    </div>
  </form>
  <span><a href="signup.php">Regístrate</a></span>

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