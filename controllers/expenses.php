<?php
// require_once 'models/expensesModel.php';
require_once 'models/categoriesModel.php';
require_once 'models/joinExpensesCategoriesModel.php';

// con SessionController se encarga de autenticar si el usuario puede entrar o no al controlador
class Expenses extends SessionController{

    // Esta variable tendra la informacion del usuario actual en la sesion para realizar las operaciones y consultas en el modelo
    private $user;

    function __construct()
    {
        parent::__construct();
    
        $this->user = $this->getUserSessionData(); //Con esto se tiene la informacion  del usuario con la sesion actual
        error_log("Expenses::constructor() ");
    }

    public function index(){
        error_log("Expenses::RENDER() ");
        $this->view->render('expenses/index', [
            'user' => $this->user,// En la vista se va a recibir este objeto y se podrá acceder a sus propiedades(nombre, nombre de usuario, etc)
            'dates' => $this->getDateList(),
            'categories' => $this->getCategoryList()
        ]);
    }

    function newExpense(){
        error_log('Expenses::newExpense()');
        // Se valida que existe la informacion necesaria para crear un nuevo expense
        // Si esto no existe se redirecciona
        if(!$this->existPost(['title', 'amount', 'category', 'date'])){
            $this->redirect('dashboard', ['error' => ErrorMessages::ERROR_EXPENSES_NEWEXPENSE_EMPTY]);
            return;
        }

        // Con esto se valida que la session no este vacía
        if($this->user == NULL){
            $this->redirect('dashboard', ['error' => ErrorMessages::ERROR_EXPENSES_NEWEXPENSE]);
            return;
        }

        $expense = new ExpensesModel();

        $expense->setTitle($this->getPost('title'));
        $expense->setAmount((float)$this->getPost('amount'));// Se hace un casteo
        $expense->setCategoryId($this->getPost('category'));
        $expense->setDate($this->getPost('date'));
        $expense->setUserId($this->user->getId());


        // Con esto se guarda el objeto
        $expense->save();
        $this->redirect('dashboard', ['success' => SuccessMessages::SUCCESS_EXPENSES_NEWEXPENSE]);
    }

    // La diferencia entre newUser y create es que en create nos va a mostrar la vista para poder llenar los datos y que eventualmente al darle en enviar se nos lleve a esta ruta
    function create(){
        // Se cargan las categorias
        $categories = new CategoriesModel();
        $this->view->render('expenses/create',[
            'categories' => $categories->getAll(),//De esta forma podemos enviar los registros de categorias a la vista para que se puedan seleccionar al crear un nuevo expense
            'user' => $this->user
        ]);
    }

    function getCategoriesId(){
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
        $categories = $joinExpensesCategoriesModel->getAll($this->user->getId()); //Se le envia el id

        $res = [];

        foreach($categories as $cat){
            array_push($res, $cat->getCategoryId()); //Se insertan dentro del arreglo res cada categoria
        }
        // El array_values permite obtener solo los vaLores más no la clave y se filtra para que regrese solo los valores unicos 
        $res = array_values(array_unique($res));

        return $res;
    }

    // Para filtrar datos, obtener la lista de las fechas donde el usuario metio expenses y meterlo en una lista. Mas que nada porque habra fechas donde el usuario no habra metido expenses y esas fechas no nos interesan
    public function getDateList(){
        $months = [];
        $res = [];
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
        $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());
        foreach($expenses as $expense){
            array_push($months, substr($expense->getDate(), 0, 7)); //Que agregue las fechas donde hay expenses, con substr permite substraer de cada expense el mes
        }    
        // Que mande solo los valores y que sean unicos
        $months = array_values(array_unique($months));

        // Con esto se obtienen todos los fechas posibles de los meses donde donde el usuario metio sus gastos 
        foreach($months as $month){
            array_push($res, $month);
        }

        // Con esto se muestran los 3 ultimos meses donse insertaron expenses y esta funcion se puede utilizar en el dashboard si se quiere hacer una gráfica -> Esta mal la validacion
        // if(count($months) > 3){
        //     array_push($res, array_pop($months));
        //     array_push($res, array_pop($months));
        //     array_push($res, array_pop($months));
        // }

        return $res;
    }

    // Esta funcion va a permir mostrarle al usuario una lista con las categorias en las que se ha incluido expense 
    function getCategoryList(){
        $res = [];
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
        $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());

        foreach($expenses as $expense){
            array_push($res, $expense->getNameCategory());
        }
        $res = array_values(array_unique($res));

        return $res;
    }

    function getCategoryColorList(){
        $res = [];
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
        $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());

        foreach($expenses as $expense){
            array_push($res, $expense->getColor());//Se filta por el color
        }
        $res = array_unique($res);
        $res = array_values(array_unique($res));

        return $res;
    }

    // Esta funcion va a servir como si fuera una pequeña API el cual solo va a responder a esta ruta y va a regresar un json basado en la informacion que tengamos
    function getHistoryJSON(){
        header('Content-Type: application/json');
        $res = [];
        $joinExpensesCategories = new JoinExpensesCategoriesModel();
        $expenses = $joinExpensesCategories->getAll($this->user->getId());

        foreach($expenses as $expense){
            array_push($res, $expense->toArray());//El método toArray permite transformar de un objeto a un arreglo, en este caso se esta metiendo un arreglo dentro de un arreglo simulando un poco una estructura json 
        }

        echo json_encode($res);
    }

    function getExpensesJSON(){
        header('Content-Type: application/json');

        $res = [];
        $categoryIds    = $this->getCategoriesId();
        $categoryNames  = $this->getCategoryList();
        $categoryColors = $this->getCategoryColorList();

        array_unshift($categoryNames, 'mes'); //Se le agrega la propiedad mes para poder agregar etiquetas a la estructura del arreglo y lo pueda entender mas adelante google char para poder graficar sin ningun problema 
        array_unshift($categoryColors, 'categorias');

        // Se obtiene la lista de los meses
        $months = $this->getDateList();

        // Este doble for va a permitir hacer una doble iteracion entre los id y los meses para poder acomodar los expenses. Como se vio anteriormente solo se van a mostrar los 3 ultimos meses por lo tanto con este doble for se esta haciendo un recorrido para crea una matriz entre la relacion de los meses y las categorias para despues rellenarlo con el total de los expenses 
        for($i = 0; $i < count($months); $i++){
            $item = array($months[$i]);
            for($j = 0; $j < count($categoryIds); $j++){
                // Se saca el toal de los expenses
                $total = $this->getTotalByMonthAndCategory($months[$i], $categoryIds[$j]);
                // Cuando se saque el total se insertará en $item
                array_push($item, $total);
            }
            array_push($res, $item);
        }

        // se filtra y se regresa como un arreglo
        array_unshift($res, $categoryNames); //Agrega un elemento al inicio del arreglo 
        array_unshift($res, $categoryColors);

        echo json_encode($res);
    }

    private function getTotalByMonthAndCategory($date, $categoryid){
        // Se saca el id del user
        $iduser = $this->user->getId();
        // $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();

        $expenses = new ExpensesModel();
        
        // $total = $joinExpensesCategoriesModel->getTotalByMonthAndCategory($date, $categoryid, $iduser);
        $total = $expenses->getTotalByMonthAndCategory($date, $categoryid, $iduser);
        // $total = $this->model->getTotalByMonthAndCategory($date, $categoryid, $iduser);

        if($total == NULL){
            $total = 0;
        }

        return $total;
    }

    // Se esperan parametros en formato de arreglo
    function delete($params){
        error_log("Expenses::delete()");
        if($params === NULL) $this->redirect('expenses', ['error' => ErrorMessages::ERROR_EXPENSES_DELETE]);

        // Se obtiene el id del arreglo
        $id = $params[0];
        error_log("Expenses::delete() id = " . $id);
        $expense = new ExpensesModel();
        $res = $this->model->delete($id);
        
        if($res){
            $this->redirect('expenses', ['success' => SuccessMessages::SUCCESS_EXPENSES_DELETE]);
        }else{
            $this->redirect('expenses', ['error' => ErrorMessages::ERROR_EXPENSES_DELETE]);
        }
    }
}
?>