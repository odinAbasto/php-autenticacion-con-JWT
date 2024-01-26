<?php
include_once 'config.php';
include_once 'libros.php';
include_once 'seguridad.php';
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
$acceso = new seguridad($conexion);
   if($acceso->nivelPermiso()<2){
       header("Location: acceso-denegado.php");
   }else{
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
    $libros = new libros($conexion);
    $libros->eliminarLibro($_GET['idLibro']);
    header('Location: listar.php');
   }
   
    
?>
