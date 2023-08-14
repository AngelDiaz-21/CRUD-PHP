<?php
// include_once 'libs/imodel.php';
// Se implementa la conexión a la DB, si después se necesitará conectar a otro tipo de almacenamiento u otro tipo de esquema de DB aquí se tendría que implementar una clase que sirviera como intermediario para implementar esa parte y solo especificar el tipo de la DB (MONGO, API)
class Model{
    public $db;
    function __construct(){
        $this->db = new Database();
    }

    // Función para ahorrarse código en las consultas preparadas (this->db-query..etc)
    function query($query){
        // connect es un método que se encuentra en el archivo database
        // query función utilizada en pdo para ejecutar una consulta, para evitar la inyección de la información, por lo tanto no se esperaria ningún parámetro 
        return $this->db->connect()->query($query);
    }

    // función prepare que extrae el código de la función query para poder insertar ahi los placeholder y después reemplazarlos cuando se ejecute la consulta
    function prepare($query){
        return $this->db->connect()->prepare($query);
    }
}
?>