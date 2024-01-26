<?php
$page_name = 'Página principal de la biblioteca';
include_once('./config.php');
if(!file_exists('config.php')){
    header("Location: ./config-setup.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
</head>


<body>
    <?php include 'php/header.php'; ?>
    <div class="main-container">
        <main>
            <h2>Bienvenido a la página principal</h2>
            <?php
            session_start();
            if (!isset($_SESSION['login'])) {
                echo "<p>Debe autenticarse para poder acceder a la pagina. Haga click <a href='autenticacion.php' style='text-decoration:underline;'>aquí</a> o  <a href='registro.php' style='text-decoration:underline;'>regístrate</a> </p>";
            }else{
                $conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);
                if (!$conexion) {
                    die("Error al conectar con la base de datos: " . mysqli_connect_error());
                }
                $consulta = "SELECT * FROM usuarios WHERE login='".$_SESSION['login']."'";
                $usuario=$conexion->query($consulta);
                $usuario=$usuario->fetch_assoc();

                echo "<h3>".$usuario['nombre']."</h3>";
                echo "<p>Has iniciado sesion como usuario: ".$_SESSION['rol']."</p>";
            }
            ?>
        </main>
    </div>
    <?php include 'php/footer.php'; ?>
</body>

</html>