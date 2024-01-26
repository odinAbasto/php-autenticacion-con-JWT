<?php
    class Libros {
        private $conexion;
    
        public function __construct($conexion = null) {
            $this->conexion = $conexion;
        }
    
        public function insertarLibro($datosLibro) {
            $sql = "INSERT INTO libros (idLibro, titulo, genero, idAutor, numeroPaginas, numeroEjemplares) VALUES (NULL, '$datosLibro[titulo]', '$datosLibro[genero]', '$datosLibro[idAutor]', '$datosLibro[numeroPaginas]', '$datosLibro[numeroEjemplares]');";
            return $this->conexion->query($sql);
        }
    
        public function actualizarLibro($datosLibro) {
            $miSet = "SET ";
            if ($datosLibro['titulo']) {
                $miSet .= "titulo = '$datosLibro[titulo]', ";
            }
            if ($datosLibro['genero']) {
                $miSet .= "genero = '$datosLibro[genero]', ";
            }
            if ($datosLibro['idAutor']) {
                $miSet .= "idAutor = '$datosLibro[idAutor]', ";
            }
            if ($datosLibro['numPaginas']) {
                $miSet .= "numeroPaginas = '$datosLibro[numPaginas]', ";
            }
            if ($datosLibro['numEjemplares']) {
                $miSet .= "numeroEjemplares = '$datosLibro[numEjemplares]', ";
            }
            $miSet = substr($miSet,0,-2);
            $sql = "UPDATE libros $miSet WHERE idLibro = $datosLibro[idLibro];";
            return $this->conexion->query($sql);
        }
    
        public function eliminarLibro($idLibro) {
            $sql = "DELETE FROM libros WHERE idLibro = '$idLibro';";
            return $this->conexion->query($sql);
        }
    

        public function consultarLibros($idLibro=NULL,$titulo=NULL, $genero=NULL, $idAutor=NULL, $numPaginas=NULL, $numEjemplares=NULL){

            $miWhere = "WHERE ";
            if($idLibro){
                $miWhere .= "idLibro = $idLibro";
    
            }else{
                if($titulo){
                    $miWhere .= "titulo LIKE '%$titulo%' AND ";
    
                }
                if($genero){
                    $miWhere .= "genero LIKE '%$genero%' AND ";
    
                }
                if($idAutor){
                    $miWhere .= "idAutor = $idAutor AND ";
    
                }
                if($numPaginas){
                    $miWhere .= "numeroPaginas = $numPaginas AND ";
    
                }
                if($numEjemplares){
                    $miWhere .= "numeroEjemplares = $numEjemplares AND ";
    
                }
                if($miWhere == "WHERE "){ //Caso en que no hay parámetros devolvemos todos los libros
                    $miWhere = "";
                }else{
                     $miWhere = substr($miWhere, 0, -5);
                }    
                
            }
            
            $sql = "SELECT * FROM libros $miWhere;";
            
            $datos=$this->conexion->query($sql); 
            return $datos->fetch_all(MYSQLI_ASSOC);
        }
    }
    
    //apuntes

    //usar mysql fetch all en la función que reucpera los libros.
    //fetch assco recupera un registro

    //en la funcion que consulta libros por varios campos, los campos deben inicializarse a null y luego se concatenan los campos que se quieren consultar.
?>