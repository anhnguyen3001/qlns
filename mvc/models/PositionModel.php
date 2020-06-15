<?php
    class PositionModel extends Database{
        public function getAllPosition(){
            $query = "
                SELECT * FROM position
            ";

            return $this->select($query);
        }

        public function getPositionInfo($data){
            $where = '';
            $type = $this->getType($data);

            $where = 'WHERE ' .join(' = ? AND ', array_keys($data)) .' = ?';

            $query = 'SELECT * FROM position ' .$where;
      
            return $this->selectSingle($query, $data, $type);
        }

        public function getPosition($id){
            $query = "
                SELECT p.*
                FROM position p 
                WHERE p.positionID = $id
                ORDER BY allowance DESC
            ";

            return $this->select($query);
        }

        public function updateInfo($data){
            $id = $data['positionID'];
            unset($data['positionID']);

            $type = $this->getType($data);

            $set = 'SET ' .join(' = ?,', array_keys($data)) .' = ?';

            $query = "UPDATE position
                    $set
                    WHERE positionID = $id";
            
            return $this->update($query, $data, $type);
        }

        public function add($data){
            $type = $this->getType($data);
            $columns = '(' .join(', ', array_keys($data)) .')';
            $values = '(' .str_repeat('?, ', sizeof($data) - 1) .'?)';

            $query = "
                INSERT INTO position $columns
                VALUES $values    
            ";

            return $this->update($query, $data, $type);
        }

        private function getType($data){
            $type = '';

            foreach($data as $key => $value){
                switch ($key){
                    case 'positionTitle': $type .= 's'; break;
                    case 'positionID': $type .= 'i'; break;
                    default: $type .= 'd'; break;
                }
            }

            return $type;
        }
    }
?>