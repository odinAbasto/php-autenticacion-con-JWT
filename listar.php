<?php
$page_name = 'Listado de libros';
include_once 'config.php';
include_once 'libros.php';
include_once 'autores.php';
include_once 'seguridad.php';
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
    $acceso = new seguridad($conexion);

   if($acceso->nivelPermiso()<1){
       header("Location: acceso-denegado.php");
   }

   $libros = new libros($conexion);
   $autores = new autores($conexion);
   $datosLibros = $libros->consultarLibros();
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/listar.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include 'php/header.php';?>
    <div class="main-container">
    <main>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Genero</th>
                    <th>Autor</th>
                    <th>Numero de paginas</th>
                    <th>Numero de ejemplares</th>
                    <?php
                    if($acceso->nivelPermiso()>1){
                        echo '<th>Acciones</th>';
                    }
                    ?>
                </tr>
                
            </thead>
            <tbody>
            <?php foreach ($datosLibros as $libro) { ?>
                <?php $datosAutor =  $autores->consultarAutores($libro['idAutor'])[0];?>
                    <tr>
                    <td><?php echo $libro['idLibro']; ?></td>
                        <td><?php echo $libro['titulo']; ?></td>
                        <td><?php echo $libro['genero']; ?></td>
                        <td><?php echo $datosAutor['nombre']. " ".$datosAutor['apellidos']; ?></td>
                        <td><?php echo $libro['numeroPaginas']; ?></td>
                        <td><?php echo $libro['numeroEjemplares']; ?></td>
                        <?php
                        
                           if($acceso->nivelPermiso()>1){
                            echo "<td><a class='btn' href='borrar.php?idLibro=" . $libro['idLibro'] . "'>Borrar</a>
                            <a class='btn-danger' href='actualizar.php?idLibro=" . $libro['idLibro'] . "'>Actualizar</a></td>";
                      
                           }
                        ?>
                    </tr>
                <?php };
                $conexion->close();?>
            </tbody>
        </table>
        
    </main>
    
    </div>
    <?php include 'php/footer.php';?>
</body>
</html>

<!-- Aquí se construje el campo autor  imprimiendo un select multiple-->
 
<!--Al lado del selector de autores se puede poner un enlace al gestor de autores para agregar nuevos autores-->
