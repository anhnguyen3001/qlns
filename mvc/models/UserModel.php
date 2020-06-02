<?php
    class UserModel extends Database{

        public function getAllUser(){
            $query = "
                SELECT loginName, password, role, username user,
                (
                    IF (((role = 'accountant') OR (role = 'personnel')), 
                    (
                        SELECT fullName FROM employee e
                        WHERE e.employeeID = username
                    ), 
                    (CONCAT ('Phòng ',(
                        SELECT departmentTitle FROM department d
                        WHERE d.departmentID = username
                    ))))
                ) username FROM user
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
                WHERE username = ?
            ";

            return $this->update($query, $data, 's');
        }

        public function createEmpAccount($data){
            if (isset($data['dob'])){
                $password = date('d-m-Y', strtotime($data['dob']));
                $password = str_replace('-', '', $password);
            } else $password = $data['password'];

            $user = [
                "loginName" => $data['employeeID'],
                "userName" => $data['employeeID'],
                "password" => $password,
                "role" => $data['role']
            ];

            return $this->createAccount($user);
        }

        public function createDepAccount($data){
            // Create login name
            $depName =  mb_strtolower($data['departmentTitle'], "UTF-8");
            $depName = explode(' ', $depName);
            unset($data['departmentTitle']);
            $data['username'] = $data['departmentID'];
            unset($data['departmentID']);

            $data['loginName'] = '';
            $data['role'] = 'manager';
            $data['password'] = DEP_PASSWORD;

            foreach ($depName as $value) {
                $data['loginName'] .= substr($value, 0, 1);
            }

            return $this->createAccount($data);
        }
        

        public function createAccount($data){
            $column = '(' .join(', ', array_keys($data)) .')';
            $type = 'ssss';

            $query = "INSERT INTO user $column VALUES (?, ?, ?, ?)";

            return $this->update($query, $data, $type);
        }
    }
?>