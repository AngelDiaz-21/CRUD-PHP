<?php
require_once 'libs/imodel.php';
class UserModel extends Model implements IModel{

    private $id; 
    private $username;
    private $password;
    private $role;
    private $budget;
    private $photo;
    private $name;

    public function __construct()
    {
        parent::__construct();
        // Se inicializan las variables
            $this->id = '';
            $this->username = '';
            $this->password = '';
            $this->role = '';
            $this->budget = 0.0;
            $this->photo = '';
            $this->name = '';
    }

    public function save(){
        try {
            $query = $this->prepare('INSERT INTO users(username, password, role, budget, photo, name) VALUES (:username, :password, :role, :budget, :photo, :name)');
            $query->execute([
                'username' => $this->username,
                'password' => $this->password,
                'role'     => $this->role,
                'budget'   => $this->budget,
                'photo'    => $this->photo,
                'name'     => $this->name,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log('USERMODEL::save->PDOException ' . $e);
            return false;
        }
    }

    public function getAll(){
        $items = [];
        try {
            $query = $this->query('SELECT * FROM users');

            // FETCH_ASSOC se hace que se devuelva un objeto transformado como si fuera un objeto de clave y valor
            while($pointer = $query->fetch(PDO::FETCH_ASSOC)){
                // Se llama al modelo UserModel
                $item = new UserModel();
                // Con el setter se inserta el dato
                $item->setId($pointer['id']);
                $item->setUsername($pointer['username']);
                $item->setPassword($pointer['password'], false);
                $item->setRole($pointer['role']);
                $item->setBudget($pointer['budget']);
                $item->setPhoto($pointer['photo']);
                $item->setName($pointer['name']);

                // Se guardan las variables item dentro del array items
                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            error_log('USERMODEL::getAll->PDOException ' . $e);
        }
    }

    public function get($id){
        try {
            $query = $this->prepare('SELECT * FROM users WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
            // Con solo el query y el Fetch se logra obtener un solo valor
            $user = $query->fetch(PDO::FETCH_ASSOC);
            // Con esto se indica que el objeto que mande a llamar a esta función va actualizar sus datos para obtener cada uno de los valores de la BD
            $this->setId($user['id']);
            $this->setUsername($user['username']);
            // Se pone un paramatro adicional ya que porque la forma en que se implemento hace que cada vez que se ponga setPassword aplique un hash así que encripta el hash ya incriptado y en la funcion se agrega una condicional
            $this->setPassword($user['password'], false);  //FIXME: Para probar si no actualiza el password
            // $this->password = $user['password'];  //TODO: Esto esta bien, no actualiza el password
            $this->setRole($user['role']);
            $this->setBudget($user['budget']);
            $this->setPhoto($user['photo']);
            $this->setName($user['name']);

            return $this;
        } catch (PDOException $e) {
            error_log('USERMODEL::getId->PDOException ' . $e);
        }
    }

    public function delete($id){
        try {
            $query = $this->prepare('DELETE * FROM users WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);

            return true;
        } catch (PDOException $e) {
            error_log('USERMODEL::delete->PDOException ' . $e);
            return false;
        }
    }

    public function update(){
        try {
            $query = $this->prepare('UPDATE users SET username = :username, password = :password, budget = :budget, photo = :photo, name = :name WHERE id = :id');
            $query->execute([
                // Hace referencia a los miembros del objeto y de esa forma no se envía/recibe ningún parámetro en la función
                'id' => $this->id,
                'username' => $this->username,
                'password' => $this->password,
                'budget' => $this->budget,
                'photo' => $this->photo,
                'name' => $this->name
            ]);

            return true;
        } catch (PDOException $e) {
            error_log('USERMODEL::getId->PDOException ' . $e);
            return false;
        }
    }

    // Si a este método se le pasa un array devuelve o asigne los campos que hay en ese arreglo a los atributos o miembros de la clase, o sea, le pasamos un arreglo y este los convierte en miembros de la clase
    public function from($array){
        $this->id       = $array['id'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->role     = $array['role'];
        $this->budget   = $array['budget'];
        $this->photo    = $array['photo'];
        $this->name     = $array['name'];
    }

    public function exists($username){
        try {
            $query = $this->prepare('SELECT username FROM users WHERE username = :username');
            $query->execute(['username' => $username]);
            // Se cuenta el numero de filas, si es mayor que 0 es porque ya existe un usuario
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            error_log('USERMODEL::exists->PDOException ' . $e);
            return false;
        }
    }

    public function comparePasswords($password, $id){
        try {
            // Esto va a regresar un objeto de tipo userModel
            $user = $this->get($id);

            // Esta función de PHP permite validar dado un hash y un password en texto plano si son el mismo. Es decir, aqui se va a comparar el password que ingresa el usuario con el que esta en la DB
            return password_verify($password, $user->getPassword());
            
        } catch (PDOException $e) {
            error_log('USERMODEL::comparePasswords->PDOException ' . $e);
            return false;
        }
    }

    public function setId($id){ $this->id = $id;}
    public function setRole($role){ $this->role = $role;}
    public function setBudget($budget){ $this->budget = $budget;}
    public function setPhoto($photo){ $this->photo = $photo;}
    public function setName($name){ $this->name = $name;}
    public function setUsername($username){ $this->username = $username;}
    // Por defecto aplica el hash pero si en donde se utiliza esta funcion se le pasa el parametro false solamente lo asigna y ya no hace el hash
    public function setPassword($password, $hash = true){ 
        if($hash){
            $this->password = $this->getHashedPassword($password);
        }else{
            $this->password = $password;
        }
    }

    public function getId(){ return $this->id;}
    public function getUsername(){ return $this->username;}
    public function getPassword(){ return $this->password;}
    public function getRole(){ return $this->role;}
    public function getBudget(){ return $this->budget;}
    public function getPhoto(){ return $this->photo;}
    public function getName(){ return $this->name;}

    private function getHashedPassword($password){
        // Con PASSWORD_DEFAULT dejamos que PHP escoja el mejor algortimo para encriptar pero bien nosotros podemos colocar uno 
        // El costo son las veces que va aplicar el algoritmo este proceso de hash de tal forma que entre más veces se aplique es más seguro es más seguro que se va a devolver pero tiene un costo de procesamiento, implica más calculos 
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 5]);
    }

}

?>