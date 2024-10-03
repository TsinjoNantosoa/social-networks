<?php
    class Password{
        private $pdo;
        public $email;
        public $token;
        public $expires;
        public function __construct($db){
            $this->pdo = $db;
        }
        public function verifyToken(){
            $stmt = $this->pdo->prepare("SELECT email FROM password_resets WHERE token = :token AND expires = :expires");
            $stmt->bindParam(":token", $this->token);
            $stmt->bindParam(":expires", $this -> expires);
            $stmt->execute();
            return $stmt -> fetch();
        }
        public function stockToken() {
            // Set the expiration to 1 hour from the current time (3600 seconds)
            $this->expires = time() + 3600;
        
            $stmt = $this->pdo->prepare("INSERT INTO password_resets (email, token, expires) VALUES (:email, :token, :expires)");
        
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':token', $this->token);
            $stmt->bindParam(':expires', $this->expires, PDO::PARAM_INT);  // Make sure it's bound as an integer
        
            if ($stmt->execute()) {
                return true;
            } else {
                // Affiche les erreurs SQL
                print_r($stmt->errorInfo());
                return false;
            }
        }
        public function deleteToken(){
            $stmt = $this->pdo->prepare("DELETE FROM password_resets WHERE token = :token");
            $stmt->bindParam(":token", $this->token);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
        
    }
?>