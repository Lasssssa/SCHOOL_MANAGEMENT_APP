<?php 
    session_start();
    $_SESSION['identifiedAdmin'] = false;
    $_SESSION['identifiedEnseignant'] = false;
    $_SESSION['identifiedEtudiant'] = false;
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <title>Connexion Étudiant </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="script.js"></script>
        <link href="styleLoginPageTest.css" rel="stylesheet">
    </head>   
    <body>
        <?php
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
                require_once("database.php");
                $dbConnection = dbConnect();
                if(isset($_POST['envoyer']) && isset($_POST['email']) && isset($_POST['password'])){
                    $email = $_POST['email'];
                    if(isValidUser($email, $dbConnection,"etudiant")){
                        $encryptedPassword = getEncryptedPassword($email, $dbConnection,"etudiant");
                        if(password_verify($_POST['password'], $encryptedPassword)){
                            $user = getUser($email, $dbConnection,$table);
                            $_SESSION['email'] = $user['mail_etu'];
                            $_SESSION['nom'] = $user['nom_etu'];
                            $_SESSION['prenom'] = $user['prenom_etu'];
                            $_SESSION['cycle'] = $user['nom_cycle'];
                            $_SESSION['annee_cursus'] = $user['annee_cursus'];
                            $_SESSION['id'] = $user['id_etu'];
                            $_SESSION['identifiedEtudiant'] = true;
                            header("Location: etudiant/persoEtudiant.php");
                            exit;
                        }else{
                            $_SESSION['erreurIdentification'] = true;
                        } 
                    }else if(isValidUser($email, $dbConnection,"enseignant")){
                        $encryptedPassword = getEncryptedPassword($email, $dbConnection,"enseignant");
                        if(password_verify($_POST['password'], $encryptedPassword)){
                            $user = getUser($email, $dbConnection,"enseignant");
                            $_SESSION['email'] = $user['mail_prof'];
                            $_SESSION['nom'] = $user['nom_prof'];
                            $_SESSION['prenom'] = $user['prenom_prof'];
                            $_SESSION['telephone'] = $user['telephone_prof'];
                            $_SESSION['id'] = $user['id_prof'];
                            $_SESSION['identifiedEnseignant'] = true;
                            header("Location: enseignant/persoEnseignant.php");
                            exit;
                        }else{
                            $_SESSION['erreurIdentification'] = true;
                        }
                    }else if(isValidUser($email, $dbConnection,"administrateur")){
                        $encryptedPassword = getEncryptedPassword($email, $dbConnection,"administrateur");
                        if(password_verify($_POST['password'], $encryptedPassword)){
                            $user = getUser($email, $dbConnection,"administrateur");
                            $$_SESSION['email'] = $user['mail_admin'];
                            $_SESSION['nom'] = $user['nom_admin'];
                            $_SESSION['prenom'] = $user['prenom_admin'];
                            $_SESSION['telephone'] = $user['telephone_admin'];
                            $_SESSION['identifiedAdmin'] = true;
                            header("Location: admin/persoAdmin.php");
                            exit;
                        }else{
                            $_SESSION['erreurIdentification'] = true;
                        }
                    }else{
                        $_SESSION['erreurIdentification'] = true;
                    }
                }
            ?>
            <div id="image">
                <img src="images/test.png">
            </div>

            <div id="centerLogin">
                <img src="images/logoIsenTest.png" width="300px">
                <div id="contentLogin">
                    <div id="center">
                        <img src="images/logoM.png" width="100px">
                    </div>
                    <div id="loginBox" class ="shadow">
                        <h1>Connexion</h1>
                        <form action="loginPage.php" method="post">
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">alternate_email</span></label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="Adresse Mail">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">lock</span></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                                </div>
                            </div>
                            <div class="form-check form-switch" id="ecarted">
                                <input class="form-check-input" type="checkbox" role="switch" id="showPassword" onchange="togglePassword()">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                            </div>
                            <div class="d-grid gap-2" id="test">
                                <button class="btn btn-primary" id="color" type="submit" name="envoyer">Me connecter</button>
                            </div>
                            <?php
                                if(isset($_SESSION['erreurIdentificationEtudiant'])){
                                    if($_SESSION['erreurIdentificationEtudiant']){
                                        echo '<p id="erreurParagraphe">Erreur d\'authentification</p>';
                                    }
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>


        
    </body>
</html>