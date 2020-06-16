<?php
    class WageModel extends MasterModel{
        public function getNetSalary($data){
            $query ="
                SELECT w.`employeeID`, fullName, p.*, `wage`, workDay, (wage * workDay/26) salary ,IF(workDay < 14, 0, 0.105 * wage) bh, (workDay/26 * allowance) phucap,   
                    (SELECT salary - bh + phucap) income,`validDate`
                FROM wage w
                JOIN employee e ON e.employeeID = w.employeeID
                JOIN jobhis j ON j.employeeID = w.employeeID AND j.departmentID = ? 
                JOIN position p ON p.positionID = j.positionID
                JOIN 
                (
                    SELECT a.employeeID, COUNT(*) workDay FROM attendance a
                    WHERE status = 'present' AND EXTRACT(YEAR_MONTH FROM a.date) = EXTRACT(YEAR_MONTH FROM 'time') 
                    GROUP BY employeeID
                ) a ON a.employeeID = w.employeeID
                WHERE validDate =
                (
                    SELECT MAX(validDate) FROM wage t
                    WHERE EXTRACT(YEAR_MONTH FROM validDate) <= EXTRACT(YEAR_MONTH FROM 'time') AND t.employeeID = w.employeeID
                ) AND startDate = 
                (
                    SELECT MAX(startDate) FROM jobhis t 
                    WHERE t.employeeID = w.employeeID AND EXTRACT(YEAR_MONTH FROM t.startDate) <= EXTRACT(YEAR_MONTH FROM 'time')
                )
            ";

            $temp = [$data['departmentID']];
    
            $repeat = preg_match_all('/\'time\'/', $query, $times);
            
            $month = $data['month'] .'-01';

            for ($i = 1; $i <= $repeat; $i++)
                array_push($temp, $month);

            $query = str_replace('\'time\'', '?', $query);
            $type = 'i' .str_repeat('s', $repeat);

            return $this->select($query, $temp, $type);
        }

        public function insert($data){
            $columns = '(' .join(', ', array_keys($data)) .')';
            $values = '(' .str_repeat('?, ', sizeof($data) - 1) .'?)';
            $type = '';

            foreach ($data as $key => $value) {
                if ($key == 'wage') $type .= 'i';
                else $type .= 's';
            }

            $query = "INSERT INTO wage $columns VALUES $values";
            
            return $this->update($query, $data, $type);
        }
    }
?>