<?php
class Logout extends SessionController{

    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->logout();

        $this->redirect('', []);
    }

}
?>