<?php
    class DepartmentModel extends Database{
        public function getAllDepartment(){
            $query = "SELECT * FROM department";
            return $this->select($query);            
        }
        
        public function getAllDepartmentInfo(){
            $query = "
                SELECT d.departmentID, d.departmentTitle, IF(job.employeeID IS NULL, 'N/A', job.employeeID) employeeID, IF(job.fullName IS NULL, 'N/A', job.fullName) fullName
                FROM department d
                LEFT JOIN 
                (
                    SELECT j.employeeID, fullName, j.departmentID FROM jobhis j
                    JOIN employee e ON e.employeeID = j.employeeID
                    JOIN position p ON p.positionID = j.positionID
                    WHERE p.positionTitle = 'Trưởng phòng' AND (e.resignDate IS NULL OR e.resignDate < NOW()) 
	                    AND startDate = 
                        (
                            SELECT MAX(startDate) FROM jobhis 
                            WHERE jobhis.employeeID = j.employeeID AND startDate <= NOW()
                        ) AND (e.resignDate IS NULL OR e.resignDate > NOW())
                ) job ON job.departmentID = d.departmentID
            ";

            return  $this->select($query);
        }

        public function getDepartmentInfo($id){
            $query = "
                SELECT d.departmentID, d.departmentTitle, IF(job.employeeID IS NULL, 'N/A', job.employeeID) employeeID, IF(job.fullName IS NULL, 'N/A', job.fullName) fullName
                FROM department d
                LEFT JOIN 
                (
                    SELECT j.employeeID, fullName, j.departmentID FROM jobhis j
                    JOIN employee e ON e.employeeID = j.employeeID
                    JOIN position p ON p.positionID = j.positionID
                    WHERE p.positionTitle = 'Trưởng phòng' 
	                    AND startDate = 
                        (
                            SELECT MAX(startDate) FROM jobhis 
                            WHERE jobhis.employeeID = j.employeeID AND startDate <= NOW()
                        ) AND (e.resignDate IS NULL OR e.resignDate > NOW())
                ) job ON job.departmentID = d.departmentID
                WHERE d.departmentID = ?
            ";
                            
            return $this->selectSingle($query, [$id], 'i');
        }

        public function getDepartment($data = []){
            $where = '';
            $type = '';

            if (!empty ($data)){
                $where = 'WHERE ' .join(' = ? AND ', array_keys($data)) .' = ?';
    
                foreach ($data as $key => $value) {
                    switch ($key){
                        case ('departmentID'): $type .= 'i'; break;
                        default: $type .= 's'; break;
                    }
                }
            }
            

            $query = "SELECT * FROM department $where ";
           
            return $this->select($query, $data, $type);
        }

        public function create($data){
            $query = "INSERT INTO department
                    VALUES (NULL, ?)";

            return $this->update($query, [$data['departmentTitle']], 's');
        }

        public function updateInfo($data){
            $depTitle = $data['departmentTitle'];
            $id = $data['departmentID'];

            $query = "UPDATE department
                    SET departmentTitle = ?
                    WHERE departmentID = ?";
            $type = 'si';

            return $this->update($query, [$depTitle, $id], $type);
        }
    }
?>