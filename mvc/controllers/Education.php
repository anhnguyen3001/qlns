<?php 
    class Education extends Controller {
        private $userModel;
        private $educationModel;
        private $validation;

        public function __construct()
        {
            $this->userModel = $this->model("UserModel");
            $this->educationModel = $this->model("EducationModel");
            $this->validation = new Validation;
        }
        
        public function show (){
            if (isset($_SESSION['user'])){
                $this->view('layout1', array_merge($this->transferMessage(), [
                    'page' => 'education',
                    'title' => 'Danh sách bằng cấp',
                    'educations' => $this->educationModel->getAllEducation()
                ]));
            } else {
                $this->viewLogin();
            }
        }

        public function add(){
            if (isset($_SESSION['user'])){
                $messageType = 'fail';
                $mess = "Thêm bằng cấp không thành công";
                
                $_POST = $this->validation->validate($_POST);
                
                if(!empty($_POST['qualification']) && !$this->educationModel->getEducation($_POST)){
                    if ($this->educationModel->create($_POST)){
                        $messageType = 'success';
                        $mess = "Thêm bằng cấp thành công";                      
                    }
                }
                else $mess = 'Bằng cấp đã tồn tại';             

                $_SESSION['messType'] = $messageType;
                $_SESSION['mess'] = $mess;

                header('Location: ' .ROOT_LINK .'Education');
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

                if($previousSize === sizeof($_POST) && $this->educationModel->updateInfo($_POST)){
                    $messageType = 'success';
                    $mess = "Cập nhật thành công";
                }

                $_SESSION['messType'] = $messageType;
                $_SESSION['mess'] = $mess;

                header('Location: ' .ROOT_LINK .'Education');
                exit;
            } else {
                $this->viewLogin();
            }
        }
    }
?>