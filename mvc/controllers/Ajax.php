<?php
    class Ajax extends Controller{
        private $employeeModel;
        private $departmentModel;
        private $wageModel;
        private $userModel;

        public function __construct()
        {
            $this->employeeModel = $this->model("EmployeeModel");
            $this->departmentModel = $this->model("DepartmentModel");
            $this->wageModel = $this->model("WageModel");
            $this->userModel = $this->model("UserModel");
        }

        public function getEmployee(){
            if (isset($_POST['id'])){
                $data = json_encode($this->employeeModel->getEmployee($_POST['id']), true);
                echo $data;
            }
        }

        public function getNewEmployeeID(){
            if (isset($_POST['getID'])){
                $data = json_encode($this->employeeModel->generateEmployeeID(), true);
                echo $data;
            }
        }

        public function getDepartment(){
            if (isset($_POST['getDep'])){
                $data = json_encode($this->departmentModel->getAllDepartment(), true);
                echo $data;
            }
        }

        public function getManager(){
            if (isset($_POST['getManager'])){
                $data = json_encode($this->departmentModel->getAllDepartmentInfo(), true);
                echo $data;
            }
        }
    }
?>