<?php
require('class/conexion.php');

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
           header('Location: roles.php?d=' . $msg);
        }
    }else{
        $msg = 'error';
        header('Location: roles.php?e=' . $msg);
    }
    //print_r($id);
}