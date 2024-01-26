<?php
include_once("./libros.php");
include_once("./config.php");
include_once("./autores.php");
include_once("./seguridad.php");
$page_name = 'Insertar libro';

// Establecer la conexión con la base de datos
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
$acceso = new seguridad($conexion);
if($acceso->nivelPermiso()<2){
    header("Location: acceso-denegado.php");
}
// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

//función que sanitice los datos recibidos por post
function sanitizarDatos($datos){
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

$autores = new Autores($conexion);
$datosAutores = $autores->consultarAutores();
//insertar los libros en la base de datos sanitizando los datos con la función anterior y usando la función insertarLibro de la clase Libros
if(isset($_POST['Insertar'])){
    $titulo = sanitizarDatos($_POST['titulo']);
    $genero = sanitizarDatos($_POST['genero']);
    $autor = sanitizarDatos($_POST['autor']);
    $numPaginas = sanitizarDatos($_POST['numPaginas']);
    $numEjemplares = sanitizarDatos($_POST['numEjemplares']);
    $libro = new Libros($conexion);
    $datosLibro = [];
    $datosLibro['titulo'] = $titulo;
    $datosLibro['genero'] = $genero;
    $datosLibro['idAutor'] = $autor;
    $datosLibro['numeroPaginas'] = $numPaginas;
    $datosLibro['numeroEjemplares'] = $numEjemplares;
    $libro->insertarLibro($datosLibro);
    header('Location: listar.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/insertar.css">
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
</head>
<body>
      <?php include 'php/header.php'; ?>

    <div class="main-container">
        <main>
        <form class="form" action="" method="post">
            <h2>Insertar nuevo libro</h2>
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <br>

        <label for="genero">Género:</label>
        <select id="genero" name="genero" required>
        <option value="" disabled selected hidden>Selecciona un género</option>
            <option value="Narrativa">Narrativa</option>
            <option value="Lírica">Lírica</option>
            <option value="Teatro">Teatro</option>
            <option value="Científico-Técnico">Científico-Técnico</option>
        </select>
        <br>

        <label for="autor">Autor:</label>
        
        <div class="autor">
        <select name="autor" id="autor" required>
            <option value="" disabled selected hidden>Selecciona un autor</option>
            <?php foreach($datosAutores as $autor){?>
                <option value="<?php echo $autor['idAutor']?>"><?php echo $autor['nombre'].' '.$autor['apellidos']?></option>
            <?php } ?>
        </select>
        <a href="./insertarAutor.php">Añadir nuevo autor</a>
        </div>
        <br>

        <label for="numPaginas">Número de Páginas:</label>
        <input type="number" id="numPaginas" name="numPaginas" min="1" step="1" required>
        <br>

        <label for="numEjemplares">Número de Ejemplares:</label>
        <input type="number" id="numEjemplares" name="numEjemplares" min="0" step="1" required>
        <br>

        <input class="btn" type="submit" value="Insertar" name="Insertar">
    </form>
        </main>
    </div>
    <?php include 'php/footer.php'; ?>
</body>
</html>