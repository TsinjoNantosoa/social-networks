<?php
    include_once '../classes/user.php';
    include_once '../classes/db.php';
    session_start();
    $database= new Db();
    $db=$database->connection();
    $user= new User($db);
    $action= isset($_GET['action'])? $_GET['action'] : die('error:action not found');
    
    switch($action){
        case 'create':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $user->lastname = $_POST['lastname'];
                    $user->firstname = $_POST['firstname'];
                    $user->date_of_birth = $_POST['date_of_birth'];
                    $user->sex = $_POST['sex']; 
                    $user->username = $_POST['username'];
                    $user->email = $_POST['email'];
                    $user->password = $_POST['password'];
                    
                    // Gestion du téléchargement d'image
                    if (isset($_FILES['profile_image'])) {
                        $username = $_POST['username']; 
                        
                        // Obtenir l'extension de l'image
                        $imageFileType = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
                        var_dump($imageFileType);
                    
                        // Définir le répertoire cible
                        $target_dir = "../public/img/profile/";
                        
                        // Renommer l'image avec le nom d'utilisateur et l'extension
                        $new_image_name = $username . '.' . $imageFileType;
                        $target_file = $target_dir . $new_image_name;
                    
                        // Vérification du type d'image
                        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                        if (in_array($imageFileType, $allowed_types)) {
                            // Déplacer le fichier téléchargé dans le dossier cible
                            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                                $user->profile_image = $target_file;
                            } else {
                                die('Erreur lors du téléchargement de l\'image');
                            }
                        } else {
                            die('Format d\'image non supporté');
                        }
                    }
                    
                    if ($user->verifyUser()) {
                        die('user already exists');
                    }
                    
                    if ($user->create()) {
                        header('location: ../index.php');
                    }
                    
                } else {
                   
                    header('location: ../display/users/createUser.php');
                }
            break;
        
        case 'login':
            $user-> email = $_POST['email'];
            $user-> password = $_POST['password'];
            $user_info = $user->login(); 
            // echo $user_info['password'];
            if ($user->password === $user_info['password']) {
                $_SESSION['user_id'] = $user_info['id'];
                $_SESSION['username'] = $user_info['username'];
                $_SESSION['profile_image'] = $user_info['profile_image'];
                $_SESSION['email'] = $user_info['email'];
                header('location: publicationsController.php?action=read');
            }
            else{
                echo 'Email or mot de passe wrong.';
            }
            break;

        case 'detailUpdate':
            $user -> email = $_SESSION['email'];
            $users= $user->login();
            require '../display/users/updateUser.php';
            break;
        
        case 'update':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $user->lastname = $_POST['lastname'];
                $user->firstname = $_POST['firstname'];
                $user->date_of_birth = $_POST['date_of_birth'];
                $user->username = $_POST['username'];
                $user->password = $_POST['password'];
                $user->email = $_SESSION['email'];
                // Gestion du téléchargement d'image
                if ($_FILES['profile_image']['name']) {
                    exec("rm " . $_SESSION['profile_image']);
                    $username = $_POST['username']; 
                    
                    // Obtenir l'extension de l'image
                    $imageFileType = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
                    var_dump($imageFileType);
                
                    // Définir le répertoire cible
                    $target_dir = "../public/img/profile/";
                    
                    // Renommer l'image avec le nom d'utilisateur et l'extension
                    $new_image_name = $username . '.' . $imageFileType;
                    $target_file = $target_dir . $new_image_name;
                
                    // Vérification du type d'image
                    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                    if (in_array($imageFileType, $allowed_types)) {
                        // Déplacer le fichier téléchargé dans le dossier cible
                        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                            $user->profile_image = $target_file;
                        } else {
                            die('Erreur lors du téléchargement de l\'image');
                        }
                    } else {
                        die('Format d\'image non supporté');
                    }
                }
                else {
                    $user->profile_image = $_SESSION['profile_image'];
                }
                if ($user->update()) {
                    header('location: userController.php?action=logout');
                }
            } else {
               
                header('location: userController?action=detailUpdate');
            }
            break;
        case 'delete':
            $user->id = $_SESSION['user_id'];
            if ($user->delete()){
                exec("rm " . $_SESSION['profile_image']);
                header('location: userController.php?action=logout');
            }else{
                echo "tsy nety nfafana";
            }

            break;
        case 'logout':
            session_start();
            unset($_SESSION['username']);
            unset($_SESSION['user_id']);
            unset($_SESSION['profile_image']);
            unset($_SESSION['email']);
            // Destruction de la session
            session_destroy();
            header('Location: ../index.php');
            break;
        // case 'demandeAmies':{

        //     break;
        // }
    }
?>