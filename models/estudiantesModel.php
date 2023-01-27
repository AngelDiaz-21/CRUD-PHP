<?php
class EstudiantesModel extends Model{
    public function __construct(){
        parent::__construct();
    }

    public function getEstudiantes(){
        try {
            $sql = 'SELECT * FROM tbalumnos';
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function registrarDatos($datos){
        try {
            $sql = 'INSERT INTO tbalumnos (matricula, nombre, apellido_p, apellido_m) VALUES (:matricula, :nombre, :apellido_p, :apellido_m)';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':matricula', $datos['matricula'], PDO::PARAM_INT);
            $query->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $query->bindParam(':apellido_p', $datos['apellido_p'], PDO::PARAM_STR);
            $query->bindParam(':apellido_m', $datos['apellido_m'], PDO::PARAM_STR);
            return $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getByMatricula($matricula){
        try {
            $sql = 'SELECT * FROM tbalumnos WHERE matricula = :matricula';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':matricula', $matricula, PDO::PARAM_STR);
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateEmpleado($datos){
        try {
            $sql='UPDATE tbalumnos SET nombre = :nombre,
                                    apellido_p = :apellido_p,
                                    apellido_m = :apellido_m
                        WHERE matricula=:matricula';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $query->bindParam(':apellido_p', $datos['apellido_p'], PDO::PARAM_STR);
            $query->bindParam(':apellido_m', $datos['apellido_m'], PDO::PARAM_STR);
            $query->bindParam(':matricula', $datos['matricula'], PDO::PARAM_STR);
            return $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteEstudiante($id){
        try {
            $sql = 'DELETE FROM tbalumnos WHERE matricula = :matricula';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':matricula', $id, PDO::PARAM_STR);
            return $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>