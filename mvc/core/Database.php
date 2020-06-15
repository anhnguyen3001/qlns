<?php
    class Database{
        protected $conn;
        protected $host = 'localhost';
        protected $username = 'root';
        protected $password = '';
        protected $dbname = 'test';
        // protected $host = 'remotemysql.com';
        // protected $username = 'qmjtIGTXEU';
        // protected $password = 'soYqFpK4uT';
        // protected $dbname = 'qmjtIGTXEU';

        public function __construct(){
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            $this->conn->set_charset('utf8');
        }

        public function select($query, $data = [], $type = ''){
            $stmt = $this->conn->prepare($query);
            
            if(!empty($type)){
                $stmt->bind_param($type, ...array_values($data));
            }
            
            $stmt->execute();
            
            $res = $stmt->get_result();
            $resultList = array();
            
            $i = 0;
            if ($res){
                while ($row = $res->fetch_assoc()){
                    $resultList[$i++] = $row;
                }
            }

            return $resultList;
        }

        public function selectSingle($query, $data = [], $type = ''){
            $stmt = $this->conn->prepare($query);
            
            if(!empty($type)){
                $stmt->bind_param($type, ...array_values($data));
            }

            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($res){
                return $res->fetch_assoc();
            }

            return;
        }

        // User for update, delete and insert query
        public function update($query, $data, $type){
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($type, ...array_values($data));
            return ($stmt->execute());
        }

        
    }
?>