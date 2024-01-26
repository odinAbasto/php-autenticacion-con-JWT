<?php
    class usuarios{
        private $conexion;
        public function __construct($conexion= NULL){
            $this->conexion = $conexion;
        }
        public function insertarUsuario($datosUsuario){
            $sql = "INSERT INTO usuarios (`login`,`nombre`,`apellidos`,`salt`,`password`,`rol`) VALUES ('$datosUsuario[login]','$datosUsuario[nombre]','$datosUsuario[apellidos]','$datosUsuario[salt]','$datosUsuario[password]','$datosUsuario[rol]');";
            return $this->conexion->query($sql);
        }
        public function actualizarUsuario($datosUsuario) {
            $miSet = "SET ";
            if ($datosUsuario['nombre']) {
                $miSet .= "nombre = '$datosUsuario[nombre]', ";
            }
            if ($datosUsuario['apellidos']) {
                $miSet .= "apellidos = '$datosUsuario[apellidos]', ";
            }
            if ($datosUsuario['salt']) {
                $miSet .= "salt = '$datosUsuario[salt]', ";
            }
            if ($datosUsuario['password']) {
                $miSet .= "password = '$datosUsuario[password]', ";
            }
            $miSet = substr($miSet,0,-2);
            $sql = "UPDATE usuarios $miSet WHERE login = '$datosUsuario[login]';";
            return $this->conexion->query($sql);
        }
    
        public function eliminarUsuario($login){
            $sql = "DELETE FROM `usuarios` WHERE `login` = '$login';";
            return $this->conexion->query($sql);
        }
        public function consultarUsuarios($login=NULL,$nombre=NULL,$apellidos=NULL,$rol=NULL){
            if($login){
                $sql="SELECT * FROM usuarios WHERE `login` = '$login';";
                $datos=$this->conexion->query($sql);
                return $datos->fetch_all(MYSQLI_ASSOC);
            }else{
                $miWhere = "WHERE ";
                if($nombre){
                    $miWhere .= "nombre = '$nombre' AND ";
                }
                if($apellidos){
                    $miWhere .= "apellidos = '$apellidos' AND ";
                }
                if($rol){
                    $miWhere .= "rol = '$rol' AND ";
                }
                if($miWhere == "WHERE "){ 
                    $miWhere = "";
                }else{
                $miWhere = substr($miWhere, 0, -5);
                }
                $sql = "SELECT * FROM usuarios $miWhere order by apellidos;";
                $datos = $this->conexion->query($sql);
                return $datos->fetch_all(MYSQLI_ASSOC);
            }
        }
        public function usuarioExiste($login){
            $sql = "SELECT * FROM usuarios WHERE `login` = '$login';";
            $datos = $this->conexion->query($sql);
            if($datos->num_rows > 0){
                return true;
            }else{
                return false;
            }
        }
    }
?>