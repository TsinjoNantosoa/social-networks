<?php
    class Db{
        private $dsn='mysql:host=localhost;dbname=socialNetwork';
        private $username = 'tsinjo';
        private $password = 'nantosoa123';
        public $pdo;
        public function connection(){
            // $this->pdo=NUll;
            try {
                $this->pdo= new PDO($this->dsn,$this->username,$this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo 'mety';
            } catch (PDOException $e) {
                echo"error: ".$e->getMessage();
            }
            return $this->pdo;
        }
    }
    // $db=new Db();
    // $db->connection();
?>