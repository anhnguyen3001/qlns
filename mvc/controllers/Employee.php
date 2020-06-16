<?php
    class Employee extends Controller{
        private $userModel;
        private $employeeModel;
        private $departmentModel;
        private $positionModel;
        private $educationModel;
        private $jobhisModel;
        private $wageModel;
        private $validation;

        public function __construct()
        {   
            $this->userModel = $this->model("UserModel");
            $this->employeeModel = $this->model("EmployeeModel"); 
            $this->departmentModel = $this->model("DepartmentModel");
            $this->positionModel = $this->model("PositionModel");
            $this->educationModel = $this->model("EducationModel");
            $this->wageModel = $this->model("WageModel");
            $this->jobhisModel = $this->model("JobhisModel");
            $this->validation = new Validation;
        }

        public function show(){
            if (isset($_SESSION['user'])){
                $_GET['limit'] = !empty($_GET['limit']) ? $_GET['limit'] :  DEFAULT_RECORD;
                $_GET['page'] = !empty($_GET['page']) ? $_GET['page'] :  1;
                
                // Validate
                $filter = $_GET;
                if (sizeof($_GET) > 2) {
                    $filter = $this->validation->validate($_GET);
                }

                $this->view('layout1',array_merge($this->transferMessage() ,[
                    "page" => 'employeeList',
                    "title" => "Danh sách nhân viên",
                    "filters" => $_GET,
                    "employees" => $this->employeeModel->getAllEmployees($filter),
                    "positions" => $this->positionModel->getAllPosition(),
                    "departments" => $this->departmentModel->getAllDepartment(),
                    "educations" => $this->educationModel->getAllEducation()
                ]));
            } else {
                $this->viewLogin();
            }
        }

        public function detail(){
            if (isset($_SESSION['user'])){

                $this->view('layout1', [
                    "page" => 'employeeDetail',
                    "title" => "Thông tin nhân viên",
                    "employee" => $this->employeeModel->getEmployee($_GET['employeeID']),
                    "positions" => $this->positionModel->getAllPosition(),
                    "departments" => $this->departmentModel->getAllDepartment(),
                    "educations" => $this->educationModel->getAllEducation(),
                    "jobhis" => $this->jobhisModel->getJobHisByEmpID($_GET['employeeID'])
                ]);
            } else {
                $this->view('layout2', [
                    'page' => 'login',
                    'title' => 'Đăng nhập'
                ]);
            }
        }

        public function edit(){
            if (isset($_SESSION['user'])){
                $messageType = 'fail';
                $mess = "Cập nhật không thành công";
                if(!empty($_POST)){
                    if (isset($_POST['edit-info'])){
                        unset($_POST['edit-info']);
                        $_POST = $this->validation->validate($_POST);
                        
                        if(sizeof($_POST) !== 0 && $this->employeeModel->updateInformation($_POST)){
                            $messageType = 'success';
                            $mess = "Cập nhật thành công";
                        }
                    } 
                }
                // else if (isset($_POST['add-position'])){
                //         unset($_POST['add-position']);
                //         $_POST = $this->validation->validate($_POST);
                //         $posID = $_POST['positionID'];
                //         $depID = $_POST['departmentID'];
                //         $date = $_POST['startDate'];
                        
                //         // Current position
                //         $currentPos = $_POST['currentPos'];
                //         $currentDep = $_POST['currentDep'];
                //         $previousDate = $_POST['currentPosDate'];
                //         unset($_POST['currentPos']);
                //         unset($_POST['currentDep']);
                //         unset($_POST['currentPosDate']);
                        
                //         if ($previousDate >= $date) 
                //             $mess = 'Thời gian này đã tồn tại công việc';
                //         else if ($currentDep == $depID && $currentPos == $posID)
                //             $mess = 'Công việc đã tồn tại';
                //         else {
                //             $positionTitle = $this->positionModel->getPositionInfo(['positionID' =>$_POST['positionID']])['positionTitle'];
                            
                //             if ($positionTitle != 'Trưởng phòng' || ($positionTitle =='Trưởng phòng' 
                //             && $this->departmentModel->getDepartmentInfo($_POST['departmentID'])['employeeID'] == 'N/A')){
                //                 if ($this->jobhisModel->insert($_POST)) {
                //                     $messageType = 'success';
                //                     $mess = "Cập nhật thành công";
                //                 }
                //             }
                //         }   
                //     } else if (isset($_POST['add-salary'])){
                //         unset($_POST['add-salary']);
                //         $_POST = $this->validation->validate($_POST);

                //         $wage = $_POST['wage'];
                //         $date = $_POST['validDate'];

                //         // Current
                //         $currentWage = $_POST['currentWage'];
                //         $previousDate = $_POST['currentDateWage'];
                //         unset($_POST['currentWage']);
                //         unset($_POST['currentDateWage']);
                //         unset($_POST['wage']);

                //         if ($previousDate >= $date) 
                //             $mess = 'Thời gian này đã tồn tại mức lương';
                //         else if ($currentWage == $wage)
                //             $mess = 'Mức lương đã tồn tại';
                //         else if ($this->wageModel->insert($_POST)) {
                //             $messageType = 'success';
                //             $mess = "Cập nhật thành công";
                //         }
                //     } else if (isset($_POST['edit-position'])){
                //         unset($_POST['edit-position']);

                //         $_POST = $this->validation->validate($_POST);
                //         $positionTitle = $this->positionModel->getPositionInfo(['positionID' =>$_POST['positionID']])['positionTitle'];

                //         if ($positionTitle != 'Trưởng phòng' || ($positionTitle =='Trưởng phòng' 
                //         && $this->departmentModel->getDepartmentInfo($_POST['departmentID'])['employeeID'] == 'N/A')){
                //             if ($this->jobhisModel->updateInfo($_POST)) {
                //                 $messageType = 'success';
                //                 $mess = "Cập nhật thành công";
                //             }
                //         }
                //     }

                    $_SESSION['messType'] = $messageType;
                    $_SESSION['mess'] = $mess;
                
                    echo $mess;
                // header('Location: ' .ROOT_LINK .'Employee');
                exit;
            } else {
                $this->viewLogin();
            }
        }

        public function add(){
            if (isset($_SESSION['user'])){
                if (!empty($_POST)){
                    // Check if request create account
                    if (isset($_POST['role'])){
                        $role = $_POST['role'];
                        unset($_POST['role']);
                    }

                    $length = sizeof($_POST);
                    $_POST = $this->validation->validate($_POST);
    
                    $messageType = 'fail';
                    $mess = 'Thêm hồ sơ không thành công';
                    
                    $positionTitle = $this->positionModel->getPositionInfo(['positionID' =>$_POST['positionID']])['positionTitle'];
                    
                    if ($positionTitle != 'Trưởng phòng' || ($positionTitle =='Trưởng phòng' 
                    && $this->departmentModel->getDepartmentInfo($_POST['departmentID'])['employeeID'] == 'N/A')){
                        if ($length === sizeof($_POST)){
                            // Create array to insert to jobhis table
                            $job = [
                                'employeeID' => $_POST['employeeID'],
                                'positionID' => $_POST['positionID'],
                                'departmentID' => $_POST['departmentID'],
                                'startDate' => $_POST['startDate']
                            ];

                            // Create array to insert to wage table
                            $wage =[
                                'employeeID' => $_POST['employeeID'],
                                'wage' => $_POST['wage'],
                                'validDate' => $_POST['startDate']
                            ];
                            
                            unset($_POST['positionID']);
                            unset($_POST['departmentID']);
                            unset($_POST['startDate']);
                            
                            if ($this->employeeModel->insert($_POST) 
                            && $this->jobhisModel->insert($job) && $this->wageModel->insert($wage)){
                                $messageType = 'success';
                                $mess = 'Thêm hồ sơ thành công';
                            }
                        }
        
                        // Create account
                        if ($messageType === 'success'){
                            if (isset($role)){
                                $accountInfo = [
                                    'employeeID' => $_POST['employeeID'],
                                    'dob' => $_POST['dob'],
                                    'role' => $role    
                                ];
                                
                                if ($this->userModel->insert($accountInfo)) 
                                    $mess = 'Thêm hồ sơ thành công';
                                else {
                                    $messageType = 'fail';
                                    $mess = 'Tạo tài khoản không thành công';
                                }
                            }
                        }
                    } else {
                        $mess = 'Đã tồn tại trưởng phòng cho phòng ban';
                    }   

                    $_SESSION['messType'] = $messageType;
                    $_SESSION['mess'] = $mess;
                } 
                
                header('Location: ' .ROOT_LINK .'Employee');
                exit;
            } else {
                $this->viewLogin();
            }
        }
    }
?>