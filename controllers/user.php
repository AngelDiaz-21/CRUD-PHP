<!-- El controlador de usuario es el que se encarga de las actividades para por ejemplo poder actualzar el boyer de la app de gastos o costos, el nombre del usuario o la contraseña-->
<?php
require_once 'models/usermodel.php';
class User extends SessionController{
    private $user;
    function __construct()
    {
        parent::__construct();
        $this->user = $this->getUserSessionData();
        error_log("user " . $this->user->getName());
    }

    function index(){
        $this->view->render('user/index', [
            'user' => $this->user// Se pasa la informacion del usuario autenticado
        ]);
    }   

    function updateBudget(){
        if(!$this->existPost('budget')){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEBUDGET]);
            return;
        }

        // Se obtienen los valores enviados por el post, y se le pone el parametro budget
        $budget = $this->getPost('budget');

        if(empty($budget) || $budget == 0 || $budget < 0){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEBUDGET_EMPTY]);
            return;
        }

        // Se asigna el budget al usuario

        // Se actualiza a través de los setter, por eso en update no se le pasa ningun parametro
        $this->user->setBudget($budget);
        if($this->user->update()){
            $this->redirect('user', ['success' => SuccessMessages::SUCCESS_USER_UPDATEBUDGET]);
        }else{
            // error
        }
    }

    function updateName(){
        if(!$this->existPost('name')){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATENAME]);
            return;
        }

        // Se obtienen los valores enviados por el post, y se le pone el parametro name
        $name = $this->getPost('name');

        if(empty($name) || $name == NULL){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATENAME_EMPTY]);
            return;
        }

        // Se asigna el name al usuario

        // Se actualiza a través de los setter, por eso en update no se le pasa ningun parametro
        $this->user->setName($name);
        if($this->user->update()){
            $this->redirect('user', ['success' => SuccessMessages::SUCCESS_USER_UPDATENAME]);
        }else{
            // error
        }
    }
    function updatePassword(){
        if($this->existPost(['current_password', 'new_password'])){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEPASSWORD]);
            return;
        }

        //Se obtienen sus valores
        $current = $this->getPost('current_password');
        $newPassword = $this->getPost('new_password');

        if(empty($current) || empty($newPassword)){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEPASSWORD_EMPTY]);
            return;
        }
        
        if($current == $newPassword){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME]);
            return;
        }

        // Se crea un nuevo hash
        // El model hace referencia al userModel por lo tanto tiene comparePasswords
        $newHash = $this->model->comparePasswords($current, $this->user->getId());

        if($newHash != NULL){
            $this->user->setPassword($newPassword, true);

            // Si se actualiza correctamente el usuario con el password se redirecciona
            if($this->user->update()){
                $this->redirect('user', ['success' => SuccessMessages::SUCCESS_USER_UPDATEPASSWORD]);
                return;
            }else{
                $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEPASSWORD]);
                return;
            }
        } else {// Si el hash es falso puede ser porque el usuario no ingreso correctamente el password actua
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEPASSWORD]);
            return;
        }
    }
    function updatePhoto(){
        // Sino existe foto
        if(!isset($_FILES['photo'])){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEPHOTO]);
            return;
        }
        // Si si existe
        $photo = $_FILES['photo'];

        // Se ocupa un target donde se va a guardar la informacion(se crea la carpeta photos)
        $targetDir = 'public/img/photos/';
        // Se quitan la extension al archivo, se busca por el punto el archivo y se accede a la propiedad de name que es el metadato que contiene el nombre del archivo
        // explode a través de un caracter transforma un string en un arreglo separado por el elemento donde encontro el caracter 
        $extension = explode('.', $photo['name']);
        // Se ubica el nombre del archivo en el arreglo que se genero con explode
        $filename = $extension[sizeof($extension) - 2];
        // Se extrae la extensión en el arreglo que se genero con explode
        $ext = $extension[sizeof($extension) - 1];

        // El nombre del archivo no se va a guardar tal cual, ya que puede que distintos usuarios nombren el mismo archivo igual así que se le añadira un hash con md5
        // Se le añade año, mes, dia 
        $hash = md5(Date('Ymdgi') . $filename) . '.' . $ext;
        $targetFile = $targetDir . $hash;

        $uploadOk = false;

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        // con tmp_name se obtiene la ubicación donde se almacena temporalmente la imagen antes de que se guarde
        $check = getimagesize($photo['tmp_name']);
        if($check !== false){
            $uploadOk = true;
        }else{
            $uploadOk = false;
        }

        // Sino existe o es igual a false
        if(!$uploadOk){
            $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEPHOTO_FORMAT]);
            return;
        }else{
            // Si existe se mueve el archivo. Primero se coloca el nombre del archivo a mover y el segundo parametro es el target
            if(move_uploaded_file($photo['tmp_name'], $targetFile)){
                // Se actualiza el modelo y solo se guarda el nombre, no toda la direccion. Solo se necesita el nombre con la extension porque el target file posteriormente si se mueve a otra carpeta se tendrian que actualizar todas las imagenes en la BD con la direccion por eso no vale la pena guardar toda la direccion  
                $this->user->setPhoto($hash);
                $this->user->update();
                $this->redirect('user', ['success' => SuccessMessages::SUCCESS_USER_UPDATEPHOTO]);
                return;
            }else{
                $this->redirect('user', ['error' => ErrorMessages::ERROR_USER_UPDATEPHOTO]);
                return;
            }
        }
    }
}

?>