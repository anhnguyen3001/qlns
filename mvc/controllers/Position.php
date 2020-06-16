<?php 
    class Position extends Controller {
        private $positionModel;
        private $wageModel;
        private $validation;

        public function __construct()
        {
            $this->positionModel = $this->model("PositionModel");
            $this->wageModel = $this->model("WageModel");
            $this->validation = new Validation;
        }
        
        public function show (){
            if (isset($_SESSION['user'])){
                $this->view('layout1', array_merge($this->transferMessage(), [
                    'page' => 'position',
                    'title' => 'Danh sách chức vụ',
                    'positions' => $this->positionModel->getAllPosition()
                ]));
            } else {
                $this->viewLogin();
            }
        }

        public function edit(){
            if (isset($_SESSION['user'])){
                $messageType = 'fail';
                $mess = 'Cập nhật chức vụ không thành công';

                $_POST = $this->validation->validate($_POST);
                
                if (!empty($_POST) && $this->positionModel->updateInfo($_POST)){
                    $messageType = 'success';
                    $mess = 'Cập nhật chức vụ thành công';
                }

                $_SESSION['messType'] = $messageType;
                $_SESSION['mess'] = $mess;

                header('Location: ' .ROOT_LINK .'Position');
                exit;
            } else {
                $this->viewLogin();
            }
        }

        public function add(){
            if (isset($_SESSION['user'])){
                if (!empty($_POST)){
                    $messageType = 'fail';
                    $mess = 'Thêm chức vụ không thành công';
                    
                    $size = sizeof($_POST);
                    $_POST = $this->validation->validate($_POST);

                    if ($size == sizeof($_POST)){
                        $name = $_POST['positionTitle'];
                        // Check if this position exists in db
                        if (empty($this->positionModel->getPositionInfo(['positionTitle' => $name]))){
                            if ($this->positionModel->add($_POST)){
                                $messageType = 'success';
                                $mess = 'Thêm chức vụ thành công';
                            }
                        } else $mess = 'Chức vụ đã tồn tại';
                    }

                    $_SESSION['messType'] = $messageType;
                    $_SESSION['mess'] = $mess;
                }
                
                header('Location: ' .ROOT_LINK .'Position');
                exit;
            } else {
                $this->viewLogin();
            }
        }
    }
?>