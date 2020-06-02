<?php
include ('../bd.php');
$nombre = '';
$trayecto= '';
$fecha= '';


if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM reserva WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $nombre = $row['nombre'];
    $trayecto = $row['trayecto'];
    $fecha = $row['fecha'];

  }
}

if (isset($_POST['update'])) {
  $id = $_GET['id'];
  $nombre= $_POST['nombre'];
  $trayecto = $_POST['trayecto'];
  $fecha = $_POST['fecha'];

  $query = "UPDATE reserva set nombre = '$nombre', trayecto = '$trayecto', fecha = '$fecha' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['message'] = 'Task Updated Successfully';
  $_SESSION['message_type'] = 'warning';
  //header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SIGO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets2/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="../assets2/css/noscript.css" /></noscript>
    <link rel="stylesheet" href="../materialize/css/materialize.css" />
</head>

<body class="is-preload">
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Header -->
        <!-- Main -->
        <div id="main">
            <!-- Contacto -->
            <article id="contact">
                <h2 class="major">Contacto</h2>
                <p>Puedes dejarnos un mensaje si necesitas ayuda.</p>
                <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="fields">
                        <div class="field half">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" />
                        </div>
                        <div class="field half">
                            <label for="email">trayecto</label>
                            <input type="text" name="email" id="email" />
                        </div>
                        <div class="field half">
                            <label for="date">Fecha</label>
                            <input type="text" name="fecha" id="date" />
                        </div>
                        <div class="field half">
                            <label for="Trayecto">Trayecto</label>
                            <select class="sel" name="trayecto" id="destino" required>
                                <option value="" selected>--Seleccionar--</option>
                                <?php 
                                    $sql = "SELECT codigo,origen_destino FROM trayectos";
                                    $query = $conexion -> query ($sql);

                                    while($valores = mysqli_fetch_array($query)){
                                    echo "<option value='".$valores['codigo']."'>".$valores['origen_destino']."</option>";
                                }
                                 ?>
                            </select>
                    </div>
                    <ul class="actions">
                        <li>
                            <input type="submit" value="RESERVAR" class="primary" id="reservabtn" name="update"/>
                        </li>
                        <li>
                        <a href="reporte.php#elements">volver</a>
                        </li>
                </form>
            </article>           
        </div>

        <!-- Footer -->
        <footer id="footer">
            <p class="copyright">&copy; Infinity Corp: <a href="#">SIGO</a>.</p>
        </footer>
    </div>

    <!-- BG -->
    <div id="bg"></div>

    <!-- Scripts -->
    <script src="../assets2/js/jquery.min.js"></script>
    <script src="../assets2/js/browser.min.js"></script>
    <script src="../assets2/js/breakpoints.min.js"></script>
    <script src="../assets2/js/util.js"></script>
    <script src="../assets2/js/main.js"></script>
    <script src="../assets2/js/custom.js"></script>
    <script src="../materialize/js/materialize.js"></script>
</body>

</html>