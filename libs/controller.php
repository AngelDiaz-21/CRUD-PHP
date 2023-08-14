<?php 

class Controller{
    public $view;
    public $model;
    function __construct(){
        $this->view = new View();
    }

    function loadModel($model){
        $url = 'models/'.$model.'model.php';

        if(file_exists($url)){
            require_once $url;
            // require $url;
            $modelName = $model.'Model';
            $this->model = new $modelName();
        }
    }

    function existPost($params){
        // params será un arreglo que permita especificar todos los parámetros que existan cuando se recibe una solicitud post y si un parametro no existe que se rechace todo 
        foreach ($params as $param) {
            // si no existe
            if(!isset($_POST[$param])){
                error_log('CONTROLLER::existsPost => No existe el parámetro ' . $param);
                return false;
            }
        }

        // Si todos los elementos existen 
        return true;
    }

    function existGet($params){
        // params será un arreglo que permita especificar todos los parámetros que existan cuando se recibe una solicitud post y si un parametro no existe que se rechace todo 
        foreach ($params as $param) {
            // si no existe
            if(!isset($_POST[$param])){
                error_log('CONTROLLER::existsGet => No existe el parámetro ' . $param);
                return false;
            }
        }

        // Si todos los elementos existen 
        return true;
    }

    function getGet($name){
        return $_GET[$name];
    }

    function getPost($name){
        return $_POST[$name];
    }

    // función para redireccionar a una dirección después de acompletar un proceso (exito o malo)
    function redirect ($route, $mensajes){
        $data = [];
        // Parametros para inyectarlos en la url
        $params = '';

        // los mensajes se guardan(push) dentro de data
        // $key sera la clave y $mensaje sera el valor
        foreach($mensajes as $key => $mensaje ){
            array_push($data, $key . '='. $mensaje);
        }
        // Con la función join se unen los elementos de un arreglo con un caracter
        $params = join('&', $data);

        if($params != ''){
            // se pone ? para empezar el tema de los parametros de la url
            $params = '?' . $params;
        }
        // Dando el siguiente resultado
        // ?nombre=Angel&apellidoPaterno=Diaz

        header('Location: ' . constant('URL') . $route . $params);
    }


}

?>