<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/config-setup.css">
</head>

<body>

    <!--Formulario que pida los datos de usuario administrador-->
    
    <?php
include_once("./libros.php");
include_once("./autores.php");
$page_name = 'Configuración de la base de datos';

// Establecer la conexión con la base de datos
if (!file_exists('config.php')) {
    echo '<main>
    <h1>Bienvenido</h1>
    <p>Para comenzar con la instalación, por favor <br>introduzca los datos de conexión a la base de datos</p>
    <form class="form" action="" method="post">
        <label for="host">Host:</label>
        <input type="text" id="host" name="host" required>
        <br>
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="database">Base de datos:</label>
        <input type="text" id="database" name="database" required>
        <br>
        <label for="port">Puerto:</label>
        <input type="text" id="port" name="port" value="3306" required>
        <input class="btn" type="submit" value="conectar" name="conectar">
    </form>
    </main>';

    if (isset($_POST['conectar'])) {
        $conexion = mysqli_connect($_POST['host'], $_POST['usuario'], $_POST['password'], $_POST['database'], $_POST['port']);
        // Verificar si la conexión fue exitosa
        if (!$conexion) {
            die("Error al conectar con la base de datos: " . mysqli_connect_error());
        } else {
            echo "Conexión exitosa";
            // Crear el archivo config.php para guardar las variables con los valores recibidos. Funciones php usadas. fopen, fwrite y fclose.
            $config = fopen("./config.php", "w") or die("Unable to open file!");
            $txt = "<?php\n";
            $txt .= "// Configuración de los parámetros de Sistema Gestor de Bases de datos\n";
            $txt .= "define('DB_HOST','" . $_POST['host'] . "');\n";
            $txt .= "define('DB_USER','" . $_POST['usuario'] . "');\n";
            $txt .= "define('DB_PASS','" . $_POST['password'] . "');\n";
            $txt .= "define('DB_DATABASE','" . $_POST['database'] . "');\n";
            $txt .= "define('DB_PORT','" . $_POST['port'] . "');\n";
            $txt .= "?>";
            fwrite($config, $txt);
            fclose($config);
            include_once('./config.php');
            $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);
                $contenido_sql = file_get_contents('tablas.sql');
                $consultas = explode(';', $contenido_sql);
                foreach ($consultas as $consulta) {
                    if (!empty(trim($consulta))) {
                        $result = $conexion->query($consulta);

                        if (!$result) {
                            echo "Error en la consulta: " . $conexion->error;
                        }
                    }
                }
                header("Location: ./config-setup.php");
        }
        header("Location: ./config-setup.php");
    }
    
} else {
    include_once('./config.php');
    echo '<main>
    <h1>Escriba los datos del administrador</h1>
    <form class="form" action="" method="post">
        <label for="login">Login: </label>
        <input type="text" name="login" id="" required>
        <br>
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="" required>
        <br>
        <label for="apellidos">Apellidos: </label>
        <input type="text" name="apellidos" id="" required>
        <br>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="" required>
        <br>
        <input class="btn" type="submit" value="guardar" name="guardar">
    </form>
    </main>';
}

if (isset($_POST['guardar'])) {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);
    $login = $conexion->real_escape_string($_POST['login']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellidos = $conexion->real_escape_string($_POST['apellidos']);
    $password = $conexion->real_escape_string($_POST['password']);
    $salt = random_int(-1000000,1000000);
    // El campo password será almacenado como resultado de la función el hash en formato sha256 del la contraseña que nos de el usuario concatenado con el campo salt.
    $password = hash('sha1', $password.$salt);
    $rol = 'administrador';
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);
    $sql = "INSERT INTO usuarios (`login`, `nombre`,`apellidos`, `salt`, `password`, `rol`) VALUES ('$login', '$nombre','apellidos', '$salt', '$password', '$rol')";
    if ($conexion->query($sql)) {
        /*unlink('./config-setup.php');*/
        header("Location: ./index.php");
    }
}
?>
</body>

</html>