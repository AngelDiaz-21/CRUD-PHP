<?php

require_once 'controllers/errores.php';

class Estudiantes extends Controller{

    public $estudiantes;
    public $estudiante;
    public $mensaje;
    public $err;
    function __construct(){
        parent::__construct();
        $this->view->estudiantes = [];
        $this->view->mensaje = "";
    }

    function index(){
        $estudiantes = $this->model->getEstudiantes();
        $this->view->estudiantes = $estudiantes;
        $this->view->render('estudiantes/index');
    }

    function create(){
        $this->view->render('estudiantes/create');
    }

    function registrar(){

        if(empty($_POST['matricula'] && $_POST['nombre'] && $_POST['apellido_p'] &&  $_POST['apellido_m'])){
            echo 0;
            return;
        }

        $datos = array(
            'matricula' => $_POST['matricula'],
            'nombre' => $_POST['nombre'],
            'apellido_p' => $_POST['apellido_p'],
            'apellido_m' => $_POST['apellido_m'],
        );

        echo $this->model->registrarDatos($datos);
    }

    function detail($param = null){
        $idMatricula = $param[0];
        $estudiante = $this->model->getByMatricula($idMatricula);

        if(!$estudiante){
            header("Location: ".constant('URL')."errores/index");
        } else{
            session_start();
            $_SESSION['alumno_Matricula'] = $estudiante[1];

            $this->view->estudiante = $estudiante;
            $this->view->render('estudiantes/edit');
        }
    }

    function actualizarDatos(){
        if(empty($_POST['matricula'] && $_POST['nombre'] && $_POST['apellido_p'] &&  $_POST['apellido_m'])){
            echo 0;
            return;
        }

        session_start();
        $datos = array(
            'matricula' => $_SESSION['alumno_Matricula'],
            'nombre' => $_POST['nombre'],
            'apellido_p' => $_POST['apellido_p'],
            'apellido_m' => $_POST['apellido_m'],
        );

        unset($_SESSION['alumno_Matricula']);
        echo $this->model->updateEmpleado($datos);
    }

    function delete(){
        $matricula = $_POST['matricula'];
        echo $this->model->deleteEstudiante($matricula);
    }
}
?>