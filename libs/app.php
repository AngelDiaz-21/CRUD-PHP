<?php

require_once 'controllers/errores.php';

class App{
    function __construct(){
        // echo "<p>Nueva app</p>";

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

            $nparam = sizeof($getUrl);
            if($nparam > 1){
                if($nparam > 2){
                    $param = [];
                    for ($i = 2; $i < $nparam; $i++){
                        array_push($param, $getUrl[$i]);
                    }
                    $controller->{$getUrl[1]}($param);
                }else{
                    $controller->{$getUrl[1]}();
                }
            } else{
                $controller->index();
            }
        }else{
            $controller = new Errores();
        }
    }
}

?>