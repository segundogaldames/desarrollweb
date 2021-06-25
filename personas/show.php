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

        //validamos que el id ingresado exista en la tabla personas
        $res = $mbd->prepare("SELECT p.id, p.nombre, p.rut, p.email, p.direccion, p.fecha_nac, p.telefono, p.created_at, p.updated_at, r.nombre as rol, c.nombre as comuna FROM personas p INNER JOIN roles r ON p.rol_id = r.id INNER JOIN comunas c ON p.comuna_id = c.id WHERE p.id = ?");
        $res->bindParam(1, $id);
        $res->execute();
        $persona = $res->fetch();

        $res = $mbd->prepare("SELECT id, activo FROM usuarios WHERE persona_id = ?");
        $res->bindParam(1, $id);
        $res->execute();
        $usuario = $res->fetch();

        /* echo '<pre>';
        print_r($usuario);exit;
        echo '</pre>'; */

    }
?>

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
                <h2>Persona</h2>
                <?php if(isset($_GET['m']) && $_GET['m'] == 'ok'): ?>
                    <p class="alert alert-success">
                        La persona se ha modificado correctamente
                    </p>
                <?php endif; ?>
                <?php if(isset($_GET['u']) && $_GET['u'] == 'ok'): ?>
                    <p class="alert alert-success">
                        La cuenta se ha creado correctamente
                    </p>
                <?php endif; ?>

                <?php if(isset($_GET['e']) && $_GET['e'] == 'ok'): ?>
                    <p class="alert alert-success">
                        El estado de la cuenta se ha modificado correctamente
                    </p>
                <?php endif; ?>

                <?php if(isset($_GET['p']) && $_GET['p'] == 'ok'): ?>
                    <p class="alert alert-success">
                        El password se ha modificado correctamente
                    </p>
                <?php endif; ?>

                <?php if(!empty($persona)): ?>
                    <table class="table table-hover">
                        <tr>
                            <th>Nombre:</th>
                            <td> <?php echo $persona['nombre']; ?> </td>
                        </tr>
                        <tr>
                            <th>RUT:</th>
                            <td> <?php echo $persona['rut']; ?> </td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td> <?php echo $persona['email']; ?> </td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td> <?php echo $persona['direccion']; ?> </td>
                        </tr>
                        <tr>
                            <th>Comuna:</th>
                            <td> <?php echo $persona['comuna']; ?> </td>
                        </tr>
                        <tr>
                            <th>Fecha de nacimiento:</th>
                            <td>
                                <?php
                                    $fecha_nac = new DateTime($persona['fecha_nac']);
                                    echo $fecha_nac->format('d-m-Y');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Teléfono:</th>
                            <td> <?php echo $persona['telefono']; ?> </td>
                        </tr>
                        <tr>
                            <th>Rol:</th>
                            <td><?php echo $persona['rol']; ?></td>
                        </tr>
                        <tr>
                            <th>Activo:</th>
                            <td>
                                <?php
                                    if (!empty($usuario)) {
                                        if ($usuario['activo'] == 1) {
                                            echo "Si";
                                        }else {
                                            echo "No";
                                        }
                                        echo "<a href='../usuarios/edit.php?id=" . $usuario['id'] ."' class='btn btn-link btn-sm'>Modificar</a>";
                                    }else {
                                        echo "No";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td>
                                <?php
                                    //creamos una instancia de la clase DateTime de php para guardarla en la variable fecha
                                    $fecha = new DateTime($persona['created_at']);
                                    echo $fecha->format('d-m-Y H:i:s');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Actualizado:</th>
                            <td>
                                <?php
                                    //creamos una instancia de la clase DateTime de php para guardarla en la variable fecha
                                    $fecha = new DateTime($persona['updated_at']);
                                    echo $fecha->format('d-m-Y H:i:s');
                                ?>
                            </td>
                        </tr>
                    </table>
                    <p>
                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-primary">Editar</a>

                        <?php if(!$usuario): ?>
                            <a href="../usuarios/add.php?id_persona=<?php echo $id; ?>" class="btn btn-success">Agregar Cuenta</a>
                        <?php else: ?>
                            <a href="../usuarios/editPassword.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning">Editar Password</a>
                        <?php endif; ?>

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