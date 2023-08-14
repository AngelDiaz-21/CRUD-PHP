<?php
require_once 'models/userModel.php';

// Extendiendo de SessionController se garantiza que los métodos del controlador base(Controller) existan y además existan los métodos de SessionController
// Cada controlador que extienda de SessionController va a inspeccionar el tema de autenticacion y de permisos para entrar a la pagina
// Si crea una pagina a la cual no este validando que haya sesio o este autenticado se extiende de controller, por ejemplo, una pagina de politicas de privacidad para que cualquier usuario, ya sea que este logueado o no peuda ver esa pagina
class Login extends SessionController{
    function __construct(){
        // Se llama al constructor de su padre
        parent::__construct();
        error_log('Login::construct-> Inicio de loggin');
    }

    // En login solo se autentica y valida los campos
    function index(){
        error_log('Login::render-> Carga el inicio de login');
        $this->view->render('login/index');
    }

    function authenticate(){
        // Valida si existe el username y password y si tienen datos. Y si existen se implementa el login dentro de esta funcion
        if($this->existPost(['username', 'password'])){
            // Si existen se colocan las variables
            $username = $this->getPost('username');
            $password = $this->getPost('password');

            if($username == '' || empty($username) || $password == '' || empty($password)){
                error_log('Login::authenticate() empty');
                // Se redirecciona a la pagina principal del index
                $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY]);
                return;
            }

            // Login se encarga de autenticar y regresa un usuario de tipo userModel
            $user = $this->model->login($username, $password);

            // Si es diferente de null es porque se autentico el usuario
            if($user != NULL){
                error_log('Login::authenticate() passed');  
                $this->initialize($user);
            }else{
                error_log('Login::authenticate() username and/or password wrong');
                $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA]);
                return;
            }
        }else{
            error_log('Login::authenticate() error with params');
            $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE]);
        }
    }

}
?>