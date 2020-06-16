<?php
    class MasterModel{
        private $conn;

        public function __construct(){
            $db = Database::getInstance();
            $this->conn = $db->getConn();
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