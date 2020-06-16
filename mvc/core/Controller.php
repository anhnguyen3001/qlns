<?php
    abstract class Controller{
        public function model($model){
            require_once ROOT .'mvc/models/MasterModel.php';
            require_once ROOT .'mvc/models/' .$model .".php";
            return new $model;
        }

        public function view($view, $data = []){
            require_once ROOT .'mvc/views/' .$view .".php";
        }

        public function viewLogin(){
            $this->view('layout2', [
                'page' => 'login',
                'title' => 'Đăng nhập'
            ]);
        }

        public function transferMessage(){
            $mess = [];
            if (isset($_SESSION['mess'])){
                $mess = ["message" => ['type' => $_SESSION['messType'], 'mess' => $_SESSION['mess']]];
                unset($_SESSION['messType']);
                unset($_SESSION['mess']);
            }

            return $mess;
        }
    }
?>