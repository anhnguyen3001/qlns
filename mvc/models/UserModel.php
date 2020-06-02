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
                "role" => $data['role']
            ];

            $column = '(' .join(', ', array_keys($user)) .')';
            $type = 'ssss';

            $query = "INSERT INTO user $column VALUES (?, ?, ?, ?)";

            return $this->update($query, $user, $type);
        }
    }
?>