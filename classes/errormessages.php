<?php
class ErrorMessages{
    // ERROR_CONTROLLER_METHOD_ACTION
    const ERROR_ADMIN_NEWCATEGORY_EXISTS         = "278ac1ef34d5efb05f9f7d2c2ff26e62";
    const ERROR_SIGNUP_NEWUSER                   = "278ac1ef34d5efa05f9f7b2c2fa23e62";
    const ERROR_SIGNUP_NEWUSER_EMPTY             = "378aa1ef34d5efa05c9f7g2c2fa23e62";
    const ERROR_SIGNUP_NEWUSER_EXISTS            = "378aa1ef34d5efz05c9f7h2c2fa43e62";
    const ERROR_LOGIN_AUTHENTICATE_EMPTY         = "378aa1ef34g5efnn05c9f7h2c2fa43a62";
    const ERROR_LOGIN_AUTHENTICATE_DATA          = "378aa1vd30g5efnn05c9f7h2c2fa43a62";
    const ERROR_LOGIN_AUTHENTICATE               = "378aaZvd39g5efnn05c9f7h2c2fa43a62";
    const ERROR_EXPENSES_DELETE                  = "8f48a0845b4f8704cb7e8b00d4981233";
    const ERROR_EXPENSES_NEWEXPENSE              = "8f48a0845b4f8704cb7e8b00d4981233";
    const ERROR_EXPENSES_NEWEXPENSE_EMPTY        = "a5bcd7089d83f45e17e989fbc86003ed";
    const ERROR_USER_UPDATEBUDGET                = "e99ab11bbeec9f63fb16f46133de85ec";
    const ERROR_USER_UPDATEBUDGET_EMPTY          = "807f75bf7acec5aa86993423b6841407";
    const ERROR_USER_UPDATENAME_EMPTY            = "0f0735f8603324a7bca482debdf088fa";
    const ERROR_USER_UPDATENAME                  = "98217b0c263b136bf14925994ca7a0aa";
    const ERROR_USER_UPDATEPASSWORD              = "365009a3644ef5d3cf7a229a09b4d690";
    const ERROR_USER_UPDATEPASSWORD_EMPTY        = "0f0735f8603324a7bca482debdf088fa";
    const ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME = "27731b37e286a3c6429a1b8e44ef3ff6";
    const ERROR_USER_UPDATEPHOTO                 = "dfb4dc6544b0dae81ea132de667b2a5d";
    const ERROR_USER_UPDATEPHOTO_FORMAT          = "53f3554f0533aa9f20fbf46bd5328430";
    private $errorList = [];
    public function __construct(){
        $this->errorList = [
            ErrorMessages::ERROR_ADMIN_NEWCATEGORY_EXISTS         => 'El nombre de la categoría ya existe',
            ErrorMessages::ERROR_SIGNUP_NEWUSER                   => 'Hubo un error al intentar registrarse. Intente de nuevo',
            ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY             => 'Los campos  de usuario y password no pueden estar vacíos',
            ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS            => 'El nombre de usuario ya existe, ingrese otro',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY         => 'Los parámetros para autenticar no pueden estar vacíos',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA          => 'Nombre de usuario y/o password incorrecto',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE               => 'No se puede procesar la solicitud. Ingresa usuario y password',
            ErrorMessages::ERROR_EXPENSES_DELETE                  => 'Hubo un problema el eliminar el gasto, inténtalo de nuevo',
            ErrorMessages::ERROR_EXPENSES_NEWEXPENSE              => 'Hubo un problema al crear el gasto, inténtalo de nuevo',
            ErrorMessages::ERROR_EXPENSES_NEWEXPENSE_EMPTY        => 'Los campos no pueden estar vacíos',
            ErrorMessages::ERROR_USER_UPDATEBUDGET                => 'No se puede actualizar el presupuesto',
            ErrorMessages::ERROR_USER_UPDATEBUDGET_EMPTY          => 'El presupuesto no puede estar vacio o ser negativo',
            ErrorMessages::ERROR_USER_UPDATENAME_EMPTY            => 'El nombre no puede estar vacio o ser negativo',
            ErrorMessages::ERROR_USER_UPDATENAME                  => 'No se puede actualizar el nombre',
            ErrorMessages::ERROR_USER_UPDATEPASSWORD              => 'No se puede actualizar la contraseña',
            ErrorMessages::ERROR_USER_UPDATEPASSWORD_EMPTY        => 'El nombre no puede estar vacio o ser negativo',
            ErrorMessages::ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME => 'Los passwords no son los mismos',
            ErrorMessages::ERROR_USER_UPDATEPHOTO                 => 'Hubo un error al actualizar la foto',
            ErrorMessages::ERROR_USER_UPDATEPHOTO_FORMAT          => 'El archivo no es una imagen',
        ];
    }

    // Devuelve el texto de cifrado. Se devuelve un texto dado un hash
    public function get($hash){
        return $this->errorList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key, $this->errorList)){
            return true;
        }else{
            return false;
        }
    }
}
?>