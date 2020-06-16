<?php
    class AttendanceModel extends MasterModel{
        public function getAttendance($data){
            $empID = $data['employeeID'];
            $date = $data['date'];

            $query ="
                SELECT * FROM attendance
                WHERE employeeID = ? AND date = ?
            ";

            return $this->selectSingle($query, [$empID, $date], 'ss');
        }

        public function add ($data){
            $type = str_repeat('sss', sizeof($data)/3);
            $values = str_repeat('(?, ?, ?), ', sizeof($data)/3 - 1) .'(?, ?, ?)';

            $query = "
                INSERT INTO attendance (employeeID, status, date)
                VALUES $values
            ";
            
            return $this->update($query, $data, $type);
        }

        public function getAttendances($data){
            $query = "
                SELECT a.employeeID, fullName, status, date, j.departmentID, departmentTitle 
                FROM `attendance` a
                JOIN employee e ON e.employeeID = a.employeeID 
                JOIN jobhis j ON j.employeeID = a.employeeID
                JOIN department d ON d.departmentID = j.departmentID
                WHERE startDate = (
                    SELECT MAX(startDate) FROM jobhis job 
                    WHERE job.employeeID = j.employeeID AND job.startDate <= ?
                ) AND MONTH(a.date) = MONTH(?) AND YEAR(a.date) = YEAR(?) AND j.departmentID = ? AND (e.resignDate IS NULL OR e.resignDate > NOW())
                ORDER BY fullName DESC
            ";
                
            $type = '';
            $temp = [];

            $month = $data['month'] .'-01';
            $month = date('Y-m-d', strtotime($month));
            $temp = [$month, $month, $month];
            $type = 'sss';

            $type .= 'i';
            array_push($temp, $data['departmentID']);
            
            return $this->select($query, $temp, $type);
        }
    }
?>