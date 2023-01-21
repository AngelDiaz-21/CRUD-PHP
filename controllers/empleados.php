<?php
class Empleados extends Controller{
    function __construct(){
        parent::__construct();
    }

    function index(){
        $this->view->render('empleados/index');
    }

    function registrarEmpleado(){
        if(empty($_POST['nombre'] && $_POST['sueldo'] && $_POST['edad'] &&  $_POST['fRegistro'])){
            echo 0;
            return;
        }

        $datos = array(
            'nombre'    => $_POST['nombre'],
            'sueldo'    => $_POST['sueldo'],
            'edad'      => $_POST['edad'],
            'fRegistro' => $_POST['fRegistro'],
        );
        
        echo $this->model->insertarEmpleado($datos);
    }

    function obtenerDatos(){
        $id = $_POST['id'];
        $empleado = $this->model->obtenerDatos($id);
        session_start();
        $_SESSION['id_empleado'] = $empleado[0];

        echo json_encode($this->model->obtenerDatos($id));
    }

    function actualizarDatos(){
        if(empty($_POST['nombreUpdate'] && $_POST['sueldoUpdate'] && $_POST['edadUpdate'] &&  $_POST['fechaUpdate'])){
            echo 0;
            return;
        }

        session_start();

        $datos = array(
            'id'        => $_SESSION['id_empleado'],
            'nombre'    => $_POST['nombreUpdate'],
            'sueldo'    => $_POST['sueldoUpdate'],
            'edad'      => $_POST['edadUpdate'],
            'fRegistro' => $_POST['fechaUpdate'],
        );

        unset($_SESSION['id_empleado']);

        echo $this->model->updateEmpleado($datos);
    }

    function eliminarDatos(){
        $id = $_POST['id'];
        echo $this->model->eliminarEmpleado($id);
    }

    function getEmpleados(){
        $empleados = $this->model->getEmpleados();

        $tabla = '<table class="table table-bordered">
                    <thead>
                        <tr class="font-weight-bold bg-dark text-white text-center">
                            <td>Nombre</td>
                            <td>Sueldo</td>
                            <td>Edad</td>
                            <td>Fecha Registro</td>
                            <td>Editar</td>
                            <td>Eliminar</td>
                        </tr>
                    </thead>
                    <tbody>';
        $datosTabla="";

        foreach ($empleados as $key =>$value){
        $datosTabla=$datosTabla.'<tr>
                                    <td>'.$value['nombre'].'</td>
                                    <td class="text-center">'.$value['sueldo'].'</td>
                                    <td class="text-center">'.$value['edad'].'</td>
                                    <td class="text-center">'.$value['fRegistro'].'</td>
                                    <td class="text-center">
                                        <span class="btn btn-warning btn-sm" onclick="obtenerDatos('.$value['id'].')" data-toggle="modal" data-target="#actualizarModal">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        
                                    </td>
                                    <td class="text-center">
                                        <span class="btn btn-danger btn-sm" onclick="eliminarDatos('.$value['id'].')">
                                            <li class="fas fa-trash-alt"></li>
                                        </span>
                                    </td>
                                </tr>';
        }
        echo $tabla.$datosTabla.'</tbody></table>';
    }
}
?>