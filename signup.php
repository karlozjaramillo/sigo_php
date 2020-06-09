<?php

require 'database.php';

$message = '';

if (
  !empty($_POST['email']) && !empty($_POST['password'])
  && !empty($_POST['name']) && !empty($_POST['document'])
  && !empty($_POST['phone']) && !empty($_POST['adress'])
  && !empty($_POST['confirm_password'])
) {
  $sql = "INSERT INTO users (email, password, nombre, documento, telefono, direccion)
  VALUES (:email, :password, :name, :document, :phone, :adress)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':email', $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':name', $_POST['name']);
  $stmt->bindParam(':document', $_POST['document']);
  $stmt->bindParam(':phone', $_POST['phone']);
  $stmt->bindParam(':adress', $_POST['adress']);

  if ($stmt->execute()) {
    $message = 'Te has registrado satisfactoriamente';
  } else {
    $message = 'Lo sentimos, hemos tenido problemas creando tu cuenta';
  }
}

// define variables and set to empty values
$nameErr = $documentErr = $phoneErr = $adressErr = $emailErr = $passwordErr = $confirm_passwordErr = "";
$name = $document = $phone = $adress = $email = $password = $confirm_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Nombre es obligatorio";
  } else {
    $name = test_input($_POST["name"]);
  }

  if (empty($_POST["document"])) {
    $documentErr = "Documento es obligatorio";
  } else {
    $document = test_input($_POST["document"]);
  }

  if (empty($_POST["phone"])) {
    $phoneErr = "Teléfono es obligatorio";
  } else {
    $phone = test_input($_POST["phone"]);
  }

  if (empty($_POST["adress"])) {
    $adressErr = "Dirección es obligatorio";
  } else {
    $adress = test_input($_POST["adress"]);
  }

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

  if (empty($_POST["confirm_password"])) {
    $confirm_passwordErr = "Confirmar contraseña es obligatorio";
  } else {
    $confirm_password = test_input($_POST["confirm_password"]);
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
  <P>Los campos con asterisco (*) son obligatorios</P>
  <form action="signup.php" method="post">
    <div id="signup-form">
      <div class="fields">
        <div class="field-half">
          <span class="error"><?php echo $nameErr; ?></span>
          <input name="name" type="text" placeholder="Ingresa tu nombre (*)">
        </div>
        <div class="field-half">
          <span class="error"><?php echo $documentErr; ?></span>
          <input name="document" type="text" placeholder="Ingresa tu documento (*)">
        </div>
        <div class="field-half">
          <span class="error"><?php echo $phoneErr; ?></span>
          <input name="phone" type="text" placeholder="Ingresa tu teléfono (*)">
        </div>
        <div class="field-half">
          <span class="error"><?php echo $adressErr; ?></span>
          <input name="adress" type="text" placeholder="Ingresa tu dirección (*)">
        </div>
        <div class="field-half">
          <span class="error"><?php echo $emailErr; ?></span>
          <input name="email" type="text" placeholder="Ingresa tu correo (*)">
        </div>
        <div class="field-half">
          <span class="error"><?php echo $passwordErr; ?></span>
          <input name="password" type="password" placeholder="Ingresa tu contraseña (*)">
        </div>
        <div class="field-half">
          <span class="error"><?php echo $confirm_passwordErr; ?></span>
          <input name="confirm_password" type="password" placeholder="Confirma tu contraseña (*)">
        </div>
        <div class="field-half">
          <input type="submit" value="Registrar">
        </div>
        <span><a href="index.php">Ingresa</a></span>
      </div>
    </div>
  </form>


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