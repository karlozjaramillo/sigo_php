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
    if ( is_array( $results ) ) {
    if (count($results) > 0) {
      $user = $results;
    }
    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['id'];
        header("Location: reservas.php");
      } else {
        $message = 'Sorry, those credentials do not match';
      }
    }else{
      $message = 'Sorry, those credentials do not match';

    }
  }
?>

<!-- Signup Form -->
<?php require 'partials/header.php' ?>

<?php if(!empty($message)): ?>
<p> <?= $message ?></p>
<?php endif; ?>

<!DOCTYPE html>

<html>

<head>
    <title>SIGO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload">
    <?php if(!empty($user)): ?>
    <br> Welcome. <?= $user['email']; ?>
    <br>You are Successfully Logged In
    <?php require 'reservas.php' ?>
    <?php else: ?>
    <h1>Please Login or SignUp</h1>

    <a href="signup.php">SignUp</a>
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
    <form  method="post" action="index.php">
        <input type="text" name="email" placeholder="Correo Electrónico" />
        <input type="password" name="password" placeholder="Contraseña" />
        <input type="submit" value="ingresar" />
        <a href="signup.php">registrarse</a>

    </form>
    <!-- Scripts -->
    <script src="assets/js/main.js"></script>
</body>

</html>