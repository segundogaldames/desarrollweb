<?php
    //mostrar errores de php en tiempo de ejecucion
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //llamamos al archivo conexion con la base de datos
    require('../class/conexion.php');
    require('../class/rutas.php');

    //consultamos a la tabla roles por los roles registrados en su totalidad
    //la consulta se ordena por el campo nombre de manera ascendente
    $res = $mbd->query("SELECT id, nombre FROM roles ORDER BY nombre");
    $roles = $res->fetchall(); //se disponibilizan los datos a traves de fetchall

    /* echo '<pre>';
    print_r($roles);exit;
    echo '</pre>'; */
    // print_r(count($roles));exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
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
                <h2>Lista de Roles</h2>
                <?php if(isset($_GET['m']) && $_GET['m'] == 'ok'): ?>
                    <p class="alert alert-success">
                        El rol se ha registrado correctamente
                    </p>
                <?php endif; ?>

                <?php if(isset($_GET['d']) && $_GET['d'] == 'ok'): ?>
                    <p class="alert alert-success">
                        El rol se ha eliminado correctamente
                    </p>
                <?php endif; ?>

                <?php if(isset($_GET['e']) && $_GET['e'] == 'ok'): ?>
                    <p class="alert alert-danger">
                        La operación no pudo ser realizada
                    </p>
                <?php endif; ?>


                <?php if(isset($roles) && count($roles)): ?>
                    <table class="table table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Rol</th>
                        </tr>
                        <?php foreach($roles as $rol): ?>
                            <tr>
                                <td> <?php echo $rol['id']; ?> </td>
                                <td> 
                                    <a href="show.php?id=<?php echo $rol['id']; ?>">
                                        <?php echo $rol['nombre']; ?> 
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php else: ?>
                    <p class="text-info">
                        No hay roles registrados
                    </p>
                <?php endif; ?>
                <a href="add.php" class="btn btn-primary"> Nuevo Rol </a>
            </div>
            
        </section>

        <!-- pie de pagina -->
        <footer>
            <h3>Desarrollo Web 2021</h3>
        </footer>
    </div>
    
</body>
</html>