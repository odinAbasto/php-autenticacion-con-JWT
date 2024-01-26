<?php
$page_name = 'Registro';

require_once 'config.php';
require_once 'usuarios.php';
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
if (isset($_GET['login'])) {
    $login = $_GET['login'];
    if (strlen($login) >= 4) {
        $usuario = new Usuarios($conexion);
        if ($usuario->usuarioExiste($login)) {
            exit('Nombre de usuario no disponible');
        } else {
            exit('Nombre disponible');
        }
    }
    exit;
}

if(isset($_POST['registrar'])){
    $login = $_POST['login'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $salt = random_int(-1000000,1000000);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if($login && $nombre && $apellidos && $password && $password2){
        if($password == $password2){
            $password = hash('sha1', $password . $salt);
            $datosUsuario = array('login'=>$login,'nombre'=>$nombre,'apellidos'=>$apellidos,'salt'=>$salt,'password'=>$password,'rol'=>'registrado');
            $usuario = new Usuarios($conexion);
            if($usuario->insertarUsuario($datosUsuario)){
                header("Location: autenticacion.php");
            }else{
                echo "Error al insertar el usuario";
            }
        }else{
            echo "Las contraseñas no coinciden";
        }
    }else{
        echo "Rellene todos los campos";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/autenticacion.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/registro.css">
</head>

<body>
    <?php include("php/header.php"); ?>
    <main style="flex:1; display:grid; align-content:center;">
        <form class="form" action="registro.php" method="POST" onsubmit="return validar(this)">
            <h2>Registrarse</h2>
            <div class="message"></div>
            <label for="login">Nombre de usuario:</label>
            <input type="text" name="login" onkeyup="validarUsuario(this)" />
            
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" />
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" />
            <label for="password">Contraseña:</label>
            <input type="password" name="password" />
            <label for="password2">Confirmar Contraseña:</label>
            <input type="password" name="password2" />
            <input class="btn" type="submit" name="registrar" value="registrar" />
        </form>
    </main>
    <?php include("php/footer.php"); ?>
    <script>
        function validarUsuario(input) {
            let midiv = document.getElementsByClassName("message")[0];
            fetch(`registro.php?login=${input.value}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud: ' + response.status);
                    }
                    return response.text();
                })
                .then(data => {
                    // Manejar la respuesta
                    midiv.innerHTML = data;
                })
                .catch(error => {
                    // Manejar errores
                    console.error('Error:', error);
                });
        }

        function validar(formulario) {
            if (formulario.login.value.length < 4) {
                alert("El nombre de usuario debe tener al menos 6 caracteres");
                return false;
            }
            if (formulario.nombre.value.length == 0) {
                alert("Introduzca un nombre");
                return false;
            }
            if (formulario.apellidos.value.length == 0) {
                alert("Introduzca los apellidos");
                return false;
            }
            if (formulario.password.value.length < 4) {
                alert("La contraseña debe tener al menos 4 caracteres");
                return false;
            }
            if (formulario.password2.value.length < 4) {
                alert("La contraseña debe tener al menos 4 caracteres");
                return false;
            }
            if (formulario.password.value != formulario.password2.value) {
                alert("Las contraseñas no coinciden");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>