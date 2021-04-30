<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require('../class/conexion.php');//llamamos al archivo conexion.php
    require('../class/rutas.php');

    if (isset($_GET['id'])) {
        
        $id = (int) $_GET['id'];

        //si existe rol asociado al id recibido por GET en la tabla roles
        $res = $mbd->prepare("SELECT id, nombre FROM roles WHERE id = ?");
        $res->bindParam(1, $id);
        $res->execute();

        $rol = $res->fetch();

        //preguntaremos si los datos vienen via post 
        //preguntaremos por la variable confirm y si el valor de esa variable es 1
        //usamos el operador logico y (&&) para comprobar que ambas condiciones sean verdaderas obligatoriamente
        if (isset($_POST['confirm']) && $_POST['confirm'] == 1 ) {
            # code...
            /* echo '<pre>';
            print_r($_POST);exit;
            echo '</pre>'; */

            //recuperando y guardando el dato del nombre del rol
            //strips_tags => elimina las etiquetas de html y php en una cadena de caracteres
            //trim => elimina los espacios en blanco antes y despues del dato que recibimos 
            $nombre = trim(strip_tags($_POST['nombre'])); //proceso de sanitizacion de datos desde el servidor
            
            if (!$nombre) {
                //creamos una variable con el mensaje de error
                $msg = 'Debe ingresar el nombre del rol';
            }else{
                //procedemos a modificar los datos del rol
                $res = $mbd->prepare("UPDATE roles SET nombre = ?, updated_at = now() WHERE id = ?");
                $res->bindParam(1, $nombre);
                $res->bindParam(2, $id);
                $res->execute();

                $row = $res->rowCount();

                if($row){
                    $msg = 'ok';
                    header('Location: show.php?id=' . $id . '&m=' . $msg );
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
                <h2>Editar Rol</h2>
                <!-- get => el envio del dato se hace via url del sistema
                post => el envio del dato se hace via interna -->

                <?php if($rol): ?>
                    <form action="" method="post">
                        <div class="row mb-3">
                            <label for="rol" class="col-md-2 col-form-label">Rol <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="text" name="nombre" value="<?php echo $rol['nombre']; ?>" class="form-control" placeholder="Ingrese el nombre del rol">
                                <!-- mostramos mensaje de error si es que existe -->
                                <?php if(isset($msg)): ?>
                                    <p class="text-danger">
                                        <?php echo $msg; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- este campo hidden nos ayudara a comprobar que los datos del formularios sean enviados por post -->
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-primary"> Editar </button>
                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-link"> Volver </a>
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