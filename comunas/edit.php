<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require('../class/conexion.php');//llamamos al archivo conexion.php
    require('../class/rutas.php');

    if (isset($_GET['id'])) {
        
        $id = (int) $_GET['id'];

        //si existe la region asociada al id recibido por GET en la tabla regiones
        $res = $mbd->prepare("SELECT c.id, c.nombre, c.region_id, r.nombre as region FROM comunas c INNER JOIN regiones r ON c.region_id = r.id WHERE c.id = ?");
        $res->bindParam(1, $id);
        $res->execute();

        $comuna = $res->fetch();

        //lista de regiones
        $res = $mbd->query("SELECT id, nombre FROM regiones ORDER BY nombre");
        $regiones = $res->fetchall();

        //preguntaremos si los datos vienen via post 
        //preguntaremos por la variable confirm y si el valor de esa variable es 1
        //usamos el operador logico y (&&) para comprobar que ambas condiciones sean verdaderas obligatoriamente
        if (isset($_POST['confirm']) && $_POST['confirm'] == 1 ) {
            # code...
            /* echo '<pre>';
            print_r($_POST);exit;
            echo '</pre>'; */

            //recuperando y guardando el dato del nombre de la region
            //strips_tags => elimina las etiquetas de html y php en una cadena de caracteres
            //trim => elimina los espacios en blanco antes y despues del dato que recibimos 
            $nombre = trim(strip_tags($_POST['nombre'])); //proceso de sanitizacion de datos desde el servidor
            $region = (int) $_POST['region'];
            
            if (!$nombre) {
                //creamos una variable con el mensaje de error
                $msg = 'Debe ingresar el nombre de la comuna';
            }elseif ($region <= 0) {
                $msg = 'Seleccione la región';
            }else{
                //procedemos a modificar los datos de la comuna
                $res = $mbd->prepare("UPDATE comunas SET nombre = ?, region_id = ?, updated_at = now() WHERE id = ?");
                $res->bindParam(1, $nombre);
                $res->bindParam(2, $region);
                $res->bindParam(3, $id);
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
                <h2>Editar Región</h2>
                <!-- get => el envio del dato se hace via url del sistema
                post => el envio del dato se hace via interna -->
                <?php if(isset($msg)): ?>
                    <p class="alert alert-danger">
                        <?php echo $msg; ?>
                    </p>
                <?php endif; ?>

                <?php if($comuna): ?>
                    <form action="" method="post">
                        <div class="row mb-3">
                            <label for="region" class="col-md-2 col-form-label">Comuna <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <input type="text" name="nombre" value="<?php echo $comuna['nombre']; ?>" class="form-control" placeholder="Ingrese el nombre de la comuna">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="region" class="col-md-2 col-form-label">Región <span class="text-danger"> * </span> </label>
                            <div class="col-md-10">
                                <select name="region" class="form-control">
                                    <option value="<?php echo $comuna['region_id']; ?>">
                                        <?php echo $comuna['region']; ?>
                                    </option>

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