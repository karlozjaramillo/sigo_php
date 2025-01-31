<?php require 'database.php';
include('bd.php');

$queryAll = "SELECT t.origen_destino,t.distancia,
t.duracion,t.vehiculo, t.costo FROM trayectos t";
$resultAll = mysqli_query($conexion, $queryAll);
$rowAll = mysqli_fetch_all($resultAll);

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('bd.php');
$nombre = '';
$trayecto = '';
$fecha = '';
if (isset($_GET['id'])) {
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
    $_SESSION['message'] = 'Registro Actualizado';
    $_SESSION['message_type'] = 'warning';
    header('Location: reservas.php#reports');
}
/**/
$queryAll = "SELECT t.origen_destino,t.distancia,
t.duracion,t.vehiculo, costo FROM trayectos t";
$resultAll = mysqli_query($conn, $queryAll);
$rowAll = mysqli_fetch_all($resultAll);

?>

<script>
    var data = <?php echo json_encode($rowAll); ?>;

    function cambia() {
        var trayecto = document.getElementById("destino");
        var selTrayecto = trayecto.options[trayecto.selectedIndex].text;
        for (let index = 0; index < data.length; index++) {
            if (selTrayecto == data[index][0]) {
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
    <link rel="stylesheet" href="assets2/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets2/css/noscript.css" /></noscript>
    <link rel="stylesheet" href="materialize/css/materialize.css" />
</head>

<body class="is-preload">
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Header -->
        <header id="header">
            <div class="logo">
                <i class="fas fa-bus" style="font-size: 40px;"></i>
            </div>
            <div class="content">
                <div class="inner">
                    <img src="images/logoSigo_blanco.png" alt="" style="width: 20%;" />
                    <p>
                        Sistema Inteligente de Gestión Online
                    </p>
                </div>
            </div>
            <nav>
                <ul>
                    <!-- <li><a href="#intro">Intro</a></li> -->
                    <li><a href="#booking">Reserva</a></li>
                    <li><a href="#about">Acerca</a></li>
                    <li><a href="#contact">Contacto</a></li>
                    <li><a href="logout.php"> Logout</a></li>
                    <!-- <li><a href="#elements">Elements</a></li> -->
                </ul>
            </nav>
        </header>

        <!-- Main -->
        <div id="main">

            <!-- Reserva -->
            <article id="booking">
                <h2 class="major">Reserva</h2>
                <p>Por favor ingresa tu nombre y selecciona un trayecto.</p>
                <form method="post" action="Reservacion/guardarReserva.php">
                    <div class="fields">
                        <div class="field">
                            <label for="name">Nombre</label>
                            <input type="text" name="nombre" id="nombre" required />
                        </div>
                        <div class="field half">
                            <label for="Trayecto">Trayecto</label>
                            <select class="sel" name="trayecto" onchange="cambia()" id="destino" required>
                                <option value="" selected>--Seleccionar--</option>
                                <?php
                                $sql = "SELECT codigo,origen_destino FROM trayectos";
                                $query = $conexion->query($sql);

                                while ($valores = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $valores['codigo'] . "'>" . $valores['origen_destino'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="field half">
                            <label for="date">Fecha</label>
                            <input type="text" name="fecha" id="date" />
                        </div>
                        <div class="field half">
                            <label for="costo">Costo</label>
                            <input type="text" name="costo" id="costo" required disabled />
                        </div>
                        <div class="field half">
                            <label for="vehiculo">Vehículo</label>
                            <input type="text" name="vehiculo" id="vehiculo" required disabled />
                        </div>
                        <div class="field half">
                            <label for="distancia">Distancia</label>
                            <input type="text" name="distancia" id="distancia" required disabled />
                        </div>
                        <div class="field half">
                            <label for="duracion">Duración</label>
                            <input type="text" name="duracion" id="duracion" required disabled />
                        </div>
                    </div>
                    <ul class="actions">
                        <li>
                            <input type="submit" value="RESERVAR" class="primary" id="reservabtn" name="guardarReserva" />
                        </li>
                        <li><input type="reset" value="Borrar" id="erasebtn" /></li>
                        <li>
                            <a class="waves-effect waves-light btn" href="#reports">Mis reportes</a>
                        </li>
                    </ul>
                </form>
            </article>

            <!-- Reportes -->
            <article id="reports">
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
                                            <a href="reservas.php?id=<?php echo $row['id'] ?>#edit">
                                                <i class="fas fa-edit"></i></a>
                                            <a href="Reservacion/delete.php?id=<?php echo $row['id'] ?>">
                                                <i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                        </table>
                        <div class="field half">
                            <a class="waves-effect waves-light btn" href="reservas.php#booking">Volver</a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Editar -->
            <article id="edit">
                <h2 class="major">EDITAR RESERVA</h2>
                <form action="reservas.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="fields">
                        <div class="field">
                            <label for="nombre">Nombre</label>
                            <input name="nombre" type="text" value="<?php echo $nombre; ?>" placeholder="Update nombre" />
                        </div>
                        <div class="field half">
                            <label for="destino">Trayecto</label>
                            <select class="sel" name="trayecto" id="destino" onchange="cambia()" required>
                                <option value="<?php echo $trayecto; ?>" selected><?php echo $origen_destino; ?></option>
                                <?php
                                $sql = "SELECT codigo,origen_destino FROM trayectos WHERE codigo!=" . $trayecto . "";
                                $query = $conn->query($sql);
                                while ($valores = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $valores['codigo'] . "'>" . $valores['origen_destino'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="field half">
                            <label for="date">Fecha</label>
                            <input type="date" name="fecha" id="date" value="<?php echo $fecha; ?>" />
                        </div>
                        <div class="field half">
                            <label for="distancia">Distancia</label>
                            <input id="distancia" name="distancia" type="text" class="form-control" value="<?php echo $distancia; ?>" disabled>
                        </div>
                        <div class="field half">
                            <label for="duracion">Duración</label>
                            <input id="duracion" name="duracion" type="text" class="form-control" value="<?php echo $duracion; ?>" disabled>
                        </div>
                        <div class="field half">
                            <label for="vehiculo">Vehículo</label>
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
                                    <a class="waves-effect waves-light btn" href="reservas.php#reports">Volver</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </article>

            <!-- Acerca -->
            <article id="about">
                <h2 class="major">Acerca</h2>
                <span class="image main"><img src="images2/pic03.jpg" alt="" /></span>
                <p style="text-align: justify;">
                    SIGO tiene como finalidad permitir a los usuarios un mejor acceso a
                    la información sobre rutas de los buses, horarios de partida,
                    disponibilidad de asientos de las diferentes compañías que se
                    encuentran en las terminales de transporte y que prestan un servicio
                    intermunicipal y nacional, permitiendo a los usuarios realizar
                    consultas y reservaciones mediante una página web. La página
                    pretende cambiar el funcionamiento tradicional (sin dejarlo a un
                    lado) y mejorar el flujo de pasajeros en las terminales de
                    transporte reduciendo los tiempos de espera.<br />
                    El transporte en Colombia juega un papel importante en el
                    sostenimiento y desarrollo del país, por esto, implementar un
                    sistema que le permita a las personas realizar los procesos
                    mencionados anteriormente de una forma más eficiente, ayuda a
                    descongestionar las terminales, principalmente en las temporadas
                    altas en que se presenta mayor flujo de usuarios agilizando en gran
                    parte el funcionamiento de las terminales.
                </p>
            </article>

            <!-- Contacto -->
            <article id="contact">
                <h2 class="major">Contacto</h2>
                <p>Puedes dejarnos un mensaje si necesitas ayuda.</p>
                <form method="post" action="#">
                    <div class="fields">
                        <div class="field half">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" />
                        </div>
                        <div class="field half">
                            <label for="email">Correo</label>
                            <input type="text" name="email" id="email" />
                        </div>
                        <div class="field">
                            <label for="message">Mensaje</label>
                            <textarea name="message" id="message" rows="20" style="margin: 0px; height: 200px; width: 491px;"></textarea>
                        </div>
                    </div>
                    <ul class="actions">
                        <li>
                            <input type="submit" value="Enviar Mensaje" class="primary" />
                        </li>
                        <li><input type="reset" value="Borrar" /></li>
                    </ul>
                </form>
                <div>
                    <p>
                        O te puedes poner en contacto directamente, a través de:
                    </p>
                </div>
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
                <div>
                    <h1>
                        018000555555
                    </h1>
                    <p>info@sigo.com.co</p>
                </div>
            </article>

            <!-- Elements -->
            <article id="elements">
                <h2 class="major">Elements</h2>

                <section>
                    <h3 class="major">Text</h3>
                    <p>
                        This is <b>bold</b> and this is <strong>strong</strong>. This is
                        <i>italic</i> and this is <em>emphasized</em>. This is
                        <sup>superscript</sup> text and this is <sub>subscript</sub> text.
                        This is <u>underlined</u> and this is code:
                        <code>for (;;) { ... }</code>. Finally,
                        <a href="#">this is a link</a>.
                    </p>
                    <hr />
                    <h2>Heading Level 2</h2>
                    <h3>Heading Level 3</h3>
                    <h4>Heading Level 4</h4>
                    <h5>Heading Level 5</h5>
                    <h6>Heading Level 6</h6>
                    <hr />
                    <h4>Blockquote</h4>
                    <blockquote>
                        Fringilla nisl. Donec accumsan interdum nisi, quis tincidunt felis
                        sagittis eget tempus euismod. Vestibulum ante ipsum primis in
                        faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat
                        ac adipiscing accumsan faucibus. Vestibulum ante ipsum primis in
                        faucibus lorem ipsum dolor sit amet nullam adipiscing eu felis.
                    </blockquote>
                    <h4>Preformatted</h4>
                    <pre><code>i = 0;

while (!deck.isInOrder()) {
    print 'Iteration ' + i;
    deck.shuffle();
    i++;
}

print 'It took ' + i + ' iterations to sort the deck.';</code></pre>
                </section>

                <section>
                    <h3 class="major">Lists</h3>

                    <h4>Unordered</h4>
                    <ul>
                        <li>Dolor pulvinar etiam.</li>
                        <li>Sagittis adipiscing.</li>
                        <li>Felis enim feugiat.</li>
                    </ul>

                    <h4>Alternate</h4>
                    <ul class="alt">
                        <li>Dolor pulvinar etiam.</li>
                        <li>Sagittis adipiscing.</li>
                        <li>Felis enim feugiat.</li>
                    </ul>

                    <h4>Ordered</h4>
                    <ol>
                        <li>Dolor pulvinar etiam.</li>
                        <li>Etiam vel felis viverra.</li>
                        <li>Felis enim feugiat.</li>
                        <li>Dolor pulvinar etiam.</li>
                        <li>Etiam vel felis lorem.</li>
                        <li>Felis enim et feugiat.</li>
                    </ol>
                    <h4>Icons</h4>
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
                            <a href="#" class="icon brands fa-github"><span class="label">Github</span></a>
                        </li>
                    </ul>

                    <h4>Actions</h4>
                    <ul class="actions">
                        <li><a href="#" class="button primary">Default</a></li>
                        <li><a href="#" class="button">Default</a></li>
                    </ul>
                    <ul class="actions stacked">
                        <li><a href="#" class="button primary">Default</a></li>
                        <li><a href="#" class="button">Default</a></li>
                    </ul>
                </section>

                <section>
                    <h3 class="major">Table</h3>
                    <h4>Default</h4>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Item One</td>
                                    <td>Ante turpis integer aliquet porttitor.</td>
                                    <td>29.99</td>
                                </tr>
                                <tr>
                                    <td>Item Two</td>
                                    <td>Vis ac commodo adipiscing arcu aliquet.</td>
                                    <td>19.99</td>
                                </tr>
                                <tr>
                                    <td>Item Three</td>
                                    <td>Morbi faucibus arcu accumsan lorem.</td>
                                    <td>29.99</td>
                                </tr>
                                <tr>
                                    <td>Item Four</td>
                                    <td>Vitae integer tempus condimentum.</td>
                                    <td>19.99</td>
                                </tr>
                                <tr>
                                    <td>Item Five</td>
                                    <td>Ante turpis integer aliquet porttitor.</td>
                                    <td>29.99</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>100.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <h4>Alternate</h4>
                    <div class="table-wrapper">
                        <table class="alt">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Item One</td>
                                    <td>Ante turpis integer aliquet porttitor.</td>
                                    <td>29.99</td>
                                </tr>
                                <tr>
                                    <td>Item Two</td>
                                    <td>Vis ac commodo adipiscing arcu aliquet.</td>
                                    <td>19.99</td>
                                </tr>
                                <tr>
                                    <td>Item Three</td>
                                    <td>Morbi faucibus arcu accumsan lorem.</td>
                                    <td>29.99</td>
                                </tr>
                                <tr>
                                    <td>Item Four</td>
                                    <td>Vitae integer tempus condimentum.</td>
                                    <td>19.99</td>
                                </tr>
                                <tr>
                                    <td>Item Five</td>
                                    <td>Ante turpis integer aliquet porttitor.</td>
                                    <td>29.99</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>100.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>

                <section>
                    <h3 class="major">Buttons</h3>
                    <ul class="actions">
                        <li><a href="#" class="button primary">Primary</a></li>
                        <li><a href="#" class="button">Default</a></li>
                    </ul>
                    <ul class="actions">
                        <li><a href="#" class="button">Default</a></li>
                        <li><a href="#" class="button small">Small</a></li>
                    </ul>
                    <ul class="actions">
                        <li>
                            <a href="#" class="button primary icon solid fa-download">Icon</a>
                        </li>
                        <li>
                            <a href="#" class="button icon solid fa-download">Icon</a>
                        </li>
                    </ul>
                    <ul class="actions">
                        <li><span class="button primary disabled">Disabled</span></li>
                        <li><span class="button disabled">Disabled</span></li>
                    </ul>
                </section>

                <section>
                    <h3 class="major">Form</h3>
                    <form method="post" action="#">
                        <div class="fields">
                            <div class="field half">
                                <label for="demo-name">Name</label>
                                <input type="text" name="demo-name" id="demo-name" value="" placeholder="Jane Doe" />
                            </div>
                            <div class="field half">
                                <label for="demo-email">Email</label>
                                <input type="email" name="demo-email" id="demo-email" value="" placeholder="jane@untitled.tld" />
                            </div>
                            <div class="field">
                                <label for="demo-category">Category</label>
                                <select name="demo-category" id="demo-category">
                                    <option value="">-</option>
                                    <option value="1">Manufacturing</option>
                                    <option value="1">Shipping</option>
                                    <option value="1">Administration</option>
                                    <option value="1">Human Resources</option>
                                </select>
                            </div>
                            <div class="field half">
                                <input type="radio" id="demo-priority-low" name="demo-priority" checked />
                                <label for="demo-priority-low">Low</label>
                            </div>
                            <div class="field half">
                                <input type="radio" id="demo-priority-high" name="demo-priority" />
                                <label for="demo-priority-high">High</label>
                            </div>
                            <div class="field half">
                                <input type="checkbox" id="demo-copy" name="demo-copy" />
                                <label for="demo-copy">Email me a copy</label>
                            </div>
                            <div class="field half">
                                <input type="checkbox" id="demo-human" name="demo-human" checked />
                                <label for="demo-human">Not a robot</label>
                            </div>
                            <div class="field">
                                <label for="demo-message">Message</label>
                                <textarea name="demo-message" id="demo-message" placeholder="Enter your message" rows="6"></textarea>
                            </div>
                        </div>
                        <ul class="actions">
                            <li>
                                <input type="submit" value="Send Message" class="primary" />
                            </li>
                            <li><input type="reset" value="Reset" /></li>
                        </ul>
                    </form>
                </section>
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
    <script src="assets2/js/jquery.min.js"></script>
    <script src="assets2/js/browser.min.js"></script>
    <script src="assets2/js/breakpoints.min.js"></script>
    <script src="assets2/js/util.js"></script>
    <script src="assets2/js/main.js"></script>
    <script src="assets2/js/custom.js"></script>
    <script src="materialize/js/materialize.js"></script>
    <script>
        const calendar = document.querySelector("#date");
        M.Datepicker.init(calendar, {
            format: "yyyy/mm/dd",
            minDate: new Date(),
            defaultDate: new Date(),
            setDefaultDate: true,
        });

        // let seleccionar = document.querySelector("select");

        // seleccionar.addEventListener("change", establecerCosto);

        // function establecerCosto() {
        //     let eleccion = seleccionar.value;

        //     if (eleccion === "1") {
        //         document.getElementById("costo").value = "$25000";
        //         document.getElementById("vehiculo").value = "VHY321";
        //         document.getElementById("distancia").value = "79,3 Kms";
        //         document.getElementById("duracion").value = "94 minutos";
        //     } else if (eleccion === "2") {
        //         document.getElementById("costo").value = "$15000";
        //         document.getElementById("vehiculo").value = "BTR963";
        //         document.getElementById("distancia").value = "53,2 Kms";
        //         document.getElementById("duracion").value = "76 minutos";
        //     } else if (eleccion === "3") {
        //         document.getElementById("costo").value = "$10000";
        //         document.getElementById("vehiculo").value = "NSA741";
        //         document.getElementById("distancia").value = "34,8 Kms";
        //         document.getElementById("duracion").value = "53 minutos";
        //     } else if (eleccion === "4") {
        //         document.getElementById("costo").value = "$45000";
        //         document.getElementById("vehiculo").value = "TGB537";
        //         document.getElementById("distancia").value = "75 Kms";
        //         document.getElementById("duracion").value = "121 minutos";
        //     } else {
        //         document.getElementById("costo").value = "";
        //         document.getElementById("vehiculo").value = "";
        //         document.getElementById("distancia").value = "";
        //         document.getElementById("duracion").value = "";
        //     }
        // }
    </script>
</body>

</html>