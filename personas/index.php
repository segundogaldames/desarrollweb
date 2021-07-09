<?php
    //mostrar errores de php en tiempo de ejecucion
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //llamamos al archivo conexion con la base de datos
    require('../class/conexion.php');
    require('../class/rutas.php');

    session_start();

    //consultamos a la tabla personas por los personas registrados en su totalidad
    //la consulta se ordena por el campo nombre de manera ascendente
    $res = $mbd->query("SELECT p.id, p.nombre, r.nombre as rol, c.nombre as comuna FROM personas p INNER JOIN roles r ON p.rol_id = r.id INNER JOIN comunas c ON p.comuna_id = c.id ORDER BY p.nombre");
    $personas = $res->fetchall(); //se disponibilizan los datos a traves de fetchall

    /* echo '<pre>';
    print_r($personas);exit;
    echo '</pre>'; */
    // print_r(count($personas));exit;
?>
<?php if(isset($_SESSION['autenticado']) && $_SESSION['usuario_rol'] != 'Cliente'): ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personas</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <!-- cabecera de la pagina -->
        <header>
            <!-- llamada al archivo menu.php -->
            <?php include('../partials/menu.php'); ?>
        </header>

        <!-- area principal de contenidos -->
        <section>
            <div class="col-md-6 offset-md-3">
                <h2>Lista de Personas</h2>

                <?php include('../partials/mensajes.php'); ?>

                <?php if(count($personas)): ?>
                    <table class="table table-hover">
                        <tr>
                            <th>Nombre</th>
                            <th>Comuna</th>
                            <th>Rol</th>
                        </tr>
                        <?php foreach($personas as $persona): ?>
                            <tr>
                                <td>
                                    <a href="show.php?id=<?php echo $persona['id']; ?>">
                                        <?php echo $persona['nombre']; ?>
                                    </a>
                                </td>
                                <td><?php echo $persona['comuna']; ?></td>
                                <td><?php echo $persona['rol']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php else: ?>
                    <p class="text-info">
                        No hay personas registradas
                    </p>
                <?php endif; ?>
                <a href="add.php" class="btn btn-primary"> Nueva Persona </a>
            </div>

        </section>

        <!-- pie de pagina -->
        <footer>
            <h3>Desarrollo Web 2021</h3>
        </footer>
    </div>

</body>
</html>
<?php else: ?>
    <?php header('Location: ' . BASE_URL); ?>
<?php endif; ?>