<?php
$page_name = 'Insertar autor';
include 'config.php';
include 'autores.php';
include_once 'seguridad.php';
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

$acceso = new seguridad($conexion);
   if($acceso->nivelPermiso()<2){
       header("Location: acceso-denegado.php");
   }

$autor = new Autores($conexion);
   
   
   
if (isset($_POST['Insertar'])) {
    $datosAutor = [];
    $datosAutor['nombre'] =  $conexion->real_escape_string($_POST['nombre']);
    $datosAutor['apellidos'] = $conexion->real_escape_string($_POST['apellidos']);
    $datosAutor['pais'] = $conexion->real_escape_string($_POST['pais']);
    $autor->insertarAutor($datosAutor);
    header('Location: insertar.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/insertarAutor.css">
    
</head>
<body>
    <?php include 'php/header.php'; ?>
    <div class="main-container">
    <main>
    <form class="form" action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>

        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" required>
        <br>
        <label for="pais">Pais:</label>
    <select id="pais" name="pais" required>
     <option value="selecciona" disabled selected hidden>Selecciona un pais</option>
        <option value="Estados Unidos">Estados Unidos</option>
        <option value="Reino Unido">Reino Unido</option>
        <option value="Francia">Francia</option>
        <option value="Rusia">Rusia</option>
        <option value="España">España</option>
        <option value="Alemania">Alemania</option>
        <option value="Italia">Italia</option>
        <option value="Japón">Japón</option>
        <option value="Argentina">Argentina</option>
        <option value="México">México</option>
        <option value="Colombia">Colombia</option>
        <option value="Chile">Chile</option>
        <option value="Brasil">Brasil</option>
        <option value="India">India</option>
        <option value="Canadá">Canadá</option>
        <option value="Suecia">Suecia</option>
        <option value="Noruega">Noruega</option>
        <option value="Dinamarca">Dinamarca</option>
        <option value="Grecia">Grecia</option>
        <option value="China">China</option>
        <option value="Australia">Australia</option>
        <option value="Egipto">Egipto</option>
        <option value="Nigeria">Nigeria</option>
        <option value="Sudáfrica">Sudáfrica</option>
        <option value="Portugal">Portugal</option>
    </select>
        <br>
        <input class="btn" type="submit" value="Insertar" name="Insertar">
    </form>
    </main>
    </div>

    <?php include 'php/footer.php'; ?>
</body>
</html>