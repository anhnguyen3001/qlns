<?php 
    class JobhisModel extends Database{
        public function insert($data){
            $columns = "(" .join(" ,", array_keys($data)) .")";
            $values = "(" .str_repeat('?, ', sizeof($data) - 1) ."?)";
            $query = "INSERT INTO jobhis $columns VALUES $values";

            $type = "";
            
            foreach ($data as $key => $value) {
                switch ($key){
                    case 'employeeID': case 'startDate': $type .= 's'; break;
                    default: $type .= 'i'; break;
                }
            }
            
            return $this->update($query, $data, $type);
        }

        public function getJobHisByEmpID($id){
            $query = "
                SELECT j.* , positionTitle, departmentTitle
                FROM jobhis j
                JOIN department d ON d.departmentID = j.departmentID
                JOIN position p ON p.positionID = j.positionID
                WHERE j.employeeID = ? AND j.startDate = 
                (
                    SELECT MAX(startDate) FROM jobhis job
                    WHERE job.employeeID = j.employeeID AND startDate <= j.startDate
                )
                ORDER BY startDate DESC
            ";

            return $this->select($query, [$id], 's');
        }

        public function updateInfo($data){
            $id = $data['employeeID'];
            unset($data['employeeID']);

            $type = '';
            $set = 'SET ' .join(' = ?, ', array_keys($data)) .' = ?';
            foreach ($data as $key => $value) {
                switch ($key){
                    case 'departmentID': case 'positionID': $type .= 'i'; break;
                    default: $type .= 's'; break;
                }
            }

            $query = "
                UPDATE jobhis
                $set
                WHERE employeeID = ? AND startDate = 
                (
                    SELECT MAX(startDate) FROM jobhis t
                    WHERE t.employeeID = ? AND startDate <= (NOW())
                )
            ";
            array_push($data, $id);
            array_push($data, $id);
            $type .= 'ss';

            return $this->update($query, $data, $type);
        }
    }
?>