<?php
class CategoriesModel extends Model implements IModel{
    private $id;
    private $name;
    private $color;
    public function __construct()
    {
        parent::__construct();
    }

    public function save(){
        try {
            $query = $this->prepare('INSERT INTO categories (name, color) VALUES (:name, :color)');
            $query->execute([
                'name' => $this->name,
                'color' => $this->color
            ]);
            
            // Si esto existe regresa
            if($query->rowCount()) return true;

            // sino existe
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }   
    public function getAll(){
        $items = [];

        try {
            $query = $this->query('SELECT * FROM categories');

            while($pointer = $query->fetch(PDO::FETCH_ASSOC)){
                // Para tener acceso en forma de arreglo
                $item = new CategoriesModel();
                // Se rellena el arreglo basado en el método from. Toma cada uno de los objetos en forma de arreglo o de clave/valor para rellenar el objeto 
                $item->from($pointer);

                array_push($items, $item);
            }

            return $items;
        } catch (PDOException $e) {
            // return NULL;
            echo $e;
        }
    }
    public function get($id){
        // Se aplica el fetch al primer elemento de la consulta
        try {
            $query = $this->prepare('SELECT * FROM categories WHERE id = :id');
            $query->execute(['id' => $id]);
            $category = $query->fetch(PDO::FETCH_ASSOC);

            $this->from($category);
            return $this;
        } catch (PDOException $e) {
            return false;
            // return NULL;
        }
    }
    public function delete($id){
        try {
            $query = $this->prepare('DELETE FROM categories WHERE id = :id');
            $query->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function update(){
        try {
            $query = $this->prepare('UPDATE categories SET name = :name, color = :color WHERE id = :id');
            // Aquí como ya se tiene modificado las propiedades del objeto se mandan a llamar. A diferencia de los primeros execute
            $query->execute([
                'name' => $this->name,
                'color' => $this->color,
                // 'id' => $this->id
            ]);

            // $category = $query->fetch(PDO::FETCH_ASSOC);
            return true;
            
        } catch (PDOException $e) {
            return false;
        }
    }
    public function from($array){
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->color = $array['color'];
    }

    // Funcion para validar si existe una categoria. Ya que no se quiere crear dos o más categorias con el mismo nombre
    public function exists($name){
        try {
            $query = $this->prepare('SELECT name FROM categories WHERE name = :name');
            $query->execute([
                'name' => $this->name
            ]);
            
            // Si esto existe regresa
            if($query->rowCount()) return true;

            // sino existe
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }
    public function getColor(){
        return $this->color;
    }
    public function setId($value){
        $this->id = $value;
    }
    
    public function setName($value){
        $this->name = $value;
    }
    public function setColor($value){
        $this->color = $value;
    }
    

}

?>
