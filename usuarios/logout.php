<?php

require('../class/rutas.php');

session_start();

if (isset($_SESSION['autenticado'])) {
    session_destroy();
}

echo "<script>
    alert('Su sesión se ha se cerrado correctamente');
    window.location = 'http://localhost:8080/desarrollweb/';
    </script>";
