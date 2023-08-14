<?php
require_once 'models/expensesModel.php';
require_once 'models/categoriesModel.php';

// Extendiendo de SessionController se garantiza que los métodos del controlador base(Controller) existan y además existan los métodos de SessionController
// Cada controlador que extienda de SessionController va a inspeccionar el tema de autenticacion y de permisos para entrar a la pagina
// Si crea una pagina a la cual no este validando que haya sesio o este autenticado se extiende de controller, por ejemplo, una pagina de politicas de privacidad para que cualquier usuario, ya sea que este logueado o no peuda ver esa pagina
class Dashboard extends SessionController{

    private $user;
    function __construct(){
        // Se llama al constructor de su padre
        parent::__construct();
        $this->user = $this->getUserSessionData();// Para obtener la información del usuario actual
        error_log('Dashboard::construct-> Inicio de Dashboard');
    }

    // En login solo se autentica y valida los campos
    function index(){
        error_log('Dashboard::render-> Carga el index de Dashboard');
        // Se configuran algunos métodos
        $expensesModel        = new ExpensesModel();
        $expenses             = $this->getExpenses(5); //Limitar los expenses a mostrar
        $totalThisMonth       = $expensesModel->getTotalAmountThisMonth($this->user->getId());
        $maxExpensesThisMonth = $expensesModel->getMaxExpensesThisMonth($this->user->getId()); //Para obtener el expense más grande que tuvo el usuario en el mes
        $categories           = $this->getCategories();

        $this->view->render('dashboard/index',[
            'user'                 => $this->user,
            'expenses'             => $expenses,
            'totalAmountThisMonth' => $totalThisMonth,
            'maxExpensesThisMonth' => $maxExpensesThisMonth,
            'categories'           => $categories,
        ]);
    }

    // Esta función nos ayuda a limitar cuantos expenses se quiere mostrar, se inicializa en 0 ya que sino se ingresa ndda
    public function getExpenses($number = 0){
        if($number < 0) return NULL;
        error_log("Dashboard::getExpenses() id = " . $this->user->getId());
        $expenses = new ExpensesModel();
        return $expenses->getByUserIdAndLimit($this->user->getId(), $number); //Se pide el id del usuario y el numero de expenses a regresar, de esa forma se esta limitando para que solo mande una cierta cantidad de expenses que serían los últimos
    }

    public function getCategories(){
        $res = [];
        $categoriesModel = new CategoriesModel();
        $expensesModel = new ExpensesModel();

        $categoriesAll = $categoriesModel->getAll();

        // Para cada catetoria se hace un foreach
        foreach ($categoriesAll as $category) {
            $categoryArray = [];
            // print_r($category);   //FIXME: AQUI VAMOS A ARREGLAR ALGO CODIGO

            // Se obtiene la suma por categoria
            $total = $expensesModel->getTotalByCategoryThisMonth($category->getId(), $this->user->getId());
            // print_r($total);
            // var_dump($total);
            // var_dump($category->getId());
            // var_dump($this->user->getId());
            // Se obtiene el numero de expenses asociado 
            $numberOfExpenses = $expensesModel->getNumberOfExpensesByCategoryThisMonth($category->getId(), $this->user->getId());

            // Se valida que el numero de expenses sea mayor que cero, se crean las propiedades como 'total', 'count' y 'category' y de esa forma en la vista se pueda renderizar la categoria, color, el numero de expenses o el total de la suma de los expenses
            if($numberOfExpenses > 0){
                $categoryArray['total'] = $total;
                $categoryArray['count'] = $numberOfExpenses;
                $categoryArray['category'] = $category;
                array_push($res, $categoryArray);
            }
        }
        return $res;
    }
}
?>