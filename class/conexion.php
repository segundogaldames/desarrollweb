<?php
$usuario = 'root';
$password = 'root';

try {
    $mbd = new PDO('mysql:host=localhost;dbname=desarrolloweb', $usuario, $password);
    /* foreach($mbd->query('SELECT * from FOO') as $fila) {
        print_r($fila);
    }
    $mbd = null; */
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>