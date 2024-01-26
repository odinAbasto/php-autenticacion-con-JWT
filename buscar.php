<?php
include_once("./libros.php");
include_once("./config.php");
include_once("./autores.php");
include_once("./seguridad.php");
$page_name = 'Buscar libro';

// Establecer la conexión con la base de datos
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
$acceso = new seguridad($conexion);
if($acceso->nivelPermiso()==0){
    header("Location: acceso-denegado.php");
}
// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

//función que sanitice los datos recibidos por post
function sanitizarDatos($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

$autores = new Autores($conexion);
$libros = new Libros($conexion);
$datosAutores = $autores->consultarAutores();
$librosBuscados = $libros->consultarLibros();
if(isset($_GET['Buscar'])){

    $librosBuscados = $libros->consultarLibros(NULL,$_REQUEST['titulo'],$_REQUEST['genero'],$_REQUEST['idAutor'],$_REQUEST['numPaginas'],$_REQUEST['numEjemplares']);

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/buscar.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
</head>

<body>
    <?php include 'php/header.php'; ?>

   <div class="main-container">
   <main>
    <form class="form-line" action="" method="get">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo">
        <br>

        <label for="genero">Género:</label>
        <select id="genero" name="genero" >
            <option value="" disabled selected hidden>Selecciona un género</option>
            <option value="Narrativa">Narrativa</option>
            <option value="Lírica">Lírica</option>
            <option value="Teatro">Teatro</option>
            <option value="Científico-Técnico">Científico-Técnico</option>
        </select>
        <br>

        <label for="autor">Autor:</label>

        <div class="autor">
            <select name="idAutor" id="idAutor" >
                <option value="" disabled selected hidden>Selecciona un autor</option>
                <?php foreach ($datosAutores as $autor) { ?>
                    <option value="<?php echo $autor['idAutor']?>"><?php echo $autor['nombre'] . ' ' . $autor['apellidos'] ?></option>
                <?php } ?>
            </select>

            <br>
                </div>

            <input class="btn" type="submit" value="Buscar" name="Buscar">
    </form>
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
            <?php foreach ($librosBuscados as $libro) { ?>
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
                            echo "<td><a class='btn-danger' href='borrar.php?idLibro=" . $libro['idLibro'] . "'>Borrar</a>
                            <a class='btn' href='actualizar.php?idLibro=" . $libro['idLibro'] . "'>Actualizar</a></td>";
                      
                           }
                        ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
   </div>
    <?php include 'php/footer.php'; ?>
</body>

</html>