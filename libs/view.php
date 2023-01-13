<?php
    class View{
        function render($nombre){
            require 'views/' . $nombre . '.php';
        }
    }

?>