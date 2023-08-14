<?php
require_once 'models/expensesModel.php';
require_once 'models/categoriesModel.php';
class Admin extends SessionController{

    function __construct()
    {
        parent::__construct();
    }

    function index(){
        // Se engloba toda la informacion de las estadisticas 
        $stats = $this->getStatistics();

        $this->view->render('admin/index',[
            'stats' => $stats
        ]);
    }

    // Esta funcion sera una ruta ya que se creara una nueva categoria
    function createCategory(){
        $this->view->render('admin/create-category');
    }

    function newCategory(){
        // Si valida si ya existe una informacion que mande un formulario 
        if($this->existPost(['name', 'color'])){
            $name = $this->getPost('name');
            $color = $this->getPost('color');

            // Se crea un nuevo modelo de categorias
            $categoriesModel = new CategoriesModel();

            // Se valida que no exista una categoria con el mismo nombre y si no existe se le asignan las propiedades correspondientes
            if(!$categoriesModel->exists($name)){
                $categoriesModel->setName($name);
                $categoriesModel->setColor($color);
                $categoriesModel->save();

                $this->redirect('admin', [SuccessMessages::SUCCESS_ADMIN_NEWCATEGORY]);
            }else{
                $this->redirect('admin', ['error' => ErrorMessages::ERROR_ADMIN_NEWCATEGORY_EXISTS]);
            }
        }
    }

    function getStatistics(){
        $res = [];

        $userModel = new UserModel();
        $users = $userModel->getAll();//De momento la aplicaciones podria soportar hasta 10,000 usuarios así que si después se tienen mas usuarios se debe buscar otra manaera de implementar esto

        $expensesModel = new ExpensesModel(); 
        $expenses = $expensesModel->getAll();

        $categoriesModel = new CategoriesModel();
        $categories = $categoriesModel->getAll();

        // La respuesta sera de clave-valor para identificar bien como se accede a cada una de las metricas
        $res['count-users'] = count($users);
        $res['count-expenses'] = count($expenses);
        $res['max-expenses'] = $this->getMaxAmount($expenses);
        $res['min-expenses'] = $this->getMinAmount($expenses);
        $res['avg-expenses'] = $this->getAverageAmount($expenses);

        $res['count-categories'] = count($categories);
        $res['mostused-categories'] = $this->getCategoryMostUsed($expenses);
        $res['lessused-categories'] = $this->getCategoryLessUsed($expenses);

        return $res;
    }

    // Estas funciones nos van a permitir hacer estadisticas simples, como: Cual ha sido la transaccion mas alta, la mas baja, la transcaccion promedio y es lo que tendra acceso el administrador
    private function getMaxAmount($expenses){       
        $max = 0;

        foreach($expenses as $expense){
            // Se usa la funcion de max de PHP para que elija cual es el maximo entre el valor actual que tiene la variable de max y el valor que tiene expense que es traido de la base de datos. Como se busca el expense mas alto cada vez que se ejecute la funciion de max va a asignarlea a la variable el valor mas grande ya sea entre la misma variable o el expense
            $max = max($max, $expense->getAmount());
        }

        return $max;
    }

    private function getMinAmount($expenses){
        // Primero se le asigna el expense mas grande
        $min = $this->getMaxAmount($expenses);
        
        foreach($expenses as $expense){
            $min = min($min, $expense->getAmount());
        }

        return $min;
    }

    // Para sacar el promedio
    private function getAverageAmount($expenses){
        $sum = 0;

        foreach($expenses as $expense){
            $sum += $expense->getAmount();
        }

        return ($sum / count($expenses));
    }

    // Para saber la categoria mas usada de la app, esto es sabiendo que categoria tiene mas registro
    private function getCategoryMostUsed($expenses){
        $repeat = [];

        foreach($expenses as $expense){
            // Se revisa si ya existe una clave registrada en repeat, es decir, si en la DB tenemos otras categorias pero los usuario no lo han utilizado van a aparecer en 0 y por lo tanto no estara en el arreglo. También solo se agregara una vez la categoria
            // Dentro del método array_key_exists se le envia el id de la categoria asi como en el arreglo en donde se buscara
            if(!array_key_exists($expense->getCategoryId(), $repeat)){
                $repeat[$expense->getCategoryId()] = 0;
            }
            // Se suma
            $repeat[$expense->getCategoryId()]++;
        }

        // Una vez que se tiene $repeat que tiene las veces que se repite una categoria se inicializa la variable $categoryMostUsed en cero. Luego $maxCategory se le asigna la caetegoia que tiene mas repeticiones pero aun no se sabe cual es el indice, por eso se hace un foreach para obtener el index
        $categoryMostUsed = 0;
        $maxCategory = max($repeat);
        foreach($repeat as $index => $category){
            if($category == $maxCategory){
                $categoryMostUsed = $index;
            }
        }

        $categoryModel = new CategoriesModel();
        $categoryModel->get($categoryMostUsed);

        // Se obtiene el nombre de la categoria mas popular
        $category = $categoryModel->getName();

        return $category;
    }

    // Categoria menos usada
    private function getCategoryLessUsed($expenses){
        $repeat = [];

        foreach($expenses as $expense){
            // Se revisa si ya existe una clave registrada en repeat, es decir, si en la DB tenemos otras categorias pero los usuario no lo han utilizado van a aparecer en 0 y por lo tanto no estara en el arreglo. También solo se agregara una vez la categoria
            // Dentro del método array_key_exists se le envia el id de la categoria asi como en el arreglo en donde se buscara
            if(!array_key_exists($expense->getCategoryId(), $repeat)){
                $repeat[$expense->getCategoryId()] = 0;
            }
            // Se suma
            $repeat[$expense->getCategoryId()]++;
        }

        // Una vez que se tiene $repeat que tiene las veces que se repite una categoria se inicializa la variable $categoryMostUsed en cero. Luego $maxCategory se le asigna la caetegoia que tiene mas repeticiones pero aun no se sabe cual es el indice, por eso se hace un foreach para obtener el index
        $categoryMostUsed = 0;
        $maxCategory = min($repeat);
        foreach($repeat as $index => $category){
            if($category == $maxCategory){
                $categoryMostUsed = $index;
            }
        }

        $categoryModel = new CategoriesModel();
        $categoryModel->get($categoryMostUsed);

        // Se obtiene el nombre de la categoria mas popular
        $category = $categoryModel->getName();

        return $category;
    }
}

?>