<?php
class Session{
    private $sessionName = 'user';

    public function __construct()
    {
        // PHP_SESSION_NONE -> Es una constante de PHP
        if(session_status() == PHP_SESSION_NONE){
            // Si no existe la session la iniciamos
            session_start();
        }
    }

    public function setCurrentUser($user){
        $_SESSION[$this->sessionName] = $user;
    }

    public function getCurrentUser(){
        return $_SESSION[$this->sessionName];
    }

    // Funcion para destruir la función
    public function closeSession(){
        session_unset();
        session_destroy();
    }

    // Funcion si ya existe la session
    public function exists(){
        return isset($_SESSION[$this->sessionName]);
    }

}

?>