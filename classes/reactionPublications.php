<?php
class ReactionsPublications {
    private $conn;
    private $table_name = "reactionsPublications";

    public $id;
    public $reaction;
    public $reaction_date;
    public $publication_id;
    public $user_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read(){
        $stmt = $this->conn->prepare("SELECT rp.*, u.username FROM " . $this->table_name . " rp JOIN users u ON rp.user_id = u.id WHERE rp.publication_id = :publication_id ORDER BY rp.reaction_date DESC");
        $stmt->bindParam(":publication_id", $this->publication_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (reaction, publication_id, user_id) VALUES (:reaction, :publication_id, :user_id)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":reaction", $this->reaction);
        $stmt->bindParam(":publication_id", $this->publication_id);
        $stmt->bindParam(":user_id", $this->user_id);
    
        if ($stmt->execute()) {

            return true;
        }
        return false;
    }
    

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readByUserAndPublication() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE publication_id = :publication_id AND user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":publication_id", $this->publication_id);
        $stmt->bindParam(":user_id", $this->user_id);
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    
    public function count(){
        $sql = "
            SELECT reaction, COUNT(*) AS total 
            FROM ". $this->table_name ."
            WHERE publication_id = :publication_id 
            GROUP BY reaction";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':publication_id', $this->publication_id);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}
?>
