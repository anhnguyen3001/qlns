<?php
    class Database{
        protected $conn;
        // protected $host = 'localhost';
        // protected $username = 'root';
        // protected $password = '';
        // protected $dbname = 'test';
        private static $instance;
        protected $host = 'remotemysql.com:3306';
        protected $username = 'qmjtIGTXEU';
        protected $password = 'soYqFpK4uT';
        protected $dbname = 'qmjtIGTXEU';

        private function __construct(){
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            $this->conn->set_charset('utf8');
        }

        public static function getInstance(){
            if (!self::$instance){
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function getConn(){return $this->conn;}

        private function clone(){}
    }
?>