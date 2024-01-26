<?php
/** Clase para implementar la seguridad de acceso a partes de una AW
 *haremos uso de sesiones php, Credenciales de BD, y Roles de sistema.
 *
 */
class seguridad
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function nivelPermiso(){
        // Verifica si el usuario tiene el rol requerido para acceder a la funcionalidad.
        // Devuelve true si tiene permiso, false en caso contrario.

        // Asegúrate de haber iniciado sesión antes de llamar a esta función.
        session_start();

        // Verifica si la sesión contiene la información del usuario.
        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];

            // Consulta el rol del usuario en la base de datos.
            $consulta = "SELECT rol FROM usuarios WHERE login='$login'";
            $resultado = $this->conexion->query($consulta);

            if ($resultado) {
                $fila = $resultado->fetch_assoc();
                $rolUsuario = $fila['rol'];

                // Compara el rol del usuario con el rol requerido.
                if ($rolUsuario == 'administrador') {
                    return 3; // El usuario tiene el rol requerido.
                } elseif ($rolUsuario == 'bibliotecario') {
                    return 2;
                } elseif ($rolUsuario == 'registrado') {
                    return 1;
                }
            }else {
               return 0;
            }
        }else{
            return 0;
        }
    }
}
  
?>
