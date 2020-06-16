<?php
    class Validation {
        function isID($id){
            return preg_match('/^[0-9]{5}$/', $id);
        }

        function isName($name){
            $name = mb_convert_case($name, MB_CASE_LOWER, "UTF-8");
            $regex = "/^([a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]+\s*)+$/u";
            
            return preg_match($regex, $name);
        }

        function isAddress($text){
            $text = mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
            $regex = "/^[1-9]*[0-9]*([a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]+\s*)+$/u";
            
            return preg_match($regex, $text);
        }

        function isPhone($number){
            $regex = '/^[0-9]{10}$/';
            return preg_match($regex, $number);
        }

        function isNumber($salary){
            $regex = '/^\d+$/';
            
            return preg_match($regex, $salary);
        }

        function isAllowance($value){
            $regex = '/^\d+\.*\d*$/';

            return preg_match($regex, $value);
        }

        // Format Data
        function mb_ucfirst($string) {
            $encoding = "UTF-8";
            $string = mb_strtolower($string, $encoding);
            $firstChr = mb_strtoupper(mb_substr($string, 0, 1,$encoding),$encoding);
            return $firstChr . mb_substr($string, 1, null, $encoding);
        }

        public function formatData($key, $value){
            $value = trim($value);
            $value = str_replace('/\s{2,}/', ' ', $value);
            $value = strtoupper($value);

            // switch ($key){
            //     case 'departmentTitle': case 'positionTitle': case 'gender': case 'qualification':
            //         $value = $this->mb_ucfirst($value);
            //         break;
            //     case 'fullName': case 'address':  
            //         $value = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
            //         break;
            //     case 'dob': case 'startDate': case 'previousDate'; case 'validDate':
            //         $value = date ('Y-m-d', strtotime($value));
            //         break;
            // }

            return $value;
        }

        public function validate($data){
            foreach ($data as $key => $value) {
                if (!empty($value)){
                    $value = $data[$key] = $this->formatData($key, $value);

                    // switch ($key){
                        // case 'fullName': case 'gender': case 'qualification': 
                        // case 'departmentTitle': case 'positionTitle':
                        //     if(!$this->isName($value)) return []; break;
                        // case 'address':
                        //     if(!$this->isAddress($value)) return []; break;
                        // case 'wage': 
                        //     if(!$this->isNumber($value)) return []; break;
                        // case 'allowance':
                        //     if(!$this->isAllowance($value)) return []; break;
                        // case 'phone': 
                        //     if(!$this->isPhone($value)) return []; break;
                        // default: break;
                    // }
                }
            }
            print_r($data);            
            return $data;
        }
    }
?>