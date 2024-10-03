<?php
    class Comment{
        private $pdo;
        public $id;
        public $content;
        public $comment_date;
        public $publication_id;
        public $user_id;
        public function __construct($db){
            $this->pdo = $db;
        }
        public function read(){
            $stmt=$this->pdo->prepare('SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id ORDER BY comment_date DESC');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function create(){
            $stmt = $this->pdo->prepare("INSERT INTO comments(content, publication_id, user_id) VALUES (:content, :publication_id, :user_id)");
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(":publication_id", $this->publication_id);
            $stmt->bindParam(":user_id", $this->user_id);
            // echo $this->content . " ". $this->user_id . " " . $this->publication_id;
            if ($stmt->execute()) {
                return true;
            }
            else{
                return false;
            }
        }
        public function delete(){
            
            $stmt = $this->pdo->prepare('DELETE FROM comments WHERE id = :id');
            $stmt->bindParam(':id', $this->id);
               if ($stmt->execute()) {
                   return true;
               } else {
                   return false;
               }   
        }
        public function update(){
            $stmt=$this->pdo->prepare("UPDATE comments SET content = :content WHERE id = :id ");
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(':id', $this->id);
                if($stmt->execute()){
                    return true;
                }
                else{
                    return false;
                }
            }
        public function detail(){
            $stmt = $this->pdo->prepare('SELECT * FROM comments WHERE id = :id');
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
            
        
    }
?>