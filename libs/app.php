<?php

require_once 'controllers/errores.php';

class App{
    function __construct(){
        // echo "<p>Nueva app</p>";

        $getUrl = isset($_GET['url']) ? $_GET['url'] : null;
        $getUrl = rtrim((string) $getUrl, '/');
        $getUrl = explode('/', $getUrl);

        if(empty($getUrl[0])){
            $archivoController = 'controllers/login.php';
            require_once $archivoController;
            $controller = new Login();
            $controller->loadModel('login');
            $controller->index();
            // $archivoController = 'controllers/main.php';
            // require_once $archivoController;
            // $controller = new Main();
            // $controller->loadModel('main');
            // $controller->index();

            return;
        }

        $archivoController = 'controllers/' . $getUrl[0] . '.php';

        if(file_exists($archivoController)){
            require_once $archivoController;
            // var_dump($archivoController);
            $controller = new $getUrl[0];
            $controller->loadModel($getUrl[0]);

            // print_r($controller);

            // !$nparam = sizeof($getUrl);

            if(isset($getUrl[1])){
                // Para validar que dentro del objeto exista el método
                if(method_exists($controller, $getUrl[1])){
                    // Se valida si existe un tercer parametro dentro de la url, si existe se va a validar cuantos más existen y por cada parámetro se va a inyectar en la función
                    if(isset($getUrl[2])){
                        // Se saca el numero de parametros y se le resta 2 porque el primer parámetro de URL es el controlador y el segundo es el método
                        // Si nparam = 0, no hay parametros. Si nparam > 0, entonces si hay parámetros que inyectar dentro de la función 
                        $nparam = count($getUrl) - 2;
                        // Arreglo de parametros
                        $params = [];
                        for ($i = 0; $i < $nparam; $i++){
                            array_push($params, $getUrl[$i+2]);
                        }
                        // Se llama al método y se le envía los parámetros
                        $controller->{$getUrl[1]}($params);
                    }else{
                        // No tiene parametros, se manda a llamar el método tal cual
                        $controller->{$getUrl[1]}();
                    }
                }else{
                    // error, no existe el método
                    $controller = new Errores();
                }
            }else{  
                // No hay método a cargar, se carga el método por default
                $controller->index();
            }
        }else{
            $controller = new Errores();
        }
    }
}

?>