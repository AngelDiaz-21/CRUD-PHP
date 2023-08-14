<?php
require_once 'models/userModel.php';
class Signup extends SessionController{
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        $this->view->render('login/signup', []);
    }

    function newUser(){
        // Se validan que existen
        if($this->existPost(['username', 'password'])){
            $username = $this->getPost('username');
            $password = $this->getPost('password');

            if($username == '' || empty($username) || $password == '' || empty($password)){
                $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
            }

            $user = new UserModel();
            $user->setUsername($username);
            $user->setPassword($password);
            // Todos los usuarios serán de tipo user, los usuarios admi nosotros los colocaremos manualmente desde la DB
            $user->setRole('user');

            // Se validan si los datos existen en la DB
            if($user->exists($username)){
                $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS]);
            }else if($user->save()){
                // Se manda al index
                $this->redirect('', ['success' => SuccessMessages::SUCCESS_SIGNUP_NEWUSER]);
            }else{
                $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);    
            }
            // Sino encuentra los parametros anteriores muestra el siguiente mensaje
        }else{
            $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS]);
        }
    }
}

?>