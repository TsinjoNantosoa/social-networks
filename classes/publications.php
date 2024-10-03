<?php
    class Publication{
        private $pdo;
        public $id;
        public $title;
        public $content;
        public $image;
        public $publication_date;
        public $user_id;
        public function __construct($db){
            $this->pdo = $db;
        }
        public function read(){
            $stmt=$this->pdo->prepare('SELECT p.*, u.username FROM publications p JOIN users u ON p.user_id = u.id ORDER BY publication_date DESC');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function create() {
            $stmt = $this->pdo->prepare("INSERT INTO publications(title, content, user_id, image) VALUES (:title, :content, :user_id, :image)");
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":image", $this->image);
    
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        public function search(){
            $stmt = $this->pdo->prepare("
            SELECT p.*, u.username FROM publications p JOIN users u ON p.user_id = u.id WHERE (title REGEXP :search 
            OR content REGEXP :search) ORDER BY publication_date DESC
            ");
            // Ajouter des jokers pour REGEXP
            $searchRegExp = '.*' . $this->search . '.*';
            $stmt->bindParam(":search", $searchRegExp);
            $stmt->execute();
            // echo "ito";
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function delete(){
            try {
                // Supprimer les réactions associées
                $stmt = $this->pdo->prepare("DELETE FROM reactionsPublications WHERE publication_id = :id");
                $stmt->bindParam(":id", $this->id);
                $stmt->execute();
                
                $stmt = $this->pdo->prepare("DELETE FROM reactionsComments WHERE publication_id = :id");
                $stmt->bindParam(":id", $this->id);
                $stmt->execute();
        
                // Supprimer les commentaires associés
                $stmt = $this->pdo->prepare("DELETE FROM comments WHERE publication_id = :id");
                $stmt->bindParam(":id", $this->id);
                $stmt->execute();
        
                // Supprimer la publication
                $stmt = $this->pdo->prepare("DELETE FROM publications WHERE id = :id");
                $stmt->bindParam(":id", $this->id);

                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
        
            } catch (Exception $e) {
                echo "Erreur lors de la suppression de la publication : " . $e->getMessage();
            }
        }
        public function update(){
            // Mettre à jour la publication
            $stmt = $this->pdo->prepare("UPDATE publications SET title = :title , content = :content, image = :image WHERE id = :id ");
            $stmt->bindValue(":title", $this->title);
            $stmt->bindValue(":content", $this->content);
            $stmt->bindValue(":image", $this->image);
            $stmt->bindValue(':id', $this->id);
            if($stmt->execute()){
                // echo $this->title ." ". $this->content." ". $this->id;
                return true;
            } else {
                return false;
            }

            }
        public function detail(){
            $stmt = $this->pdo->prepare("SELECT * FROM publications  WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
            
        
    }
?>