<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../class/conexion.php');
require('../class/rutas.php');

if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
    $id = (int) $_POST['id'];

    //verificar que el dato existe en la tabla roles
    $res = $mbd->prepare("SELECT id FROM roles WHERE id = ?");
    $res->bindParam(1, $id);
    $res->execute();

    $rol = $res->fetch();

    if ($rol) {
        //eliminamos el rol
        $res = $mbd->prepare("DELETE FROM roles WHERE id = ?");
        $res->bindParam(1, $id);
        $res->execute();

        $row = $res->rowCount();

        if ($row) {
           $msg = 'ok';
           header('Location: index.php?d=' . $msg);
        }
    }else{
        $msg = 'error';
        header('Location: index.php?e=' . $msg);
    }
    //print_r($id);
}