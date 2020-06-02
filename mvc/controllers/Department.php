<?php 
    class Department extends Controller {
        private $userModel;
        private $departmentModel;
        private $validation;

        public function __construct()
        {
            $this->userModel = $this->model("UserModel");
            $this->departmentModel = $this->model("DepartmentModel");
            $this->validation = new Validation;
        }
        
        public function show (){
            if (isset($_SESSION['user'])){
                $this->view('layout1', array_merge($this->transferMessage(), [
                    'page' => 'department',
                    'title' => 'Danh sách phòng ban',
                    'departments' => $this->departmentModel->getAllDepartmentInfo()
                ]));
            } else {
                $this->viewLogin();
            }
        }

        public function add(){
            if (isset($_SESSION['user'])){
                $messageType = 'fail';
                $mess = "Thêm phòng ban không thành công";
                
                $_POST = $this->validation->validate($_POST);
                print_r($_POST);
                if(!empty($_POST['departmentTitle']))
                    if (!$this->departmentModel->getDepartment($_POST)){
                        if ($this->departmentModel->create($_POST)){
                            $messageType = 'success';
                            $mess = "Thêm phòng ban thành công";

                            // Create account for department
                            $temp = $this->departmentModel->getDepartment($_POST)[0];
                            
                            if (!$this->userModel->createDepAccount($temp)){
                                $mess .= ' nhưng không tạo được tài khoản';
                                $messageType = 'fail';
                            }                        
                        }
                    }
                    else $mess = 'Phòng ban đã tồn tại';             

                $_SESSION['messType'] = $messageType;
                $_SESSION['mess'] = $mess;

                header('Location: ' .ROOT_LINK .'Department');
                exit;
            } else {
                $this->viewLogin();
            }
        }

        public function edit(){
            if (isset($_SESSION['user'])){
                $messageType = 'fail';
                $mess = "Cập nhật không thành công";
                
                $previousSize = sizeof($_POST);
                $_POST = $this->validation->validate($_POST);

                if($previousSize === sizeof($_POST) && $this->departmentModel->updateInfo($_POST)){
                    $messageType = 'success';
                    $mess = "Cập nhật thành công";
                }

                $_SESSION['messType'] = $messageType;
                $_SESSION['mess'] = $mess;

                header('Location: ' .ROOT_LINK .'Department');
                exit;
            } else {
                $this->viewLogin();
            }
        }
    }
?>