<?php

class Conexion{
    public function conectar(){
        $conexion = new PDO("mysql:host=localhost;dbname=pdof","root","Nextapple18@");
        return $conexion;
    }
}

?>