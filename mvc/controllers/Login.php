<?php
    class Login extends Controller{
        private $userModel;
        private $departmentModel;
        private $employeeModel;

        public function __construct()
        {
            $this->userModel = $this->model("UserModel");
            $this->departmentModel = $this->model("DepartmentModel");
            $this->employeeModel = $this->model("EmployeeModel");
        }

        public function show(){
            if (!empty($_POST)){
                $user = $this->userModel->getUser($_POST);
                
                if ($user){
                    $this->saveSession($user); 
                    $this->redirectPage();
                } else {
                    $_SESSION['messType'] = 'fail';
                    $_SESSION['mess'] = 'Tài khoản, mật khẩu nhập không đúng';
                }
            };

            $this->view('layout2', array_merge($this->transferMessage(), [
                'page' => 'login',
                'title' => 'Đăng nhập'
            ]));
        }

        public function userLogin(){
             
            
            header('Location: ' .ROOT_LINK .'Login');
            exit;
        }

        public function saveSession($data){
            $_SESSION['role'] = $data['role'];
            
            if ($data['loginName'] != 'admin'){
                $_SESSION['username'] = $data['employeeID'];

                if (preg_match($_SESSION['role'])){
                    $temp = $this->employeeModel->getDepartmentOfEmp($data['employeeID']);
                    $_SESSION['departmentID'] = $temp['departmentID'];
                    $_SESSION['departmentTitle'] = $temp['departmentTitle'];
                } else $_SESSION['user'] = $this->employeeModel->getEmployeeName($data['employeeID'])['fullName'];
            } else $_SESSION['user'] = $data['loginName'];
        }   

        public function logout(){
            session_destroy();
            header('Location: ' .ROOT_LINK.'Login');
            exit;
        }

        public function redirectPage(){
            if ($_SESSION['role'] == 'manager')
                $url = 'Wage';
            else 
                $url = 'Employee';

            header('Location: ' .ROOT_LINK .$url);
            exit;
        }
    }
?>