<?php 
    session_start();
    $_SESSION['identifiedAdmin'] = false;
    $_SESSION['identifiedEnseignant'] = false;
    $_SESSION['identifiedEtudiant'] = false;
    $_SESSION['erreurIdentificationEnseignant'] = false;
    $_SESSION['erreurIdentificationEtudiant'] = false;
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <title>Connexion Administrateur </title>
        <link href="styleLoginPage.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="script.js"></script>
    </head>
    
    
    <!-- A réadapter -->
    <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        require_once("database.php");
        $dbConnection = dbConnect();
        if(isset($_POST['envoyer']) && isset($_POST['email']) && isset($_POST['password'])){
           $email = $_POST['email'];
           $table = "administrateur";
           if(isValidUser($email, $dbConnection,$table)){
                $encryptedPassword = getEncryptedPassword($email, $dbConnection,$table);
                if(password_verify($_POST['password'], $encryptedPassword)){
                    $user = getUser($email, $dbConnection,$table);
                    $_SESSION['email'] = $user['mail_admin'];
                    $_SESSION['nom'] = $user['nom_admin'];
                    $_SESSION['prenom'] = $user['prenom_admin'];
                    $_SESSION['telephone'] = $user['telephone_admin'];
                    $_SESSION['identifiedAdmin'] = true;
                    header("Location: admin/persoAdmin.php");
                    exit;
                }else{
                    $_SESSION['erreurIdentificationAdmin'] = true;
                } 
            }else{
                $_SESSION['erreurIdentificationAdmin'] = true;
            }
        }
    ?>  

    <body>
        <div id="bodyLogin">
            <div id="leftLogin">
                
            </div>
            <div id="centerLogin">
                <img src="images/logoIsen.png" width="220px">
                <div id="chooseRole">
                    <div class="colorRole">
                        <a href="loginEnseignant.php" id="white">Enseignant</a>
                    </div>
                    <div class="colorRoleCurrent">
                        <a href="loginAdmin.php" id="black">Administrateur</a>
                    </div>
                    <div class="colorRole">
                        <a href="loginEtudiant.php" id="white">Étudiant</a>
                    </div>
                </div>
                <div id="contentLogin">
                    <div id="titleLogin">
                        <img src="images/logoM.png" width="50px">
                    </div>
                    <div id="loginBox">
                        <form action="loginAdmin.php" method="post">
                            <div class="mb-3 row">
                                <label for="exampleInputEmail1" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">alternate_email</span></label>
                                <div class="col-sm-10">
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name ="email"placeholder="Adresse Mail">
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
                                <button class="btn btn-primary" type="submit" name="envoyer">Me connecter</button>
                            </div>
                            <div id ="ecarted">
                                <a href="forgotPassword.php">Mot de passe oublié ?</a>
                            </div>
                        </form>
                    </div>
                    <?php
                        if(isset($_SESSION['erreurIdentificationAdmin'])){
                            if($_SESSION['erreurIdentificationAdmin']){
                                echo '<p id="erreurParagraphe">Erreur d\'authentification</p>';
                            }
                        }
                    ?>
                </div>
            </div>
            <div id="rightLogin">

            </div>
            
        </div>
    </body>
</html>