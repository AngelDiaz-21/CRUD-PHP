<?php

    require_once "../crud/Crud.php";
    // Lo primero que tenemos que hacer es obtener el id que viene de la funcion obtenerDatos de "crud.js"
    // $id=$_POST['id'];

    // echo json_encode(Crud::obtenerDatos($id));

    $obj = new Crud();

    echo json_encode($obj->obtenerDatos($_POST['id']));

    

?>