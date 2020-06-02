<?php

include('../bd.php');

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

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body class="is-preload">
    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Main -->
        <div id="main">
            <!-- Intro -->
            <!-- Elements -->
            <article id="elements">
                <h3 class="major">RESERVACIONES</h3>
                <div class="fields">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Trayecto</th>
                                    <th>Fecha</th>
                                    <th>Distancia</th>
                                    <th>Duración</th>
                                    <th>Vehículo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT r.id,r.nombre,r.trayecto,r.fecha,t.origen_destino,t.distancia,
                            t.duracion,t.vehiculo FROM reserva r
                             inner join trayectos t on r.trayecto=t.codigo";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><?php echo $row['origen_destino']; ?></td>
                                        <td><?php echo $row['fecha']; ?></td>
                                        <td><?php echo $row['distancia']; ?></td>
                                        <td><?php echo $row['duracion']; ?></td>
                                        <td><?php echo $row['vehiculo']; ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $row['id'] ?>#contact">Editar</a>
                                            <a href="delete.php?id=<?php echo $row['id'] ?>">
                                                Eliminar</>
                                        </td>
                                    </tr>
                                <?php } ?>
                        </table>
                        <div class="field half">
                            <a class="waves-effect waves-light btn" href="../reservas.php#booking">Volver</a>
                        </div>
                    </div>
                </div>
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