<?php
    class Wage extends Controller{
        private $wageModel;
        private $departmentModel;

        public function __construct()
        {
            $this->wageModel = $this->model('WageModel');
            $this->departmentModel = $this->model('DepartmentModel');
        }

        public function show(){
            if(isset($_SESSION['user'])){
                
                if (!isset($_GET['departmentID'])){
                    $_GET['departmentID'] = 1;
                }

                if (!isset($_GET['month'])){
                    $_GET['month'] = date('Y-m');
                }

                $filter = $_GET;
                
                $month = $filter['month'];

                if ($month > date('Y-m')) $employee = [];
                else if ($month == date('Y-m')){
                    $now = new DateTime('now');
                    $now->modify('last day of this month');
                    $lastDate = $now->format('d');
                    if ($lastDate >= date('d')) $employee = []; 
                }

                if (!isset($employee)) $employee = $this->wageModel->getNetSalary($filter);

                $this->view('layout1',array_merge($this->transferMessage(),[
                    'page'=> 'wage',
                    'title'=> 'Bảng lương', 
                    'filters' => $filter,
                    'employees' => $employee,
                    'departments' => $this->departmentModel->getAllDepartment()
                ]));
            } else $this->viewLogin();
        }
    }
?>