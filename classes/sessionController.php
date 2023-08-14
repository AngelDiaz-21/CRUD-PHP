<?php 
require_once 'classes/session.php';
require_once 'models/userModel.php';
class SessionController extends Controller{
    private $userSession;
    private $username;
    private $userid;
    private $session;
    private $sites;
    private $user;
    private $defaultSites;

    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    function init (){
        $this->session = new Session();
        // Ya se tiene la estructura de un json para navegar y descomponer en parte los accesos
        $json = $this->getJSONFileConfig();

        $this->sites = $json['sites'];
        $this->defaultSites = $json['default-sites'];

        // La función validateSession permite validar si existe session, si la pagina es publica o privada y si de acuerdo al rol que tiene deberia poder ver esa pagina 
        $this->validateSession();
    }

    // Se carga el archivo y decodearlo para que se transforme en un objeto
    private function getJSONFileConfig(){
        $string = file_get_contents('config/access.json');
        $json = json_decode($string, true);

        return $json;
    }

    public function validateSession(){
        error_log('SESSIONCONTROLLER::validateSession');

        // Primero se valida si existe la funcion o la sesión
        if($this->existsSession()){
            // Se obtiene el rol de los permisos
            $role = $this->getUserSessionData()->getRole();

            // Se valida si la página es pública
            if($this->isPublic()){
                // Se redirecciona a su dashboard, también si ya tiene una sesion abierta no tiene sentido que se vea la pagina de login o de registro por eso redirecciona a la pagina de acuerdo al rol
                $this->redirectDefaultSiteByRole($role);
            }else{
                // Se valida si el usuario esta autorizado de acuerdo a su rol
                if($this->isAuthorized($role)){
                    // Si esta autorizado se deja pasar
                }else{
                    // Si no esta autorizado no se deja pasar
                    $this->redirectDefaultSiteByRole($role);
                }
            }
        }else{
            // Si no existe la sesion y si la pagina es public no pasa nada, lo deja entrar
            if($this->isPublic()){

            }else{
                // Si no es publica se redirecciona al index de la pagina
                header('Location: ' . constant('URL') . '');
            }
        }
    }

    function existsSession(){
        if(!$this->session->exists()) return false;
        // Porque puede ser que cree la sesion pero que no tenga informacion
        if($this->session->getCurrentUser() == NULL) return false;

        // Se guarda la informacion del usuario
        $userid = $this->session->getCurrentUser();

        if($userid) return true;

        return false;
    }

    // Nos permite asignar de acuerdo a los datos de la sesión crear un nuevo modelo del usuario y así utilizar las propiedades del userModel. No solo se guarda en la sesión el id del usuario sino que se crea un nuevo objeto y se hace consulta a la DB a través del metodo get y regresa toda la informacion del usuario
    function getUserSessionData(){
        // Traera al id que se tiene almacenado en la sesion
        $id = $this->session->getCurrentUser();
        $this->user = new UserModel();
        // Se obtiene el objeto user de acuerdo al id de la sesion
        $this->user->get($id);

        error_log('SESSIONCONTROLLER::getUserSessionData -> ' .$this->user->getUsername());
        return $this->user;
    }

    function isPublic(){
        // Se obtiene la página actual
        $currentURL = $this->getCurrentPage();
        
        // Se extraen los caracteres que no se necesitan
        // Se coloca una expresión regular, que mapee todos los diagonales, los puntos, asteriscos y se reemplaza con un string vacío y será aplicado en $currenURL
        // En php los métodos piden que adentro se especifique el nombre de la variable a la cual se le va aplicar la accion
        $currentURL = preg_replace("/\?.*/", "", $currentURL);

        // Se recorre cada sitio
        for($i= 0; $i < sizeof($this->sites); $i++){
            // Se valida que la url sea publica
            if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['access'] == 'public'){
                return true;
            }
        }

        return false;
    }

    function getCurrentPage(){
        $actualLink = trim("$_SERVER[REQUEST_URI]");
        // var_dump($actualLink);
        // Se separa la url por diagonales
        $url = explode('/', $actualLink);

        error_log('SESSIONCONTROLLER::getCurrentPage -> ' . $url[1]);
        // error_log('SESSIONCONTROLLER::getCurrentPage -> ' . $url[2]); //todo: Este sera util?
        // Como se regresa arreglo con todas las parte del sitio, se especifica que regrese lo que se encuentra en el indice 2 que es después del http
        return $url[1];
        // return $url[2];//todo: Este sera util?
        // {name}.test
    }

    // Esta función indica a que sitio por default se debe redireccionar al usuario dependiento de su rol, ya sea a dashboard o admin
    private function redirectDefaultSiteByRole($role){
        $url = '';
        // Se redirecciona al usuario de acuerdo al role
        for($i= 0; $i < sizeof($this->sites); $i++){
            if($this->sites[$i]['role'] == $role){
                // $url = 'crud-php/' . $this->sites[$i]['site'];
                // Se deja vacio ya que si se pone un slash en la url se aparecian 2 y tammpo se pone crud-php porque sino saldria repetida en la url y generaria errores  
                // $url = '' . $this->sites[$i]['site'];
                $url = $this->sites[$i]['site'];
                break;
            }
        }
        // header('location:' . $url);
        // ! Segun de esta forma no se cicla la aplicacion
        header('location:' . constant('URL') . $url);
    }

    private function isAuthorized($role){
        // Se valida si el usuario esta autorizado para entrar a esa pagina
        $currentURL = $this->getCurrentPage();
        
        // Se extraen los caracteres que no se necesitan
        // Se coloca una expresión regular, que mapee todos los diagonales, los puntos, asteriscos y se reemplaza con un string vacío y será aplicado en $currenURL
        // En php los métodos piden que adentro se especifique el nombre de la variable a la cual se le va aplicar la accion
        $currentURL = preg_replace("/\?.*/", "", $currentURL);

        // Se recorre cada sitio
        for($i= 0; $i < sizeof($this->sites); $i++){
            // Se valida que el role es igual al que ya se tiene regresa true, caso contrario regresa false
            if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['role'] == $role){
                return true;
            }
        }

        return false;
    }

    function initialize($user){
        error_log('SessionController::Initialize->userid ' . $user->getId());
        // En la sesion solo se guarda el id porque cuando se quiera obtener datos del usuario simplemente se va a mandar a llamar a la sesion ya que no es recomendable guardar toda la informacion de un usuario porque si se encuentra alguna vulnerabilidad o algo seria peligroso que obtuviera todos los datos a través de la sesion
        $this->session->setCurrentUser($user->getId());
        $this->authorizeAccess($user->getRole());
    }

    function authorizeAccess($role){
        switch ($role) {
            case 'user':
                // se redirecciona al usuario a su pagina por defecto, lo que se desencadena la function init y validateSession
                $this->redirect($this->defaultSites['user'], []);
            break;
            case 'admin':
                $this->redirect($this->defaultSites['admin'], []);
            break;
        }
    }

    function logout(){
        $this->session->closeSession();
        
        header('Location:' . constant('URL'));
    }
}
?>