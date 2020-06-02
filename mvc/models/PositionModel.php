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
            $type = '';

            $where = 'WHERE ' .join(' = ? AND ', array_keys($data)) .' = ?';
    
            foreach ($data as $key => $value) {
                switch ($key){
                    case ('positionID'): $type .= 'i'; break;
                    default: $type .= 's'; break;
                }
            }

            $query = 'SELECT * FROM position ' .$where;
      
            return $this->selectSingle($query, $data, $type);
        }

        public function getPosition($id){
            $query = "
                SELECT p.positionID, positionTitle, level, wage, validDate
                FROM position p 
                LEFT JOIN 
                (
                    SELECT positionID, level, wage, validDate FROM wage w
                    WHERE validDate = 
                    (
                        SELECT MAX(validDate) FROM wage
                        WHERE wage.level = w.level AND w.positionID = wage.positionID
                    )
                ) wage ON p.positionID = wage.positionID
                WHERE p.positionID = $id
                ORDER BY level ASC
            ";

            return $this->select($query);
        }

        public function updateInfo($data){
            $id = $data['positionID'];
            unset($data['positionID']);

            $type = '';
            foreach($data as $key => $value){
                switch ($key){
                    case 'positionTitle': $type .= 's'; break;
                    default: $type .= 'd'; break;
                }
            }

            $set = 'SET ' .join(' = ?,', array_keys($data)) .' = ?';

            $query = "UPDATE position
                    $set
                    WHERE positionID = $id";
            
            return $this->update($query, $data, $type);
        }

        public function add($data){
            $type = '';
            $columns = '(' .join(', ', array_keys($data)) .')';
            $values = '(' .str_repeat('?, ', sizeof($data) - 1) .'?)';

            foreach($data as $key => $value){
                switch ($key){
                    case 'positionTitle': $type .= 's'; break;
                    default: $type .= 'i'; break;
                }
            }

            $query = "
                INSERT INTO position $columns
                VALUES $values    
            ";
            
            return $this->update($query, $data, $type);
        }
    }
?>