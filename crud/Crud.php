<?php
    require_once "Conexion.php";

    class Crud extends Conexion{
        public function mostrarDatos(){
            $sql="SELECT id,
                        nombre,
                        sueldo,
                        edad,
                        fRegistro
                from t_crud";
                // Aqui se hace una resolucion de ambito para hacer acceso a la clase(Conexion)  que ya heredamos a una subclase y podamos acceder rapidamente como si fuera un self
                // Pondemos conectar y vamos al metodo "conectar" y accedemos a "prepare"
            $query=Conexion::conectar()->prepare($sql);
            // Hacemos un objeto query y le decimos que lo ejecute
            $query->execute();
            // Despues que nos haga un return de todos los registros mediante un fetchAll (O sea, que nos traiga todos los datos de todas las filas)
            return $query->fetchAll();
            // $query->close();
            
        }

        public function insertarDatos($datos){
            $sql="INSERT into t_crud (nombre, sueldo, edad, fRegistro) values (:nombre, :sueldo, :edad, :fRegistro)";
            $query=Conexion::conectar()->prepare($sql);
            $query->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $query->bindParam(":sueldo", $datos["sueldo"], PDO::PARAM_STR);
            $query->bindParam(":edad", $datos["edad"], PDO::PARAM_INT);
            $query->bindParam(":fRegistro", $datos["fecha"], PDO::PARAM_STR);

            return $query->execute();
            // $query->close();
        }
// Le pasamos el id
        public function obtenerDatos($id){
            $sql="SELECT id,
                        nombre,
                        sueldo,
                        edad,
                        fRegistro
                        -- :id es la variable id, la que esta en la funcion
            from t_crud where id=:id";
            $query=Conexion::conectar()->prepare($sql);
            $query->bindParam(":id", $id, PDO::PARAM_INT);
            $query->execute();
            //Y mandamos a llamar a la fila (A una sola fila)
            return $query->fetch();
            // $query->close();

        }

        public function actualizarDatos($datos){
            $sql="UPDATE t_crud set nombre = :nombre,
                                    sueldo = :sueldo,
                                    edad = :edad,
                                    fRegistro = :fRegistro
                        where id=:id";

            $query = Conexion::conectar()->prepare($sql);
            $query->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $query->bindParam(":sueldo", $datos["sueldo"], PDO::PARAM_STR);
            $query->bindParam(":edad", $datos["edad"], PDO::PARAM_INT);
            $query->bindParam(":fRegistro", $datos["fecha"], PDO::PARAM_STR);
            $query->bindParam(":id", $datos["id"], PDO::PARAM_INT);

            return $query->execute();

        }

        public function eliminarDatos($id){
            $sql = "DELETE from t_crud where id=:id";
            $query=Conexion::conectar()->prepare($sql);
            $query->bindParam(":id", $id, PDO::PARAM_INT);
            return $query->execute();
        }


    }


?>