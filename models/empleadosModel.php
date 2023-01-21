<?php

class EmpleadosModel extends Model{

    public function __construct(){
        parent::__construct();
    }

    public function getEmpleados(){
        try {
            $sql = 'SELECT * FROM tbempleados';
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function insertarEmpleado($datos){
        try {
            $sql = 'INSERT INTO tbempleados (nombre, sueldo, edad, fRegistro) VALUES (:nombre, :sueldo, :edad, :fRegistro)';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $query->bindParam(':sueldo', $datos['sueldo'], PDO::PARAM_STR);
            $query->bindParam(':edad', $datos['edad'], PDO::PARAM_INT);
            $query->bindParam(':fRegistro', $datos['fRegistro'], PDO::PARAM_STR);
            return $query->execute();
            
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function obtenerDatos($id){
        try {
            $sql = 'SELECT * FROM tbempleados WHERE id = :id';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateEmpleado($datos){
        try {
            $sql='UPDATE tbempleados SET nombre = :nombre,
                                    sueldo = :sueldo,
                                    edad = :edad,
                                    fRegistro = :fRegistro
                        WHERE id=:id';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $query->bindParam(':sueldo', $datos['sueldo'], PDO::PARAM_STR);
            $query->bindParam(':edad', $datos['edad'], PDO::PARAM_INT);
            $query->bindParam(':fRegistro', $datos['fRegistro'], PDO::PARAM_STR);
            $query->bindParam(':id', $datos['id'], PDO::PARAM_INT);
            return $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function eliminarEmpleado($id){
        try {
            $sql = 'DELETE FROM tbempleados WHERE id = :id';
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            return $query->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>