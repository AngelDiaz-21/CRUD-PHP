<?php
require_once 'models/userModel.php';
class LoginModel extends Model{
    function __construct(){
        parent::__construct();
    }

    function login($username, $password){
        // Se accede a la DB para obtener la informacion del usuario
        try {
            $query = $this->prepare('SELECT * FROM users WHERE username = :username');
            // Se trae el nombre de usuario
            $query->execute(['username' => $username]);
            // Se valida que existe, solo debe de haber un usuario con el username
            if($query->rowCount() == 1){
                $item = $query->fetch(PDO::FETCH_ASSOC);

                $user = new UserModel();
                // Se rellena la función from con item, que from es un arreglo, de tal forma que crea un nuevo objeto con la información solicitada m
                $user->from($item);

                // Se valida que el password sea el mismo
                // password_verify valida el password que se esta ingresando y el que se tiene almacenado
                if(password_verify($password, $user->getPassword())){
                    error_log('LoginModel::login->success username: ' . $user->getPassword());
                    // Si se encuentra al usuario se regresa todo el objeto al controlador de login
                    return $user;
                }else{
                    error_log('LoginModel::login->PASSWORD no es igual');
                    return NULL;
                }
            }
        } catch (PDOException $e) {
            error_log('LoginModel::login->exception ' . $e);
            return NULL;
        }
    }
}

?>