<?php

    require_once "../crud/Crud.php";

        // Cachamos los datos del formulario
        // Vamos a usar un arreglo asociativo
        $datos= array(
            
            // Hacemos una plantilla de indices
                'nombre'=> $_POST['nombreu'],
                'sueldo'=> $_POST['sueldou'],
                'edad'=> $_POST['edadu'],
                'fecha'=> $_POST['fechau'],
                'id'=> $_POST['id']
        );

        // Instanciamos CRUD (Resolucion de ambito)
        // echo Crud::insertarDatos($datos);

// Se crea una instancia de la clase Crud para poder utilizar el método insertarDatos (insertarDatos.php) 
// Ya que estamos trabajando con clases, por tanto acceder a sus funciones tenemos que crear un objeto instanciado de esa clase
        $registro = new Crud();
        echo $registro->actualizarDatos($datos);
?>