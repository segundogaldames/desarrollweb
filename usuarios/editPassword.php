<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    require('../class/conexion.php');//llamamos al archivo conexion.php
    require('../class/rutas.php');

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        $res = $mbd->prepare("SELECT id, persona_id FROM usuarios WHERE id = ?");
        $res->bindParam(1, $id);
        $res->execute();

        $usuario = $res->fetch();

        if (isset($_POST['confirm']) && $_POST['confirm'] == 1 ) {
            $clave = trim(strip_tags($_POST['clave']));
            $reclave = trim(strip_tags($_POST['reclave']));

            if (strlen($clave) < 8) {
                $msg = 'El password no puede ser inferior a 8 caracteres';
            }elseif ($reclave != $clave) {
                $msg = 'Los passwords ingresados no coinciden';
            }else {
                //encriptacion de clave
                $clave = sha1($clave);
                //actualizamos la contraseña del usuario
                $res = $mbd->prepare("UPDATE usuarios SET clave = ?, updated_at = now() WHERE id = ?");
                $res->bindParam(1, $clave);
                $res->bindParam(2, $id);
                $res->execute();

                $row = $res->rowCount();

                if ($row) {
                    $_SESSION['success'] = 'El password se ha modificado correctamente';
                    header('Location: ../personas/show.php?id=' . $usuario['persona_id']);
                }
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
                <h2>Nueva Password</h2>
                <!-- get => el envio del dato se hace via url del sistema
                post => el envio del dato se hace via interna -->

                <?php if(isset($msg)): ?>
                    <p class="alert alert-danger">
                        <?php echo $msg; ?>
                    </p>
                <?php endif; ?>

                <?php if(!empty($usuario)): ?>
                    <form action="" method="post">
                        <div class="row mb-3">
                            <label for="clave" class="col-md-2 col-form-label">Password <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="password" name="clave" class="form-control" placeholder="Ingrese un password de al menos 8 caracteres">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="reclave" class="col-md-2 col-form-label">Confirmar password <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="password" name="reclave" class="form-control" placeholder="Confirme el password">
                            </div>
                        </div>
                        <!-- este campo hidden nos ayudara a comprobar que los datos del formularios sean enviados por post -->
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-primary"> Guardar </button>
                        <a href="../personas/show.php?id=<?php echo $usuario['persona_id']; ?>" class="btn btn-link">Volver</a>
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