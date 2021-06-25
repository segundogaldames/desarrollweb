<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require('../class/conexion.php');//llamamos al archivo conexion.php
    require('../class/rutas.php');

    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $clave = trim(strip_tags($_POST['clave']));

        if (!$email) {
            $msg = 'Ingrese su correo electrónico';
        }elseif (!$clave) {
            $msg = 'Ingrese su password';
        }else {
            //verificamos que el email y password ingresado existen en la base de datos
            $clave = sha1($clave);

            $res = $mbd->prepare("SELECT u.id, p.nombre, p.email, r.nombre as rol FROM usuarios u INNER JOIN personas p ON u.persona_id = p.id INNER JOIN roles r ON p.rol_id = r.id WHERE p.email = ? AND u.clave = ? AND u.activo = 1");
            $res->bindParam(1, $email);
            $res->bindParam(2, $clave);
            $res->execute();

            $usuario = $res->fetch();

            if ($usuario) {
                //creamos las variables de session de php
            }else{
                $msg = 'El email o el password no estan registrados';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
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
                <h2>Nuevo Usuario</h2>
                <!-- get => el envio del dato se hace via url del sistema
                post => el envio del dato se hace via interna -->

                <?php if(isset($msg)): ?>
                    <p class="alert alert-danger">
                        <?php echo $msg; ?>
                    </p>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="row mb-3">
                        <label for="email" class="col-md-2 col-form-label">Email <span class="text-danger"> * </span> </label>
                        <div class="col-md-10">
                            <input type="email" name="email" class="form-control" placeholder="Ingrese su correo electrónico">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="clave" class="col-md-2 col-form-label">Password <span class="text-danger"> * </span> </label>
                        <div class="col-md-10">
                            <input type="password" name="clave" class="form-control" placeholder="Ingrese su password">
                        </div>
                    </div>
                    <!-- este campo hidden nos ayudara a comprobar que los datos del formularios sean enviados por post -->
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-primary"> Ingresar </button>
                </form>
            </div>

        </section>

        <!-- pie de pagina -->
        <footer>
            <h3>Desarrollo Web 2021</h3>
        </footer>
    </div>

</body>
</html>