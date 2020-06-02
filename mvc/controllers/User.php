<?php
    class User extends Controller{
        private $userModel;
        private $departmentModel;

        public function __construct()
        {
            $this->userModel = $this->model('UserModel');
            $this->departmentModel = $this->model('DepartmentModel');
        }

        public function show(){
            if (isset($_SESSION['user'])){
                $this->view('layout1',array_merge($this->transferMessage() ,[
                    "page" => 'user',
                    "title" => "Quản lí tài khoản",
                    "users" => $this->userModel->getAllUser(),
                    "departments" => $this->departmentModel->getAllDepartment()
                ]));
            } else {
                $this->viewLogin();
            }
        }

        public function updatePassword(){
            if (isset($_SESSION['user'])){
                if(!empty($_POST)){
                    $_SESSION['mess'] = 'Cập nhật mật khẩu không thành công';
                    $_SESSION['messType'] = 'fail';
                    if ($this->userModel->updatePassword($_POST)){
                        $_SESSION['mess'] = 'Cập nhật mật khẩu thành công';
                        $_SESSION['messType'] = 'success';
                    }
                }

                header('Location:' .$_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->viewLogin();
            }
        }

        public function add(){
            if (isset($_SESSION['user'])){
                if(!empty($_POST)){
                    $_SESSION['mess'] = 'Tạo tài khoản không thành công';
                    $_SESSION['messType'] = 'fail';

                    $submit = false;
                    if ($_POST['role'] == 'manager'){
                        if($this->userModel->createDepAccount($_POST))
                            $submit = true;
                    } else if ($this->userModel->createEmpAccount($_POST))
                            $submit = true;
                    
                    if ($submit) {
                        $_SESSION['mess'] = 'Tạo tài khoản thành công';
                        $_SESSION['messType'] = 'success';
                    }
                }
                
                header('Location: ' .ROOT_LINK .'User');
                exit;
            } else {
                $this->viewLogin();
            }
        }

        public function delete(){
            if (isset($_SESSION['user'])){
                if(!empty($_GET)){
                    $_SESSION['mess'] = 'Xoá tài khoản không thành công';
                    $_SESSION['messType'] = 'fail';
                    if ($this->userModel->delete($_GET)){
                        $_SESSION['mess'] = 'Xoá tài khoản thành công';
                        $_SESSION['messType'] = 'success';
                    }
                }

                header('Location: ' .ROOT_LINK .'User');
                exit;
            } else {
                $this->viewLogin();
            }
        }
    }
?>