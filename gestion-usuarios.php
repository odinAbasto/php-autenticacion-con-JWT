<?php
$page_name = 'Gestion de usuarios';
include_once 'config.php';
include_once 'usuarios.php';
include_once 'seguridad.php';
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
$access = new seguridad($conexion);

if($access->nivelPermiso()<3){
    header("Location: acceso-denegado.php");
}
$usuarios = new usuarios($conexion);
$datosUsuarios = $usuarios->consultarUsuarios();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/gestion-usuarios.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include 'php/header.php';?>
    <div class="main-container">
        <main>
        <a href="insertarUsuario.php">Registrar nuevo usuario</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($datosUsuarios as $usuario) { ?>
                <tr>
                    <td><?php echo $usuario['login']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellidos']; ?></td>
                    <td><?php echo $usuario['rol']; ?></td>
                    <td>
                        <a class="btn" href="editar-usuario.php?login=<?php echo $usuario['login']; ?>">Modificar</a>
                        <a class="btn-danger" href="<?php echo ($_SESSION['login'] == $usuario['login']) ? '#' : 'eliminar-usuario.php?login=' . $usuario['login']; ?>">Eliminar</a>

                         
                    </td>
                </tr>
            <?php 
        } ?>
            </tbody>
        </table>
       
        </main>
    </div>
    <?php include 'php/footer.php';?>
</body>
</html>