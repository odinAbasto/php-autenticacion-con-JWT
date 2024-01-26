<?php
    class autores{
        private $conexion;
        public function __construct($conexion= NULL){
            $this->conexion = $conexion;
        }
        public function insertarAutor($datosAutor){
            $sql = "INSERT INTO autores (idAutor,nombre,apellidos,pais) VALUES (NULL,'$datosAutor[nombre]','$datosAutor[apellidos]','$datosAutor[pais]');";
            return $this->conexion->query($sql);
        }
        public function actualizarAutor($datosAutor){
            $miSet="SET ";
            if($datosAutor['nombre']){
                $miSet.="nombre='$datosAutor[nombre]',";
            }
            if($datosAutor['apellidos']){
                $miSet.="apellidos='$datosAutor[apellidos]',";
            }
            if($datosAutor['pais']){
                $miSet.="pais='$datosAutor[pais]',";
            }

        }
        public function eliminarAutor($idAutor){
            $sql = "DELETE FROM autores WHERE idAutor = $idAutor;";
            return $this->conexion->query($sql);
        }
        public function consultarAutores($idAutor=NULL,$nombre=NULL,$apellidos=NULL,$pais=NULL){
            if($idAutor){
                $sql="SELECT * FROM autores WHERE idAutor = $idAutor;";
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
                if($pais){
                    $miWhere .= "pais = '$pais' AND ";
                }
                if($miWhere == "WHERE "){ 
                    $miWhere = "";
                }else{
                $miWhere = substr($miWhere, 0, -5);
                }
                $sql = "SELECT * FROM autores $miWhere order by Apellidos;";
                $datos = $this->conexion->query($sql);
                return $datos->fetch_all(MYSQLI_ASSOC);
            }
        }
    }
?>