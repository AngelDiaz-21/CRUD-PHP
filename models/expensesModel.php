<?php
class ExpensesModel extends Model implements IModel{
    private $id;
    private $title;
    private $amount;
    private $categoryid;
    private $date;
    private $userid;

    public function setId($id){ $this->id = $id;}
    public function setTitle($title){ $this->title = $title;}
    public function setAmount($amount){ $this->amount = $amount;}
    public function setCategoryId($categoryid){ $this->categoryid = $categoryid;}
    public function setDate($date){ $this->date = $date;}
    public function setUserId($userid){ $this->userid = $userid;}

    public function getId(){ return $this->id;}
    public function getTitle(){ return $this->title;}
    public function getAmount(){ return $this->amount;}
    public function getCategoryId(){ return $this->categoryid;}
    public function getDate(){ return $this->date;}
    public function getUserId(){ return $this->userid;}

    public function __construct(){
        parent::__construct();
    }

    public function save(){
        try {
            $query = $this->prepare('INSERT INTO expenses (title, amount, category_id, date, id_user) VALUES (:title, :amount, :category, :d, :user)');
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'title' => $this->title,
                'amount' => $this->amount,
                'category' => $this->categoryid,
                'user' => $this->userid,
                'd' => $this->date,
            ]);

            // Si devuelve el resultado de una fila insertada es true
            if($query->rowCount()) return true;
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getAll(){
        $items = [];
        try {
            $query = $this->query('SELECT * FROM expenses');

            while($pointer = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new ExpensesModel();
                $item->from($pointer);

                array_push($items, $item);
            }

            return $items;

        } catch (PDOException $e) {
            return false;
        }
    }
    public function get($id){
        try {
            $query = $this->prepare('SELECT * FROM expenses WHERE id = :id');
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'id' => $id,
            ]);
            // Lo transforma en un arreglo
            $user = $query->fetch(PDO::FETCH_ASSOC);
            $this->from($user);
            // $expense = $query->fetch(PDO::FETCH_ASSOC);
            // $this->from($expense);

            return $this;

        } catch (PDOException $e) {
            return false;
        }
    }

    // Con esta funcion se obtiene cuantos expenses se tiene por un usuario
    public function getAllByUserId($userid){
        $items = [];
        try {
            $query = $this->prepare('SELECT * FROM expenses WHERE id_user = :userid');
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'userid' => $userid,
            ]);

            while($pointer = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new ExpensesModel();
                $item->from($pointer);

                array_push($items, $item);
            }

            return $items;

        } catch (PDOException $e) {
            // Si se regresa elementos aqui se regresa un arreglo vacío?
            // return [];
            echo $e;
        }
    }

    // Esta función permite traer un cierto limite de registros(expenses) de cierto usuario
    public function getByUserIdAndLimit($userid, $limite){
        $items = [];
        try {
            // Con DESC esta consulta se ordena a partir del registro más nuevo al mas viejo y se limita  desde el elemento 0 hasta el elemento enviado en la variable $limite
            $query = $this->prepare('SELECT * FROM expenses WHERE id_user = :userid ORDER BY expenses.date DESC LIMIT 0, :limite');
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'userid' => $userid,
                'limite' => $limite
            ]);

            while($pointer = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new ExpensesModel();
                $item->from($pointer);

                array_push($items, $item);
            }

            return $items;

        } catch (PDOException $e) {
            // Si se regresa elementos aqui se regresa un arreglo vacío?
            // return [];
            return false;
        }
    }
    // Esta function va a permitir regresar la suma total de los expenses que ha creado el usuario en este mes
    public function getTotalAmountThisMonth($userid){
        try {
            $year = date('Y'); //Para sacar el año actual
            $month = date('m'); //Para sacar el mes actual
            // En esta consulta se hace la operacion de suma con SUM(), el cuál sumará amount y el resultado o la respuesta se le pondrá un alias 'total' (que será la fila o columna resultante) para que se pueda identificar más abajo cuando se haga el fetch
            // La función YEAR(date) es una función de MySQL para también sacar el año actual, entonces se compara con el año actual que se ha sacado con PHP
            $query = $this->prepare('SELECT SUM(amount) AS total FROM expenses WHERE YEAR(date) = :year AND MONTH(date) = :month AND id_user = :userid');
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'year' => $year,
                'month' => $month,
                'userid' => $userid,
            ]);

            // Se hace un fetch
            $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

            if($total == NULL) $total = 0;
            // if($total == NULL) return 0;

            return $total;

        } catch (PDOException $e) {
            // Si se regresa elementos aqui se regresa un arreglo vacío?
            return NULL;
        }
    }

    // Para obtener el expenses más alto que ha obtenido el usuario en el mes actual
    public function getMaxExpensesThisMonth($userid){
        try {
            $year = date('Y'); //Para sacar el año actual
            $month = date('m'); //Para sacar el mes actual
            // En esta consulta se hace la operacion de suma con SUM(), el cuál sumará amount y el resultado o la respuesta se le pondrá un alias 'total' (que será la fila o columna resultante) para que se pueda identificar más abajo cuando se haga el fetch
            // La función YEAR(date) es una función de MySQL para también sacar el año actual, entonces se compara con el año actual que se ha sacado con PHP
            $query = $this->prepare('SELECT MAX(amount) AS total FROM expenses WHERE YEAR(date) = :year AND MONTH(date) = :month AND id_user = :userid');
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'userid' => $userid,
                'year' => $year,
                'month' => $month,
            ]);

            // Se hace un fetch
            $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

            if($total == NULL) $total = 0;
            // if($total == NULL) return 0;

            return $total;

        } catch (PDOException $e) {
            // Si se regresa elementos aqui se regresa un arreglo vacío?
            return NULL;
        }
    }

    public function delete($id){
        try {
            $query = $this->prepare('DELETE FROM expenses WHERE id = :id');
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'id' => $id,
            ]);
            
            return true;

        } catch (PDOException $e) {
            return false;
        }
    }
    public function update(){
        try {
            $query = $this->prepare('UPDATE expenses SET title = :title, amount = :amount, category_id = :category, date = :d, id_user = :user WHERE id = :id' );
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'title' => $this->title,
                'amount' => $this->amount,
                'category' => $this->categoryid,
                'user' => $this->userid,
                'd' => $this->date,
                'id' => $this->id,
            ]);

            // Si devuelve el resultado de una fila insertada es true
            if($query->rowCount()) return true;
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function from($array){
        // Se toma el arreglo y se guarda en cada una de las variables las propiedades
        $this->id = $array['id'];
        $this->title = $array['title'];
        $this->amount = $array['amount'];
        $this->categoryid = $array['category_id'];
        $this->date = $array['date'];
        $this->userid = $array['id_user'];
    }

    // Para obtener el total de expenses por categoria por usuario para el actual 
    public function getTotalByCategoryThisMonth($categoryid, $userid){
        error_log("ExpensesModel::getTotalByCategoryThisMonth");
        try {
            $total = 0;
            $year = date('Y'); //Para sacar el año actual
            $month = date('m'); //Para sacar el mes actual
            // En esta consulta se hace la operacion de suma con SUM(), el cuál sumará amount y el resultado o la respuesta se le pondrá un alias 'total' (que será la fila o columna resultante) para que se pueda identificar más abajo cuando se haga el fetch
            // La función YEAR(date) es una función de MySQL para también sacar el año actual, entonces se compara con el año actual que se ha sacado con PHP

            $query = $this->prepare('SELECT SUM(amount) AS total from expenses WHERE category_id = :categoryid AND id_user = :userid AND YEAR(NOW()) = :year AND MONTH(NOW()) = :month');
            // $query = $this->prepare('SELECT SUM(amount) AS total FROM mvc.expenses WHERE category_id = :categoryid AND id_user = :userid;');
            
            // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
            $query->execute(['categoryid' => $categoryid, 'userid' => $userid, 'year' => $year, 'month' => $month]);
            
            // print_r($query);

            // Se hace un fetch
            $total = $query->fetch(PDO::FETCH_ASSOC)['total'];
            // print_r($total);

            if($total == NULL) return 0;

            return $total;

        } catch (PDOException $e) {
            // Si se regresa elementos aqui se regresa un arreglo vacío?
            return NULL;
        }
    }

    function getTotalByMonthAndCategory($date, $categoryid, $userid){
        try {
            $total = 0;
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 7);

            $query = $this->prepare('SELECT SUM(amount) AS total FROM expenses WHERE category_id = :categoryid AND id_user = :userid AND YEAR(date) = :year AND MONTH(date) = :month');
            $query->execute([
                'categoryid' => $categoryid,
                'userid' => $userid,
                'year' => $year,
                'month' => $month
            ]);

            // Se validan si hay datos o no
            if($query->rowCount() > 0){
                $total = $query->fetch(PDO::FETCH_ASSOC)['total'];
            }else{
                return 0;
            }

            return $total;

        } catch (PDOException $e) {
            return NULL;
        }
    }

    //Para obtener el numero de expenses por categoria en el mes actual
    public function getNumberOfExpensesByCategoryThisMonth($categoryid, $userid){
        try {
            $total = 0;
            $year = date('Y'); //Para sacar el año actual
            $month = date('m'); //Para sacar el mes actual
            // En esta consulta se hace la operacion de suma con SUM(), el cuál sumará amount y el resultado o la respuesta se le pondrá un alias 'total' (que será la fila o columna resultante) para que se pueda identificar más abajo cuando se haga el fetch
            // La función YEAR(date) es una función de MySQL para también sacar el año actual, entonces se compara con el año actual que se ha sacado con PHP
            $query = $this->prepare('SELECT COUNT(amount) AS total FROM expenses WHERE category_id = :categoryid AND YEAR(date) = :year AND MONTH(date) = :month AND id_user = :userid');
            $query->execute([
                // La informacion se guarda a través de las variables, así que por eso primero los campos se llenan de informacion y se puedan sustituir los placehoolders
                'userid' => $userid,
                'year' => $year,
                'month' => $month,
                'categoryid' => $categoryid,
            ]);

            // Se hace un fetch
            $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

            if($total == NULL) return 0;

            return $total;

        } catch (PDOException $e) {
            // Si se regresa elementos aqui se regresa un arreglo vacío?
            return NULL;
        }
    }
}

?>