<?php

require_once 'controllers/errores.php';

class App{
    function __construct(){

        $getUrl = isset($_GET['url']) ? $_GET['url'] : null;
        $getUrl = trim((string) $getUrl, '/');
        $getUrl = explode('/', $getUrl);

        if(empty($getUrl[0])){
            $archivoController = 'controllers/main.php';
            require_once $archivoController;
            $controller = new Main();
            $controller->loadModel('main');
            $controller->index();

            return;
        }

        $archivoController = 'controllers/' . $getUrl[0] . '.php';

        if(file_exists($archivoController)){
            require_once $archivoController;
            $controller = new $getUrl[0];
            $controller->loadModel($getUrl[0]);

            if(isset($getUrl[1])){
                if(method_exists($controller, $getUrl[1])){
                    if(isset($getUrl[2])){
                        $nparam = count($getUrl) - 2;
                        $params = [];
                        for($i = 0; $i < $nparam; $i++){
                            array_push($params, $getUrl[$i+2]);
                        }
                        $controller->{$getUrl[1]}($params);
                    }else{
                        $controller->{$getUrl[1]}();
                    }
                }else{
                    $controller = new Errores();
                }
            }else{
                $controller->index();
            }
        }else{
            $controller = new Errores();
        }
    }
}

?>