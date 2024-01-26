<?php
include 'config.php';
include 'seguridad.php';
include 'usuarios.php';
$page_name = 'Editar usuario';
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
$acceso = new seguridad($conexion);
if ($acceso->nivelPermiso() < 3) {
    if ($_SESSION['login'] != $_REQUEST['login']) {
        header("Location: acceso-denegado.php");
    }
}
if (isset($_GET['login'])) {
    $usuarios = new usuarios($conexion);
    $login = $conexion->real_escape_string($_GET['login']);
    $datosUsuario = $usuarios->consultarUsuarios($login)[0];
} else {
    $datosUsuario = $usuarios->consultarUsuarios($_SESSION['login'])[0];
}

if (isset($_POST['Actualizar'])) {
    $usuarios = new usuarios($conexion);
    $salt = random_int(-1000000, 1000000);
    $password = hash('sha1', $_POST['password'] . $salt);
    $nuevosDatosUsuario = [
        'login' => $conexion->real_escape_string($_POST['login']),
        'nombre' => $conexion->real_escape_string($_POST['nombre']),
        'apellidos' => $conexion->real_escape_string($_POST['apellidos'])
    ];

    if ($datosUsuario['password'] == hash('sha1', $_POST['password'] . $datosUsuario['salt'])) {
        if ($_POST['password-new'] == $_POST['password-repeat']) {
            $nuevosDatosUsuario['salt'] = $salt;
            $nuevosDatosUsuario['password'] = hash('sha1', $_POST['password-new'] . $salt);
        }
    }

    $usuarios->actualizarUsuario($nuevosDatosUsuario); //voy por aquí. Si el login es el mismo que el de la sesión hay que repetir la contraseña
    if ($acceso->nivelPermiso() < 3) {
        header("Location: logout.php");
    } else {
        header("Location: gestion-usuarios.php");
    }
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
    <link rel="stylesheet" href="css/editar-usuario.css">
</head>

<body>
    <?php include 'php/header.php'; ?>
    <div class="main-container">
        <main>

            <form class="form" action="" method="post">
                <h2>Actualización de datos de usuario</h2>
                <br>
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" value="<?php echo $datosUsuario['login']; ?>" readonly>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $datosUsuario['nombre']; ?>">

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $datosUsuario['apellidos']; ?>">


                <?php if ($datosUsuario['login'] == $_SESSION['login']) {
                    echo "<label for='password-new'>Contraseña nueva:</label>";
                    echo "<input type='password' id='password-new' name='password-new'>";

                    echo "<label for='password-repeat'>Repetir contraseña:</label>";
                    echo "<input type='password' id='password-repeat' name='password-repeat'>";

                    echo "<label for='password'>Contraseña actual:</label>";
                    echo "<input type='password' id='password' name='password'>";
                } ?>
                <input class="btn" type="submit" value="Actualizar" name="Actualizar">
            </form>


        </main>
    </div>
    <?php include 'php/footer.php'; ?>
</body>

</html>