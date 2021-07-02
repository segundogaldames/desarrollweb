<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    require('../class/conexion.php');//llamamos al archivo conexion.php
    require('../class/rutas.php');

    if (isset($_GET['id'])) {

        $id = (int) $_GET['id'];

        //lista de roles
        $res = $mbd->query("SELECT id, nombre FROM roles ORDER BY nombre");
        $roles = $res->fetchall();

        //lista de comunas
        $res = $mbd->query("SELECT id, nombre FROM comunas ORDER BY nombre");
        $comunas = $res->fetchall();

        //si existe la persona asociada al id recibido por GET en la tabla personas
        $res = $mbd->prepare("SELECT p.id, p.nombre, p.rut, p.email, p.direccion, p.fecha_nac, p.telefono, p.rol_id, p.comuna_id, p.created_at, p.updated_at, r.nombre as rol, c.nombre as comuna FROM personas p INNER JOIN roles r ON p.rol_id = r.id INNER JOIN comunas c ON p.comuna_id = c.id WHERE p.id = ?");
        $res->bindParam(1, $id);
        $res->execute();

        $persona = $res->fetch();

        //preguntaremos si los datos vienen via post
        //preguntaremos por la variable confirm y si el valor de esa variable es 1
        //usamos el operador logico y (&&) para comprobar que ambas condiciones sean verdaderas obligatoriamente
        if (isset($_POST['confirm']) && $_POST['confirm'] == 1 ) {

            $nombre = trim(strip_tags($_POST['nombre'])); //proceso de sanitizacion de datos desde el servidor
            $rut = trim(strip_tags($_POST['rut']));
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $direccion = trim(strip_tags($_POST['direccion']));
            $fecha_nac = trim(strip_tags($_POST['fecha_nac']));
            $telefono = filter_var($_POST['telefono'], FILTER_VALIDATE_INT);
            $rol = filter_var($_POST['rol'], FILTER_VALIDATE_INT);
            $comuna = filter_var($_POST['comuna'], FILTER_VALIDATE_INT);

            if (strlen($nombre) < 5) {
                //creamos una variable con el mensaje de error
                $msg = 'Ingrese el nombre con al menos 5 caracteres';
            }elseif (strlen($rut) < 8) {
                $msg = 'El rut no puede tener menos de 8 caracteres';
            }elseif (!$email) {
                $msg = 'Ingrese un correo electrónico válido';
            }elseif (strlen($direccion) < 8) {
                $msg = 'La dirección debe contener al menos 8 caracteres';
            }elseif (!$fecha_nac) {
                $msg = 'Ingrese la fecha de nacimiento';
            }elseif (strlen($telefono) < 9) {
                $msg = 'El número de teléfono debe contener al menos 9 dígitos';
            }elseif (!$rol) {
                $msg = 'Seleccione un rol';
            }elseif (!$comuna) {
                $msg = 'Seleccione una comuna';
            }else{

                //actualizar la persona en la tabla personas
                $res = $mbd->prepare("UPDATE personas SET nombre = ?, rut = ?, email = ?, direccion = ?, fecha_nac = ?, telefono = ?, rol_id = ?, comuna_id = ?, updated_at = now() WHERE id = ?");
                $res->bindParam(1, $nombre);
                $res->bindParam(2, $rut);
                $res->bindParam(3, $email);
                $res->bindParam(4, $direccion);
                $res->bindParam(5, $fecha_nac);
                $res->bindParam(6, $telefono);
                $res->bindParam(7, $rol);
                $res->bindParam(8, $comuna);
                $res->bindParam(9, $id);
                $res->execute();

                //consultar por el numero de filas afectadas en esta consulta
                $row = $res->rowCount();

                if ($row) {
                   $_SESSION['success'] = 'La persona se ha modificado correctamente';
                    //redireccionamos hacia la pagina index enviandole el contenido de la variable msg
                    header('Location: show.php?id=' . $id);
                }

            }

        }

        //print_r($id);exit;
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
                <h2>Editar Persona</h2>
                <!-- get => el envio del dato se hace via url del sistema
                post => el envio del dato se hace via interna -->

                <?php if(!empty($persona)): ?>
                    <form action="" method="post">
                        <div class="row mb-3">
                            <label for="nombre" class="col-md-2 col-form-label">Nombre <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="text" name="nombre" value="<?php echo $persona['nombre']; ?>" class="form-control" placeholder="Ingrese el nombre de la persona">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="rut" class="col-md-2 col-form-label">RUT <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="text" name="rut" value="<?php echo $persona['rut']; ?>" class="form-control" placeholder="Ingrese el RUT de la persona">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-form-label">Email <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="email" name="email" value="<?php echo $persona['email']; ?>" class="form-control" placeholder="Ingrese el email de la persona">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="direccion" class="col-md-2 col-form-label">Dirección (calle y N°) <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="text" name="direccion" value="<?php echo $persona['direccion']; ?>" class="form-control" placeholder="Ingrese la dirección de la persona">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="comuna" class="col-md-2 col-form-label">Comuna <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <select name="comuna" class="form-control">
                                    <option value="<?php echo $persona['comuna_id']; ?>">
                                        <?php echo $persona['comuna']; ?>
                                    </option>

                                    <?php foreach($comunas as $comuna): ?>
                                        <option value="<?php echo $comuna['id']; ?>">
                                            <?php echo $comuna['nombre']; ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="fecha_nac" class="col-md-2 col-form-label">Fecha de nacimiento <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="date" name="fecha_nac" value="<?php echo $persona['fecha_nac']; ?>" class="form-control" placeholder="Ingrese la fecha de nacimiento de la persona">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telefono" class="col-md-2 col-form-label">Teléfono <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="number" name="telefono" value="<?php echo $persona['telefono']; ?>" class="form-control" placeholder="Ingrese el teléfono de la persona">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="rol" class="col-md-2 col-form-label">Rol <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <select name="rol" class="form-control">
                                    <option value="<?php echo $persona['rol_id']; ?>">
                                        <?php echo $persona['rol']; ?>
                                    </option>

                                    <?php foreach($roles as $rol): ?>
                                        <option value="<?php echo $rol['id']; ?>">
                                            <?php echo $rol['nombre']; ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>

                        <!-- este campo hidden nos ayudara a comprobar que los datos del formularios sean enviados por post -->
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-primary"> Guardar </button>
                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-link">Volver</a>
                    </form>
                <?php else: ?>
                    <p class="text-info">El dato no existe</p>
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