<?php
include_once("config.php");
$page_name= "Autenticación";
// Si ha pulsado el boton entrar

if(isset($_POST['entrar'])){
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
        $login = $conexion->real_escape_string($_POST['login']);
        $password = $conexion->real_escape_string($_POST['password']);
        $consulta = "SELECT `salt` from usuarios where login='$login'";
        $salt = $conexion->query($consulta)->fetch_assoc()['salt'];
        $consulta = "SELECT * FROM usuarios WHERE login='$login' AND `password`=sha1(CONCAT('$password', '$salt'))";
        $resultado = $conexion->query($consulta);
        if($resultado->num_rows > 0){
                session_start();
                $_SESSION['rol'] = $resultado->fetch_assoc()['rol'];
                $_SESSION['login'] = $login;
                header("Location: index.php"); 

}}

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
        <link rel="stylesheet" href="css/autenticacion.css">
</head>
<body>
<?php include("php/header.php"); ?>
        <div class="main-container">
                <main>
                        
                        <form class="form" method="POST" id="formularioAutenticacion" >
                        <h2>login</h2>
                        <label for="login">Nombre de usuario:</label>
                        <input type="text" name="login" />
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password"/>
                        <input class="btn" type="submit" name="entrar" value="entrar"/>	
                        </form>
                </main>
        </div>
<?php include("php/footer.php"); ?>
</body>
</html>
