<?php
    include 'config.php';
    include 'seguridad.php';
    include 'usuarios.php';

    if(isset($_GET['login'])){
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
        $usuarios = new usuarios($conexion);
        $usuarios->eliminarUsuario($_GET['login']);

    }
    header("Location: gestion-usuarios.php");
    ?>