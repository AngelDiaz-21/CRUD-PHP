<?php

class Conexion{
    public function conectar(){
        $conexion = new PDO("mysql:host=127.0.0.1:3308;dbname=pdof","root","");
        return $conexion;
    }
}

?>