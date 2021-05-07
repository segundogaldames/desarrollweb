<?php
    //mostrar errores de php en tiempo de ejecucion
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //llamar al archivo conexion.php
    require('../class/conexion.php');
    require('../class/rutas.php');

    //verificar que la variable id que viene por GET existe
    if (isset($_GET['id'])) {
        //print_r($_GET);exit;
        //almacenamos la variable id que viene via GET en una variable id
        $id = (int) $_GET['id']; //parseamos la variable la variable GET

        //validamos que el id ingresado exista en la tabla regiones
        $res = $mbd->prepare("SELECT id, nombre, created_at, updated_at FROM regiones WHERE id = ?");
        $res->bindParam(1, $id);
        $res->execute();
        $region = $res->fetch();

        /* echo '<pre>';
        print_r($rol);exit;
        echo '</pre>'; */
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regiones</title>
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
                <h2>Región</h2>
                <?php if(isset($_GET['m']) && $_GET['m'] == 'ok'): ?>
                    <p class="alert alert-success">
                        La región se ha modificado correctamente
                    </p>
                <?php endif; ?>

                <?php if($region): ?>
                    <table class="table table-hover">
                        <tr>
                            <th>Id:</th>
                            <td> <?php echo $region['id']; ?> </td>
                        </tr>
                        <tr>
                            <th>Región:</th>
                            <td> <?php echo $region['nombre']; ?> </td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td> 
                                <?php 
                                    //creamos una instancia de la clase DateTime de php para guardarla en la variable fecha
                                    $fecha = new DateTime($region['created_at']);
                                    echo $fecha->format('d-m-Y H:i:s'); 
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <th>Actualizado:</th>
                            <td> 
                                <?php 
                                    //creamos una instancia de la clase DateTime de php para guardarla en la variable fecha
                                    $fecha = new DateTime($region['updated_at']);
                                    echo $fecha->format('d-m-Y H:i:s'); 
                                ?>
                            </td>
                        </tr>
                    </table>
                    <p>
                        <a href="edit.php?id=<?php echo $region['id']; ?>" class="btn btn-primary">Editar</a>
                        <a href="index.php" class="btn btn-link">Volver</a>  
                    </p>
                <?php else: ?>
                    <p class="text-info">
                        El dato consultado no existe
                    </p>
                <?php endif; ?>
                
            </div>
            
        </section>

        <!-- pie de pagina -->
        <footer>
            <h3>Desarrollo Web 2021</h3>
        </footer>
    </div>
    
</body>
</html>