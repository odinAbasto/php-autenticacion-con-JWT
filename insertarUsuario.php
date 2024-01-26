
<?php
include_once 'config.php';
include_once 'usuarios.php';
include_once 'seguridad.php';
$page_name = 'Insertar usuario';
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
$acceso = new seguridad($conexion);
if($acceso->nivelPermiso()<3){
    header("Location: acceso-denegado.php");
}

if(isset($_REQUEST['Insertar'])){
    $usuarios = new usuarios($conexion);
    $salt = random_int(-1000000,1000000);
    $password = hash('sha1', $_POST['password'] . $salt);
    $datosUsuario=[
    'login'=>$conexion->real_escape_string($_REQUEST['login']),
    'nombre'=>$conexion->real_escape_string($_REQUEST['nombre']),
    'apellidos'=>$conexion->real_escape_string($_REQUEST['apellidos']),
    'salt'=>$salt,
    'password'=>$password,
    'rol'=>$conexion->real_escape_string($_REQUEST['rol'])
];
$usuarios->insertarUsuario($datosUsuario);
header("Location: gestion-usuarios.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/insertarUsuario.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">

</head>
<body>
    <?php include 'php/header.php'; ?>
    <div class="main-container">
        <main>
            <form class="form" action="" method="post">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre">
                
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos">

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password">
                
                <label for="rol">Rol:</label>
                <select name="rol" id="rol">
                    <option value="registrado">Registrado</option>
                    <option value="bibliotecario">Bibliotecario</option>
                    <option value="administrador">Administrador</option>
                </select>
                
                <input class="btn" type="submit" value="Insertar" name="Insertar">
            </form>
        </main>
    </div>
    <?php include 'php/footer.php'; ?>
</body>
</html>