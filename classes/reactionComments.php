<?php
class ReactionsComments {
    private $conn;
    private $table_name = "reactionsComments";

    public $id;
    public $reaction;
    public $reaction_date;
    public $publication_id;
    public $comment_id;
    public $user_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour lire les réactions avec les commentaires et les informations de l'utilisateur
    public function read(){
        $stmt = $this->conn->prepare('
            SELECT rc.*, u.username, c.comment_text 
            FROM '. $this->table_name .' rc 
            JOIN users u ON rc.user_id = u.id  
            JOIN comments c ON rc.comment_id = c.id
            WHERE rc.publication_id = :publication_id 
            ORDER BY rc.reaction_date DESC
        ');

        // Lier les paramètres
        $stmt->bindParam(":publication_id", $this->publication_id);
        $stmt->execute();

        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour créer une nouvelle réaction
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 (reaction, publication_id, comment_id, user_id) 
                 VALUES (:reaction, :publication_id, :comment_id, :user_id)";
        $stmt = $this->conn->prepare($query);
    
        // Lier les paramètres
        $stmt->bindParam(":reaction", $this->reaction);
        $stmt->bindParam(":publication_id", $this->publication_id);
        $stmt->bindParam(":comment_id", $this->comment_id);
        $stmt->bindParam(":user_id", $this->user_id);
    
        // Exécuter la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour supprimer une réaction
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
    
        // Exécuter la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour lire une réaction spécifique par utilisateur et commentaire
    public function readByUserAndComment() {
        $query = "SELECT * FROM reactionsComments WHERE comment_id = :comment_id AND user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        // Lier les paramètres
        $stmt->bindParam(":comment_id", $this->comment_id);
        $stmt->bindParam(":user_id", $this->user_id);
        
        // Exécuter la requête
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
