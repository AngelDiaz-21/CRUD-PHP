<?php
class Errores extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->mensaje = "There was an error in the request or the requested page does not exist";
        $this->view->render('errores/index');
    }

    function index(){
        $this->view->render('errores/index');
    }
}
?>