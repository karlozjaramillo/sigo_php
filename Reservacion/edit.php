<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../bd.php');
$nombre = '';
$trayecto= '';
$fecha= '';
if  (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT r.id,r.nombre,r.trayecto,r.fecha,t.origen_destino,t.distancia,
    t.duracion,t.vehiculo, t.costo FROM reserva r inner join trayectos t on r.trayecto=t.codigo
    WHERE id=$id";

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_array($result);
      $nombre = $row['nombre'];
      $trayecto = $row['trayecto'];
      $fecha = $row['fecha'];
      $origen_destino = $row['origen_destino'];
      $distancia = $row['distancia'];
      $duracion = $row['duracion'];
      $vehiculo = $row['vehiculo'];
      $costo = $row['costo'];
  
    }
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $trayecto = $_POST['trayecto'];
    $fecha = $_POST['fecha'];

    $query = "UPDATE reserva set nombre = '$nombre', trayecto = '$trayecto', fecha = '$fecha' WHERE id=$id";
    mysqli_query($conn, $query);
    $_SESSION['message'] = 'Task Updated Successfully';
    $_SESSION['message_type'] = 'warning';
    header('Location: reporte.php#elements');
}
/**/
$queryAll = "SELECT t.origen_destino,t.distancia,
t.duracion,t.vehiculo, costo FROM trayectos t";
$resultAll= mysqli_query($conn, $queryAll);
$rowAll = mysqli_fetch_all($resultAll);
?>

<script>
var data = <?php echo json_encode($rowAll); ?>;
function cambia(){
  var trayecto = document.getElementById("destino");
  var selTrayecto = trayecto.options[trayecto.selectedIndex].text;
  for (let index = 0; index < data.length; index++) {
    if(selTrayecto == data[index][0]){
      document.getElementById("distancia").value = data[index][1];
      document.getElementById("duracion").value = data[index][2];
      document.getElementById("vehiculo").value = data[index][3];
      document.getElementById("costo").value = data[index][4];
    }
  }
  }
</script>
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
                <h2 class="major">EDITAR RESERVA</h2>
                <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="fields">
                        <div class="field half">
                            <label for="nombre">Nombre</label>
                            <input name="nombre" type="text" value="<?php echo $nombre; ?>" placeholder="Update nombre" />
                        </div>
                        <div class="field half">
                        <label for="date">Trayecto</label>
                        <select class="sel" name="trayecto" id="destino" onchange="cambia()" required>
                            <option value="<?php echo $trayecto; ?>" selected><?php echo $origen_destino; ?></option>
                            <?php 
                            $sql = "SELECT codigo,origen_destino FROM trayectos WHERE codigo!=".$trayecto."";
                            $query = $conn -> query ($sql);
                            while($valores = mysqli_fetch_array($query)){
                            echo "<option value='".$valores['codigo']."'>".$valores['origen_destino']."</option>";
                            }
                            ?>
                        </select>
                        </div>
                        <div class="field half">
                            <label for="date">Fecha</label>
                            <input type="date" name="fecha" id="date" value="<?php echo $fecha; ?>" />
                        </div>
                        <div class="field half">
                            <label for="date">Distancia</label>
                            <input id="distancia" name="distancia" type="text" class="form-control" value="<?php echo $distancia; ?>" disabled>
                        </div>
                        <div class="field half">
                            <label for="date">Duracion</label>
                            <input id="duracion" name="duracion" type="text" class="form-control" value="<?php echo $duracion; ?>" disabled>
                        </div>
                        <div class="field half">
                            <label for="date">Vehiculo</label>
                            <input id="vehiculo" name="vehiculo" type="text" class="form-control" value="<?php echo $vehiculo; ?>" disabled>
                        </div>
                        <div class="field half">
                            <label for="costo">Costo</label>
                            <input id="costo" name="costo" type="text" class="form-control" value="<?php echo $costo; ?>" disabled>
                        </div>
                        <div class="field half">
                            <ul class="actions">
                                <li>
                                    <input type="submit" value="RESERVAR" class="primary" id="reservabtn" name="update" />
                                </li>
                                <li>
                                    <a class="waves-effect waves-light btn" href="reporte.php#elements">Volver</a>
                                </li>
                            </ul>
                        </div>
                    </div>
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