<?php
    class User{
        private $pdo;
        public $id;
        public $firstname;
        public $lastname;
        public $date_of_bith;
        public $sex;
        public $email;
        public $username;
        public $password;
        public $profile_image;

        public function __construct($db){
            $this->pdo = $db;
        }

        public function verifyEmail(){
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
            return $stmt -> fetch();
        }

        public function read(){
            $stmt = $this->pdo->prepare("SELECT * FROM users");
            $stmt->execute();
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        }

        public function readProfile(){
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        }

        public function update_Password(){
            $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":email", $this->email);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function update(){
            $stmt = $this->pdo->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, date_of_birth = :date_of_birth, username = :username,  password = :password, profile_image = :profile_image WHERE email = :email");
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":date_of_birth", $this->date_of_birth);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":profile_image", $this->profile_image);
            $stmt->bindParam(":email", $this->email);
            if($stmt->execute()){
                echo "ito";
                return true;
            }
            else{
                return false;
            }
        }
        public function create(){
            $stmt = $this->pdo->prepare("INSERT INTO users(lastname,firstname,date_of_birth,sex,username, email, password, profile_image) VALUES ( :lastname,:firstname,:date_of_birth, :sex, :username, :email, :password, :profile_image)");
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":date_of_birth", $this->date_of_birth);
            $stmt->bindParam(":sex", $this->sex);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":profile_image", $this->profile_image);
            if ($stmt->execute()) {
                return true;
            }
            else{
                return false;
            }
        }
        public function verifyUser(){
            $stmt = $this->pdo-> prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
            return $stmt -> fetch();
        }
        public function login(){
            $stmt = $this->pdo->prepare("SELECT * fROM users WHERE email = :email");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
            return $stmt -> fetch();
        }
        public function delete(){
            $stmt = $this->pdo->prepare("DELETE FROM reactionsPublications WHERE user_id = :id");
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            
            $stmt = $this->pdo->prepare("DELETE FROM reactionsComments WHERE user_id = :id");
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
    
            // Supprimer les commentaires associés
            $stmt = $this->pdo->prepare("DELETE FROM comments WHERE user_id = :id");
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
    
            // Supprimer la publication
            $stmt = $this->pdo->prepare("DELETE FROM publications WHERE user_id = :id");
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();

            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(":id", $this->id);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>