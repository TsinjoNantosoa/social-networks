<?php
    include_once '../classes/publications.php';
    include_once '../classes/db.php';
    include_once '../classes/comment.php';
    include_once '../classes/reactionPublications.php';
    include_once '../classes/reactionComments.php';
    include_once '../classes/user.php';
    session_start();
    $database= new Db();
    $db=$database->connection();
    $publication= new Publication($db);
    $comment= new Comment($db);
    $user = new User($db);
    $reactionPub= new ReactionsPublications($db);
    $reactionCom= new ReactionsComments($db);
    $action= isset($_GET['action'])? $_GET['action'] : die('error:action not found');
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../index.php");
        exit();
    }

    switch($action){
        case 'create':
            if (isset($_POST['title'])) {
                $publication->title = $_POST['title'];
                $publication->content = $_POST['content'];
                $publication->user_id = $_SESSION['user_id'];
        
                // Gestion de l'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $target_dir = "../public/img/publication/";
                
                    // Récupérer le nom d'origine du fichier et l'extension
                    $original_file_name = basename($_FILES["image"]["name"]);
                    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
                    $new_file_name = $_SESSION['username'] . '_' . pathinfo($original_file_name, PATHINFO_FILENAME) . '.' . $imageFileType;
                
                    // Chemin complet vers le fichier cible
                    $target_file = $target_dir . $new_file_name;
                
                    // Vérifier que le fichier est bien une image
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check !== false) {
                        // Déplacer l'image vers le dossier de destination avec le nouveau nom
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            // Enregistrer le chemin du fichier dans la base de données
                            $publication->image = $target_file;
                        } else {
                            echo "Erreur lors du téléchargement de l'image.";
                            exit();
                        }
                    } else {
                        echo "Le fichier n'est pas une image.";
                        exit();
                    }
                } else {
                    $publication->image = null; // Aucune image
                }                
        
                if ($publication->create()) {
                    $lastPublicationId = $db->lastInsertId();
                    $_SESSION['publication_id'] = $lastPublicationId;
                    echo json_encode(['message' => 'Publication créée avec succès']);
                    header('location: publicationsController.php?action=read');
                }
            }
            elseif(isset($_POST['publication_id'])){
                $comment -> publication_id = $_POST['publication_id'];
                $comment -> user_id = $_SESSION['user_id'];
                $comment -> content = $_POST["content"];
                echo $_SESSION['user_id']. " ".$_POST['publication_id']." ito ".$_POST["content"];
                if($comment -> create()){
                    header('location: publicationsController.php?action=read');
                    echo json_encode(['message' => 'commentaire créée avec succès']);
                }
            }
            else{
                header('location: ../display/publications/publications.php');
            }
            
            break;        
        
        case 'react':
            if (isset($_GET['reaction']) && isset($_GET['idpublication'])) {
                $reactionPub->reaction = $_GET['reaction'];
                $reactionPub->publication_id = $_GET['idpublication'];
                $reactionPub->user_id = $_SESSION['user_id'];

                // Vérifie si l'utilisateur a déjà réagi
                $existingReaction = $reactionPub->readByUserAndPublication();

                if ($existingReaction) {
                    // Supprimer la réaction existante
                    $reactionPub->id = $existingReaction['id'];
                    if ($reactionPub->delete()) {
                        echo "efa nisy";
                        header('location: publicationsController.php?action=read&idpublication='.$_GET['idpublication']);
                    }
                } else {
                    // Créer une nouvelle réaction
                    if ($reactionPub->create()) {
                        echo "mbl tsy nidsy";
                        // require '../display/publications/publications.php';
                        header('location: publicationsController.php?action=read&idpublication='.$_GET['idpublication']);
                    }
                }
            } elseif (isset($_GET['reaction']) && isset($_GET['idcomment'])) {
                // Logique similaire pour les réactions aux commentaires
                $reactionCom->publication_id = $_GET['idpubli'];
                $reactionCom->comment_id = $_GET['idcomment'];
                $reactionCom->user_id = $_SESSION['user_id'];
                
                // Lecture de la réaction existante pour le commentaire
                $existingReaction = $reactionCom->readByUserAndComment();
                
                // Si une réaction existe, on la supprime
                if ($existingReaction) {
                    $reactionCom->id = $existingReaction['id'];
                    if ($reactionCom->delete()) {
                        header('location: publicationsController.php?action=read&idcomment='.$_GET['idcomment'].'&idpublication='.$_GET['idpubli']);
                    }
                } else {
                    // Sinon on crée une nouvelle réaction
                    $reactionCom->reaction = $_GET['reaction'];
                    if ($reactionCom->create()) {
                        header('location: publicationsController.php?action=read&idcomment='.$_GET['idcomment'].'&idpublication='.$_GET['idpublication']);
                    }
                }
            } else {
                echo "Réaction non valide.";
            }            
            break;
        
        case 'read':
            // $user->id=$_GET['user_id'];
            // var_dump($_GET['user_id']);
            $publications = $publication-> read();
            // $users = $user->readProfile();
            // var_dump($users);
            $comments = $comment-> read();
            if (isset($_GET['idpublication'])) {
                $reactionPub->publication_id = $_GET['idpublication'];
                $reactionsPubs = $reactionPub->count();

                $reaction_counts = [
                    'like' => 0,
                    'love' => 0,
                    'sad' => 0,
                    'funny' => 0
                ];

                foreach ($reactionsPubs as $reaction) {
                    $reaction_counts[$reaction['reaction']] = $reaction['total'];
                }
            }
            if(isset($_GET['idcomment'])){
                $reactionCom->publication_id = $_GET['idcomment'];
                $reactionCom->publication_id = $_GET['idpublication'];
                $reactionsComs = $reactionCom->count();

                $reaction_counts = [
                    'like' => 0,
                    'love' => 0,
                    'sad' => 0,
                    'funny' => 0
                ];

                foreach ($reactionsComs as $reaction) {
                    $reaction_counts[$reaction['reaction']] = $reaction['total'];
                }
            }
                require '../display/publications/publications.php';
            break;
        case 'search':
            $publication->search=$_POST['search'];
            $publications = $publication-> search();
            $users = $user->read();
            $comments = $comment-> read();
            if (isset($_GET['idpublication'])) {
                $reactionPub->publication_id = $_GET['idpublication'];
                $reactionsPubs = $reactionPub->count();

                $reaction_counts = [
                    'like' => 0,
                    'love' => 0,
                    'sad' => 0,
                    'funny' => 0
                ];

                foreach ($reactionsPubs as $reaction) {
                    $reaction_counts[$reaction['reaction']] = $reaction['total'];
                }
            }
            if(isset($_GET['idcomment'])){
                $reactionCom->publication_id = $_GET['idcomment'];
                $reactionCom->publication_id = $_GET['idpublication'];
                $reactionsComs = $reactionCom->count();

                $reaction_counts = [
                    'like' => 0,
                    'love' => 0,
                    'sad' => 0,
                    'funny' => 0
                ];

                foreach ($reactionsComs as $reaction) {
                    $reaction_counts[$reaction['reaction']] = $reaction['total'];
                }
            }
            // echo 'ito';
                require '../display/publications/publications.php';
            break;
        case 'delete':
            if (isset($_GET['id'])) {
                $publication->id = $_GET['id'];
                // $publication->image = $_GET['image'];
                if ($publication->delete()) {
                    if ($_SESSION['publication_id'] == $_GET['id']) {
                        exec("rm " . $_GET['image']);
                        unset($_SESSION['publication_id']);
                    }
                    header('location: publicationsController.php?action=read');
                }
            } elseif (isset($_GET['idcomment'])) {
                $comment->id = $_GET['idcomment'];
                if ($comment->delete()) {
                    header('location: publicationsController.php?action=read');
                }
            } elseif (isset($_GET['idreactionPub'])) {
                $reactionPub->id = $_GET['idreactionPub'];
                if ($reactionPub->delete()) {
                    header('location: publicationsController.php?action=read');
                }
            } elseif (isset($_GET['idreactionCom'])) {
                $reactionCom->id = $_GET['idreactionCom'];
                if ($reactionCom->delete()) {
                    header('location: publicationsController.php?action=read');
                }
            } else {
                echo "Erreur: identifiant non trouvé.";
            }
            
            break;
        case 'update':
            if (isset($_GET['id'])) {
                $publication->title = $_POST['title'];
                $publication->content = $_POST["content"];
                $publication->id = $_GET['id'];
                if ($_FILES['image']['name']) {
                    exec("rm " . $_GET['image']);
                    $target_dir = "../public/img/publication/";
                
                    // Récupérer le nom d'origine du fichier et l'extension
                    $original_file_name = basename($_FILES["image"]["name"]);
                    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
                    $new_file_name = $_SESSION['username'] . '_' . pathinfo($original_file_name, PATHINFO_FILENAME) . '.' . $imageFileType;
                
                    // Chemin complet vers le fichier cible
                    $target_file = $target_dir . $new_file_name;
                
                    // Vérifier que le fichier est bien une image
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check !== false) {
                        // Déplacer l'image vers le dossier de destination avec le nouveau nom
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            // Enregistrer le chemin du fichier dans la base de données
                            $publication->image = $target_file;
                        } else {
                            echo "Erreur lors du téléchargement de l'image.";
                            exit();
                        }
                    } else {
                        echo "Le fichier n'est pas une image.";
                        exit();
                    }
                } else {
                    $publication->image = $_GET['image'];
                }
                if ($publication->update()) {
                    header('location: publicationsController.php?action=read');
                }
            } elseif (isset($_GET['idcomment'])) {
                $comment->content = $_POST["content"];
                $comment->id = $_GET['idcomment'];
                if ($comment->update()) {
                    header('location: publicationsController.php?action=read');
                }
            } elseif (isset($_GET['idpublication'])) {
                $reactionPub->reaction = $_POST["reaction"];
                $reactionPub->publication_id = $_GET['idpublication'];
                $reactionPub->user_id = $_SESSION['user_id'];
                if ($reactionPub->updateReactionsPublications()) {
                    header('location: publicationsController.php?action=read');
                }
            }
            break;
        case 'detailUpdate':
            $id = $_GET['id'];
            $publication->id = $id;
            $publicationDetails = $publication->detail();
            if ($publicationDetails) {
                require '../display/publications/update.php'; 
            } else {
                echo 'Étudiant non trouvé.';
            }
            break;
        default:
            echo "ERROR: invalid ACTION.";
            break;
    }
    
?>