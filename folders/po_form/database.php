<?php
require_once __DIR__ . '/../../config/env.php';
class Database {
        private $host = "localhost";
        private $database_name = "operation_team_beta";
        private $username = project_env('APP_DB_USERNAME', 'root');
        private$password = project_env('APP_DB_PASSWORD');
        public $conn;
        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    } 
?>


