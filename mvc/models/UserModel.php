<?php
    class UserModel extends Database{
        public function getAllUser(){
            $query = "
                SELECT loginName, password, role, u.employeeID ,if (u.employeeID IS NULL,  loginName, fullName) username
                FROM user u
                LEFT JOIN employee e ON e.employeeID = u.employeeID
            ";

            return $this->select($query);
        }

        public function getUser($data){
            $type = '';
        
            $where = join(' = ? AND ', array_keys($data)) .' = ?';

            $query = "SELECT * FROM user WHERE ".$where;
            $type = str_repeat('s', sizeof($data));

            return $this->selectSingle($query, $data, $type);
        }

        public function updatePassword($data){
            $query = "
                UPDATE user
                SET password = ?
                WHERE username = ?
            ";

            return $this->update($query, $data, 'ss');
        }

        public function delete($data){
            $query = "
                DELETE FROM user
                WHERE loginName = ?
            ";

            return $this->update($query, $data, 's');
        }

        public function insert($data){
            if (isset($data['dob'])){
                $password = date('d-m-Y', strtotime($data['dob']));
                $password = str_replace('-', '', $password);
            } else $password = $data['password'];

            $user = [
                "loginName" => $data['employeeID'],
                "employeeID" => $data['employeeID'],
                "password" => $password,
                "role" => join(' ', array_values($data['role']))
            ];

            $column = '(' .join(', ', array_keys($user)) .')';
            $type = 'ssss';

            $query = "INSERT INTO user $column VALUES (?, ?, ?, ?)";

            return $this->update($query, $user, $type);
        }

        public function getManagerAccount($data){ 
            $query = "
                SELECT d.*, employeeID, fullName
                FROM department d
                JOIN 
                (
                    SELECT j.employeeID, fullName, j.departmentID FROM jobhis j
                    JOIN employee e ON e.employeeID = j.employeeID
                    JOIN position p ON p.positionID = j.positionID
                    LEFT JOIN user u ON u.employeeID = j.employeeID
                    WHERE 'pos' (e.resignDate IS NULL OR e.resignDate < NOW()) 
	                    AND startDate = 
                        (
                            SELECT MAX(startDate) FROM jobhis 
                            WHERE jobhis.employeeID = j.employeeID AND startDate <= NOW()
                        ) AND u.employeeID IS NULL
                ) job ON job.departmentID = d.departmentID 
            ";
            
            
            $type = '';
            if ($data['departmentTitle'] != '') {
                $query .= ' WHERE departmentTitle = ?';
                $type .= 's';
            } else unset($data['departmentTitle']);

            if ($data['positionTitle'] != ''){
                $query = preg_replace('/\'pos\'/', 'positionTitle = ? AND', $query);
                $type .= 's';
            } else {
                unset($data['positionTitle']);
                $query = preg_replace('/\'pos\'/', '', $query);
            }

            return  $this->select($query, $data, $type);
        }
    }
?>