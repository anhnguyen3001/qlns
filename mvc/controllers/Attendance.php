<?php
    class Attendance extends Controller{
        private $departmentModel;
        private $employeeModel;
        private $attendanceModel;

        public function __construct()
        {
            $this->employeeModel = $this->model('EmployeeModel');
            $this->departmentModel = $this->model('DepartmentModel');
            $this->attendanceModel = $this->model('AttendanceModel');
        }

        public function show(){
            if (isset($_SESSION['user'])){
                $filter = [];

                if (!isset($_GET['month']))
                    $_GET['month'] = date('Y-m');

                if (!isset($_GET['departmentID'])){
                    // Use for manager review after tick
                    $_GET['departmentID'] = isset($_SESSION['departmentID']) ? $_SESSION['departmentID'] : 1;
                }

                $this->view('layout1',array_merge($this->transferMessage(), [
                    'page' => 'attendance',
                    'title' => 'Quản lí chấm công',
                    'filters' => $_GET,
                    'attendances' => $this->groupAttendance($this->attendanceModel->getAttendances($_GET)),
                    'departments' => $this->departmentModel -> getAllDepartment(),
                    'department' => $this->departmentModel -> getDepartmentInfo($_GET['departmentID']),
                    'employees' => $this->employeeModel -> getEmployeeOfDep($_GET['departmentID'])
                ]));

                
            } else {
                $this->viewLogin();
            }
        }

        public function add(){
            if (isset($_SESSION['user'])){
                if (isset($_POST)){
                    // Check if has added to db
                    $date = date('Y-m-d', strtotime($_POST['date']));
                    unset($_POST['date']);

                    $_SESSION['messType'] = 'fail';
                    $_SESSION['mess'] = 'Chấm công không thành công';
                    
                    $temp = [];
                    $submitFail = false;
                    foreach ($_POST as $id => $status) {
                        array_push($temp, $id);
                        array_push($temp, $status);
                        array_push($temp, $date);
                        if ($this->attendanceModel->getAttendance(['employeeID' => $id,'date' => $date])){
                            $_SESSION['mess'] = 'Bạn đã chấm công trước đây';
                            $submitFail = true;
                        }
                    }

                    // Insert into db
                    if (!$submitFail && $this->attendanceModel->add($temp)){
                        $_SESSION['messType'] = 'success';
                        $_SESSION['mess'] = 'Chấm công thành công';
                    }

                    header('Location: ' .ROOT_LINK .'Attendance');
                    exit;
                }
            } else {
                $this->viewLogin();
            }
        }

        public function groupAttendance($data){
            if (sizeof($data) > 0){
                $previousID = '';
                $employee = [];
                $i = -1;

                foreach ($data as $value) {
                    // Check if other employee
                    if ($value['employeeID'] != $previousID){
                        $previousID = $value['employeeID'];

                        array_push($employee, [
                            $previousID =>['fullName' => $value['fullName'],'date' => [], 'status' => []]]
                        );
                        ++$i;
                    }
                    
                    // Get day
                    $temp = preg_split('/-/', date('d-m-Y', strtotime($value['date'])));
                    
                    $day = strval(((int)$temp[0]));
                    array_push($employee[$i][$previousID]['date'], $day);
                    array_push($employee[$i][$previousID]['status'], $value['status']);
                }

                return $employee;
            }
            return [];
        }
    }
?>