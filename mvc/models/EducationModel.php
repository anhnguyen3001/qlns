<?php
    class EducationModel extends Database{
        public function getAllEducation(){
            $query = "
                SELECT * FROM education
            ";

            return $this->select($query);
        }

        public function getEducation($data){
            $where = '';
            $type = '';

            if (!empty ($data)){
                $where = 'WHERE ' .join(' = ? AND ', array_keys($data)) .' = ?';
    
                foreach ($data as $key => $value) {
                    switch ($key){
                        case ('educationID'): $type .= 'i'; break;
                        default: $type .= 's'; break;
                    }
                }
            }
            

            $query = "SELECT * FROM education $where ";
           
            return $this->select($query, $data, $type);
        }

        public function create($data){
            $query = "INSERT INTO education
                    VALUES (NULL, ?)";

            return $this->update($query, [$data['qualification']], 's');
        }

        public function updateInfo($data){
            $name = $data['qualification'];
            $id = $data['educationID'];

            $query = "UPDATE education
                    SET qualification = ?
                    WHERE educationID = ?";
            $type = 'si';

            return $this->update($query, [$name, $id], $type);
        }
    }
?>