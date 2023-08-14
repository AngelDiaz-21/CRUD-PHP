<?php
// Permite definir métodos que después deben de ser implementados, para que las clases modelos para que tenga al menos una series de funciones básicas. Solo se van a declarar los métodos pero cada modelo lo va a implementar de diferente manera (polimorfismo)
    interface IModel{
        // básicamente son funciones para el CRUD
        public function save();
        public function getAll();
        public function get($id);
        public function delete($id);
        public function update();
        public function from($array);
    }
?>