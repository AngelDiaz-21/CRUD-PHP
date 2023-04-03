<?php
    class View{
    public $datos;
        function render($nombre, $data = []){
            $this->datos = $data;
            $this->handleMessages();
            require 'views/' . $nombre . '.php';
        }

        private function handleMessages(){
            // Se valida si hay mensajes
            if(isset($_GET['success']) && isset($_GET['error'])) return;
                
            isset($_GET['success']) ? $this->handleSuccess() : $this->handleError();
        }

        private function handleError(){
            $hash = $_GET['error'];
            $error = new ErrorMessages();

            // Se valida la clave que viene en la url
            if($error->existsKey($hash)) $this->datos['error'] = $error->get($hash);
        }

        private function handleSuccess(){
            $hash = $_GET['success'];
            $success = new SuccessMessages();

            // Se valida la clave que viene en la url
            if($success->existsKey($hash)) $this->datos['success'] = $success->get($hash);
        }

        public function showMessages(){
            $this->showErrors();
            $this->showSuccess();
        }

        // Con esta funcion se valida que existe uno no imprima el otro
        public function showErrors(){
            if(array_key_exists('error', $this->datos)){
                echo '<div class="error">' . $this->datos['error'] . '</div>';
            }
        }

        public function showSuccess(){
            if(array_key_exists('success', $this->datos)){
                echo '<div class="success">' . $this->datos['success'] . '</div>';
            }
        }
    }
?>