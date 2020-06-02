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
            $this->view('layout2', array_merge($this->transferMessage(), [
                'page' => 'login',
                'title' => 'Đăng nhập'
            ]));
        }

        public function userLogin(){
            if (!empty($_POST)){
                $user = $this->userModel->getUser($_POST);
                
                if ($user){
                    $this->saveSession($user); 
                    $this->redirectPage();
                } else {
                    $_SESSION['messType'] = 'fail';
                    $_SESSION['mess'] = 'Tài khoản, mật khẩu nhập không đúng';
                }
            } 
            
            header('Location: ' .ROOT_LINK .'Login');
            exit;
        }

        public function saveSession($data){
            if ($data['loginName'] != 'admin'){
                $_SESSION['role'] = $data['role'];
                $_SESSION['username'] = $data['username'];
                
                // Get department name to display
                if ($_SESSION['role'] == "manager"){
                    $temp = ['departmentID' => $data['username']];
                    $_SESSION['user'] = $this->departmentModel->getDepartment($temp)[0]['departmentTitle'];
                } else {
                    $_SESSION['user'] = $this->employeeModel->getEmployeeName($data['username'])['fullName'];
                }
            } else $_SESSION['user'] = $data['loginName'];
        }   

        public function logout(){
            session_destroy();
            header('Location: ' .ROOT_LINK.'Login');
            exit;
        }

        public function redirectPage(){
            if (!isset($_SESSION['role'])){
                $url = 'Employee';
            } else {
                $url = constant(strtoupper($_SESSION['role'] .'_ACCESS'))[0]['page'][0];
            }
            
            header('Location: ' .ROOT_LINK .$url);
            exit;
        }
    }
?>