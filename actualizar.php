<?php
include_once("./libros.php");
include_once("./config.php");
include_once("./autores.php");
$page_name = 'Actualizar libro';

$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
if ($conexion->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error; 
}
include_once 'seguridad.php';
   $acceso = new seguridad($conexion);
   if($acceso->nivelPermiso()<2){
       header("Location: acceso-denegado.php");
   }

$libro = new Libros($conexion);
$autor = new Autores($conexion);

$libroActualizar = $libro->consultarLibros($_GET['idLibro'])[0];
$autorLibroActualizar = $autor->consultarAutores($libroActualizar['idAutor'])[0];
$autores = $autor->consultarAutores();


if(isset($_POST['Actualizar'])){
    $datosLibro = [
        'titulo' => $conexion->real_escape_string($_POST['titulo']),
        'genero' => $conexion->real_escape_string($_POST['genero']),
        'idAutor' =>$conexion->real_escape_string($_POST['idAutor']),
        'numPaginas' =>$conexion->real_escape_string($_POST['numPaginas']),
        'numEjemplares' => $conexion->real_escape_string($_POST['numEjemplares']),
        'idLibro' =>  $_GET['idLibro']
    ];
    $libro->actualizarLibro($datosLibro);
    header('Location: listar.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/actualizar.css">
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
</head>

<body>
    <?php include 'php/header.php'; ?>

   <div class="main-container">
        <main>
        <form class="form" action="" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo $libroActualizar['titulo']; ?>" required>
        <br>
        <label for="genero">Género:</label>
        <select id="genero" name="genero">
            <option value="<?php echo $libroActualizar['genero']; ?> "><?php echo $libroActualizar['genero']; ?></option>
            <option value="Narrativa">Narrativa</option>
            <option value="Lírica">Lírica</option>
            <option value="Teatro">Teatro</option>
            <option value="Científico-Técnico">Científico-Técnico</option>
        </select>
        <br>
        <label for="idAutor">Autor:</label>
        <select id="idAutor" name="idAutor">
            <option value="<?php echo $autorLibroActualizar['idAutor']; ?>"><?php echo $autorLibroActualizar['nombre'] . " " . $autorLibroActualizar['apellidos']; ?></option>
            
            <?php foreach ($autores as $autor) { ?>
                <option value="<?php echo $autor['idAutor']; ?>"><?php echo $autor['nombre'] . " " . $autor['apellidos']; ?></option>
            <?php } ?>

        </select>
        <br>
        <label for="numPaginas">Número de Páginas:</label>
        <input type="number" id="numPaginas" name="numPaginas" min="1" step="1" value="<?php echo $libroActualizar['numeroPaginas']; ?>" required>
        <br>

        <label for="numEjemplares">Número de Ejemplares:</label>
        <input type="number" id="numEjemplares" name="numEjemplares" min="0" step="1" value="<?php echo $libroActualizar['numeroEjemplares']; ?>" required>
        <br>
        <?php $POST['idLibro'] = $_GET['idLibro'] ?>
        <input class="btn" type="submit" value="Actualizar" name="Actualizar">
    </form>
        </main>
   </div>
    <?php include 'php/footer.php'; ?>

</body>

</html>