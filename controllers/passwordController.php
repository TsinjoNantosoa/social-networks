<?php

include_once '../classes/user.php';
include_once '../classes/password.php';
include_once '../classes/db.php';

$database = new Db();
$db = $database->connection();

$user = new User($db);
$reset = new Password($db);

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    // Étape 1 : Envoi du jeton de réinitialisation par e-mail
    case 'request_reset':
        $email = $_POST['email'];
        $user->email = $email;
        if ($user->verifyEmail()) {
            // Génère un jeton unique
            $reset->token = bin2hex(random_bytes(16)); // Token sécurisé, génère un jeton de 32 caractères
            
            $reset->email = $email;
            $reset->expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

            // Stocke le jeton dans la base de données
            if ($reset->stockToken()) {
                // Lien de réinitialisation du mot de passe
                $resetLink = "http://localhost:8000/display/users/reset_password.php?token=" . $reset->token . "&expires=" . $reset -> expires;
                $subject = "Réinitialisation de votre mot de passe";
                $message = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink";
                $headers = "From: admin@admin.com\r\n";
                

                // Envoi de l'e-mail avec la fonction mail()
                if (mail($email, $subject, $message, $headers)) {
                    echo 'Un e-mail de réinitialisation a été envoyé.';
                } else {
                    echo "Erreur lors de l'envoi de l'e-mail.";
                }
            } else {
                echo "Erreur lors de la génération du jeton.";
            }
        } else {
            echo "Adresse e-mail non trouvée.";
        }
        break;

    // Étape 2 : Réinitialisation du mot de passe
    case 'reset_password':
        $reset -> token = $_POST['token'];
        $user -> password = $_POST['password'];
        $reset -> expires = $_POST['expires'];

        // Vérifie le jeton et sa validité
        $tokenData = $reset->verifyToken(); 
        if ($tokenData) {
            $user->email = $tokenData['email'];

            // Mise à jour du mot de passe dans la base de données
            if ($user->update_Password()) {
                // Supprimer le jeton après utilisation
                $reset->deleteToken();
                header("location: ../index.php");
            } else {
                echo "Erreur lors de la mise à jour du mot de passe.";
            }
        } else {
            echo "Jeton invalide ou expiré.";
        }
        break;

    default:
        echo "Action non reconnue.";
        break;
}
?>
