<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require('../class/conexion.php');//llamamos al archivo conexion.php
    require('../class/rutas.php');

    //lista de regiones
    $res = $mbd->query("SELECT id, nombre FROM regiones ORDER BY nombre");
    $regiones = $res->fetchall();


    //preguntaremos si los datos vienen via post 
    //preguntaremos por la variable confirm y si el valor de esa variable es 1
    //usamos el operador logico y (&&) para comprobar que ambas condiciones sean verdaderas obligatoriamente
    if (isset($_POST['confirm']) && $_POST['confirm'] == 1 ) {
        
        $nombre = trim(strip_tags($_POST['nombre']));
        $region = (int) $_POST['region'];

        if (!$nombre) {
            $msg = 'Ingrese el nombre de la comuna';
        }elseif ($region <= 0) {
            $msg = 'Seleccione la región';
        }else {
            //validar que la comuna ingresada no exista
            $res = $mbd->prepare("SELECT id FROM comunas WHERE nombre = ?");
            $res->bindParam(1, $nombre);
            $res->execute();

            $comuna = $res->fetch();

            if ($comuna) {
                $msg = 'La comuna ingresada ya existe... intente con otra';
            }else {
                //registrar la comuna 
                $res = $mbd->prepare("INSERT INTO comunas VALUES(null, ?, ?, now(), now() )");
                $res->bindParam(1, $nombre);
                $res->bindParam(2, $region);
                $res->execute();

                $row = $res->rowCount();

                if ($row) {
                    $msg = 'ok';
                    header('Location: index.php?m=' . $msg);
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
    <title>Comunas</title>
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
                <h2>Nueva Comuna</h2>
                <!-- get => el envio del dato se hace via url del sistema
                post => el envio del dato se hace via interna -->
                <?php if(isset($msg)): ?>
                    <p class="alert alert-danger">
                        <?php echo $msg; ?>
                    </p>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="row mb-3">
                        <label for="comuna" class="col-md-2 col-form-label">Comuna <span class="text-danger"> * </span> </label>
                        <div class="col-md-10">
                            <input type="text" name="nombre" value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" class="form-control" placeholder="Ingrese el nombre de la comuna">
                            <!-- mostramos mensaje de error si es que existe -->
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="region" class="col-md-2 col-form-label">Región <span class="text-danger"> * </span> </label>
                        <div class="col-md-10">
                            <select name="region" class="form-control">
                                <option value="">Seleccione...</option>

                                <?php foreach($regiones as $region): ?>
                                    <option value="<?php echo $region['id']; ?>">
                                        <?php echo $region['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            
                            </select>
                        </div>
                    </div>
                    <!-- este campo hidden nos ayudara a comprobar que los datos del formularios sean enviados por post -->
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-primary"> Guardar </button>
                    <a href="index.php" class="btn btn-link">Volver</a>
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