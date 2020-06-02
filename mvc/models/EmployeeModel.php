<?php
class EmployeeModel extends Database{
    public function getDepartmentOfEmp($id){
        $query = "
            SELECT fullName, d.*
            FROM jobhis j
            JOIN employee e ON e.employeeID = j.employeeID
            JOIN department d ON d.departmentID = j.departmentID
            WHERE (J.employeeID, startDate) IN (
                SELECT employeeID, MAX(startDate) FROM jobhis t
                WHERE startDate <= NOW() AND employeeID = ?
            )
        ";
        
        return $this->selectSingle($query, [$id], 's');
    }

    public function getEmployeeName($id){
        $query = "
            SELECT fullName FROM employee
            WHERE employeeID = ?
        ";

        return $this->selectSingle($query, [$id], 's');
    }

    public function getAllEmployees($data){
        $query = "
            SELECT e.employeeID, fullName, 
                IF(address IS NULL, 'N/A', address) address, 
                phone,
                IF(qualification IS NULL, 'N/A', qualification) qualification, 
                d.*, p.*, resignDate, dateUpdate
            FROM employee e 
            JOIN jobhis j ON e.employeeID = j.employeeID
            LEFT JOIN education edu ON edu.educationID = e.educationID
            JOIN position p ON p.positionID = j.positionID
            JOIN department d ON d.departmentID = j.departmentID
            WHERE startDate = (SELECT MAX(startDate) FROM jobhis job WHERE job.employeeID = j.employeeID AND startDate <= NOW())
        ";

        // Get limit
        $type ='';
        $limit = $data['limit'];
        $start = ($data['page'] - 1) * $limit;
        unset($data['page']);
        unset($data['limit']);

        foreach ($data as $key => $value) {
            if (!empty($value)){
                switch ($key){
                    case 'employeeID':
                        $data[$key] = '%' .$value .'%';
                        $query .= ' AND e.employeeID LIKE ?';
                        $type .= 's';
                    break;    
                    case 'fullName':
                        $data[$key] = '%' .mb_strtolower($value, 'UTF-8') .'%';
                        $query .= ' AND fullName LIKE ?';
                        $type .= 's';
                    break;    
                    case 'positionID': case 'departmentID':
                        $query .= ' AND j.' .$key .'= ?';
                        $type .= 'i';
                    break;
                    default: unset($data[$key]); break;
                }
            } else unset($data[$key]);
        }

        // total result
        $totalResult = sizeof($this->select($query, $data, $type));
        
        if ($totalResult == 0){
            return [
                'totalPage' => 0
            ];
        }

        array_push($data, $limit);
        array_push($data, $start);
        
        $query .= ' ORDER BY resignDate, dateUpdate DESC LIMIT ? OFFSET ?';
        $type .= 'ii';
        
        return [
            'totalPage' => ceil($totalResult/$limit),
            'totalResult' => $totalResult,
            'employee' => $this->select($query, $data, $type)
        ];
    }

    public function getEmployee($id){
        $query = "
        SELECT fullName, dob, phone,
            IF(gender IS NULL, 'N/A', gender) `gender` ,
            IF(address IS NULL, 'N/A', address) `address`,
            IF(resignDate IS NULL, 'N/A', resignDate) `resignDate`,
            e.educationID, IF(qualification IS NULL, 'N/A', qualification) qualification , 
            d.*, p.*, w.*,
            (
                SELECT MIN(startDate) FROM jobhis job WHERE job.employeeID = e.employeeID
            ) startDate, startDate date 
        FROM employee e 
        JOIN jobhis j ON e.employeeID = j.employeeID
        LEFT JOIN education edu ON edu.educationID = e.educationID
        JOIN position p ON p.positionID = j.positionID
        JOIN department d ON d.departmentID = j.departmentID
        JOIN 
        (
            SELECT employeeID, wage, validDate FROM wage w
            WHERE w.validDate = 
            (
                SELECT MAX(validDate) FROM wage t
                WHERE t.validDate <= NOW() AND t.employeeID = t.employeeID	
            )
        ) w ON w.employeeID = j.employeeID
        WHERE e.employeeID = ? AND startDate = 
        (
            SELECT MAX(startDate) FROM jobhis t WHERE t.employeeID = j.employeeID AND startDate <= NOW()
        )";
        
        
        return $this->selectSingle($query, [$id], 's');
    }

    public function getEmployeeOfDep($id){
        $query = "
            SELECT e.employeeID, fullName
            FROM employee e 
            JOIN jobhis j ON e.employeeID = j.employeeID
            WHERE startDate = (SELECT MAX(startDate) FROM jobhis job WHERE job.employeeID = j.employeeID AND startDate <= NOW()) AND departmentID = ? AND (e.resignDate IS NULL OR e.resignDate > NOW()) 
        ";

        return $this->select($query, [$id], 'i');
    }

    public function insert($data){
        $job = array();
        $type = '';

        foreach ($data as $key => $value) {
            $data[$key] = ($value == "") ? NULL : $value;
            switch ($key){
                case 'employeeID': $job[$key] = $value;
                case 'fullName': case 'address': case 'dob': case 'phone': case 'gender':
                    $type .= 's';
                break;
                case 'educationID':
                    $type .= 'i';
                break;
                default:
                    $job[$key] = $value;
                    unset($data[$key]);
                break;
            }
        }

        $columns = "(" .join(" ,", array_keys($data)) .", dateUpdate)";
        $values = "(" .str_repeat('?, ', sizeof($data)) ." NOW())";
        $query = "INSERT INTO employee $columns VALUES $values";
        
        return $this->update($query, $data, $type);
    }

    public function updateInformation($data){
        $empID = $data['employeeID'];
        unset($data['employeeID']);

        $query = "UPDATE employee ";
        // Build Set statement of Query
        $set = join(" = ?, ", array_keys($data)) . " = ?, dateUpdate = NOW() ";

        $data['employeeID'] = $empID;
        $type = '';
        foreach ($data as $key => $value) {
            $data[$key] = ($value == '') ? NULL : $value;

            if ($key == 'educationID') $type .= 'i';
            else $type .= 's';
        }

        
        $query .= 'SET ' .$set ."WHERE employeeID = ?";
    
        return $this->update($query, $data, $type);
    }

    public function generateEmployeeID(){
        // First 2 number
        $date = date('y');
        $query = "SELECT MAX(employeeID) `maxID` FROM employee WHERE SUBSTRING(employeeID, 1, 2) = '$date'";

        $result = $this->selectSingle($query);

        $empID = "$date";
        if ($result['maxID'] === NULL) $empID .= "001";
        else {
            $empID = ($result['maxID'] + 1);
        }

        return $empID;
    }
}
?>